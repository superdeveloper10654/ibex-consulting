<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Events\FileCreated;
use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Activity;
use AppTenant\Models\ProfileFolder;
use AppTenant\Models\Statical\Format;
use AppTenant\Models\Statical\MediaCollection;
use AppTenant\Models\Upload;
use AppTenant\Services\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UploadsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = t_profile();
        $files = $profile->getMedia(MediaCollection::COLLECTION_ROOT);
        $folders = $profile->getRegisteredMediaCollections();

        if (isPaidSubscription()) {
            $space_used_percents = 0;
        } else {
            $space_used_bytes = Uploads::totalSpaceUsed(true);
            $space_available_bytes = Uploads::totalSpaceAvailable(true);
            $space_used_percents = ceil($space_used_bytes / $space_available_bytes * 100);
        }

        return t_view('uploads.index', [
            'folders'               => $folders,
            'files'                 => $files,
            'space_used'            => Uploads::totalSpaceUsed(),
            'space_available'       => Uploads::totalSpaceAvailable(),
            'space_used_percents'   => $space_used_percents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file_size = isPaidSubscription() 
            ? env('MAX_UPLOAD_FILE_SIZE_KB')
            : env('DEMO_MAX_UPLOAD_FILE_SIZE_KB');
            
        $request->validate([
            'new_files'             => "required",
            'new_files.*'           => "required|file|max:$file_size",
            'upload_to_folder'      => [
                'required',
                'string:255',
                Rule::in(t_profile()->getRegisteredMediaCollections()->pluck('name')),
            ],
            'resourse_id'           => 'integer',
        ]);

        $profile = t_profile();
        $files = $request->allFiles();
        $folder = $request->get('upload_to_folder');

        if (isDemoSubscription()) {
            $files_size_bytes = array_reduce($files['new_files'], function($total_size, $file) {
                return $total_size + $file->getSize();
            }, 0);
            $total_available_bytes = Uploads::totalSpaceAvailable(true);

            if ($files_size_bytes >= $total_available_bytes) {
                $file_or_files = count($files['new_files']) > 1 ? 'files' : 'file';
                return $this->jsonError("There's no enough free space to upload the $file_or_files");
            }
        }

        foreach ($files['new_files'] as $file) {
            $name = $file->getClientOriginalName();

            if (!empty($request->get('resource_id'))) {
                $uploaded_file = $profile->addMedia($file->path())
                    ->usingFileName($name)
                    ->withCustomProperties([
                        'resource_id'   => $request->get('resource_id')
                    ])
                    ->toMediaCollection($folder);
            } else {
                $uploaded_file = $profile->addMedia($file->path())
                    ->usingFileName($name)
                    ->toMediaCollection($folder);
            }

            FileCreated::broadcast($uploaded_file);
            Activity::add("Uploaded new file '$name'", t_route('uploads.folder', $folder, false), Upload::$activity_icon);
        }

        return $this->jsonSuccess('Successfully uploaded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'file_id' => [
                'required',
                'integer',
                Rule::exists('media', 'id')->where(function ($query) {
                    return $query->where('model_id', t_profile()->id)
                                ->where('model_type', t_profile()::class);
                }),
            ]
        ]);

        $media = Media::findOrFail($request->get('file_id'));
        $file_name = $media->file_name;
        $folder = $media->collection_name;
        $media->delete();
        Activity::add("Removed uploaded file '$file_name'", t_route('uploads.folder', $folder, false), Upload::$activity_icon);
        
        return $this->jsonSuccess();
    }


    /**
     * Return files for specific folder
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function filesAjax(Request $request)
    {
        $request->validate([
            'folder'  => [
                'required',
                'string:255',
                Rule::in(t_profile()->getRegisteredMediaCollections()->pluck('name')),
            ],
        ]);

        $media =  Media::where('collection_name', $request->get('folder'))
                            ->where(function($query) {
                                $query->whereNotNull('custom_properties->resource_id')
                                        ->orWhere('model_id', t_profile()->id);
                            })
                            ->get();
        $media_sanitized = $media->map(function ($item) {
                                    $item = $item->only(['id', 'file_name', 'created_at', 'human_readable_size']);
                                    $item['link'] = t_route('uploads.download', $item['id']);
                                    $item['created_at'] = date(Format::DATE_WITH_TIME_READABLE, strtotime($item['created_at']));
                                    return $item;
                                });

        return $this->jsonSuccess('', $media_sanitized);
    }

    /**
     * Rename specific file files for specific folder
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileRename(Request $request)
    {
        $request->validate([
            'rename_file_id'    => [
                'required',
                'integer',
                Rule::exists('media', 'id')->where(function ($query) {
                    return $query->where('model_id', t_profile()->id)
                                ->where('model_type', t_profile()::class);
                }),
            ],
            'new_file_name'     => 'required:string|max:255',
        ]);

        $media = Media::findOrFail($request->get('rename_file_id'));
        $old_file_name = $media->file_name;
        $new_file_name = $request->get('new_file_name');
        $folder_name = $media->collection_name;
        $media->file_name = $new_file_name;
        $media->save();

        Activity::add("Renamed uploaded file '$old_file_name' to '$new_file_name'", t_route('uploads.folder', $folder_name, false), Upload::$activity_icon);
        
        return $this->jsonSuccess();
    }

    /**
     * Return response for downloading specific file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $id = (int) $id;
        $item = Media::findOrFail($id);

        if ($item->model_id !== t_profile()->id) {
            abort(404);
        }
        
        return response()->download($item->getPath(), $item->file_name);
    }

    /**
     * Create a new folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name'   => [
                'required',
                'string',
                'max:255',
                Rule::unique('profile_folders')->where(function ($query) {
                    return $query->where('profile_id', t_profile()->id);
                }),
                Rule::notIn(t_profile()->getRegisteredMediaCollections()->pluck('name')),
            ]
        ]);

        $folder_name = $request->get('folder_name');

        $res = ProfileFolder::create([
            'profile_id'    => t_profile()->id,
            'folder_name'   => $folder_name,
        ]);

        if ($res) {
            Activity::add("Created new Uploads folder: $folder_name", t_route('uploads.folder', $folder_name, false), Upload::$activity_icon);

            return $this->jsonSuccess();
        } else {
            return $this->jsonError();
        }
    }

    /**
     * Remove a folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFolder(Request $request)
    {
        $request->validate(
            [
                'name'   => [
                    'required',
                    'string',
                    'max:255',
                    Rule::exists('profile_folders', 'folder_name')->where(function ($query) {
                        return $query->where('profile_id', t_profile()->id);
                    }),
                ]
            ], 
            ['name.exists' => "You can't delete system-created folders"],
        );
        $folder_name = $request->get('name');
        $res = ProfileFolder::where('folder_name', $folder_name)
                            ->where('profile_id', t_profile()->id)
                            ->delete();

        t_profile()->clearMediaCollection($folder_name);
        Activity::add("Removed folder from Uploads: $folder_name", t_route('uploads', [], false), Upload::$activity_icon);

        return $res ? $this->jsonSuccess() : $this->jsonError();
    }

    /**
     * Rename a folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function renameFolder(Request $request)
    {
        $request->validate(
            [
                'rename_folder_name'    => [
                    'required',
                    'string',
                    'max:255',
                    Rule::exists('profile_folders', 'folder_name')->where(function ($query) {
                        return $query->where('profile_id', t_profile()->id);
                    }),
                ],
                'new_folder_name'           => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('profile_folders', 'folder_name')->where(function ($query) {
                        return $query->where('profile_id', t_profile()->id);
                    }),
                    Rule::notIn(t_profile()->getRegisteredMediaCollections()->pluck('name')),
                ]
            ], 
            ['name.exists' => "You can't rename system-created folders"],
        );

        $folder = ProfileFolder::where('folder_name', $request->get('rename_folder_name'))
                            ->where('profile_id', t_profile()->id)
                            ->first();
        $old_name = $folder->folder_name;
        $new_name = $request->get('new_folder_name');
        $folder->folder_name = $new_name;
        $folder->save();
        Activity::add("Removed Uploads folder from '$old_name' to '$new_name'", t_route('uploads.folder', $new_name, false), Upload::$activity_icon);

        return $this->jsonSuccess();
    }
}