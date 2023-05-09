<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Profile;
use App\Models\Statical\Constant;
use AppTenant\Models\Statical\Department;
use AppTenant\Models\Statical\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfilesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::where('email', '<>', env('SUPPORT_PROFILE_EMAIL'))->paginate(config('app.pagination_size'));

        return t_view('profiles.index', [
            'profiles'  => $profiles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (admin_profile()->registeredUsersLimitReached()) {
            abort(404);
        }

        if (isPaidSubscription()) {
            $roles = Role::getForAdminUsers();
            $departments = Department::getArray();
        } else {
            $roles = [
                Role::CONTRACTOR_ID     => Role::CONTRACTOR,
                Role::SUBCONTRACTOR_ID  => Role::SUBCONTRACTOR
            ];
            $departments = [Department::COMMERCIAL_ID   => Department::COMMERCIAL];
        }

        return t_view('profiles.create', [
            'departments'   => $departments,
            'roles'         => $roles,
            'contractors'   => Profile::where('role', Role::CONTRACTOR_ID)->get(),
        ]);
    }

    /**
     * Show the form for creating a Subcontractor profile
     *
     * @return \Illuminate\Http\Response
     */
    public function createSubcontractor($contractor_profile_id)
    {
        if (admin_profile()->registeredUsersLimitReached()) {
            abort(404);
        }

        $contractor_profile = Profile::find($contractor_profile_id);

        if (!$contractor_profile || !$contractor_profile->isContractor()) {
            abort(404);
        }

        if (isPaidSubscription()) {
            $departments = Department::getArray();
        } else {
            $departments = [Department::COMMERCIAL_ID   => Department::COMMERCIAL];
        }

        $roles = [Role::SUBCONTRACTOR_ID => Role::SUBCONTRACTOR];

        return t_view('profiles.create', [
            'contractor_profile'    => $contractor_profile,
            'departments'           => $departments,
            'roles'                 => $roles,
            'contractors'           => Profile::where('role', Role::CONTRACTOR_ID)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (admin_profile()->registeredUsersLimitReached()) {
            abort(404);
        }

        $optional_fields = [];
        $existing_contractors = Profile::where('role', Role::CONTRACTOR_ID)->get();

        if (isPaidSubscription()) {
            $roles = Role::getForAdminUsers();
            $departments = Department::getArray();

        } else {
            $roles = [
                Role::CONTRACTOR_ID     => Role::CONTRACTOR,
                Role::SUBCONTRACTOR_ID  => Role::SUBCONTRACTOR
            ];

            if (!$existing_contractors->isEmpty()) {
                unset($roles[Role::CONTRACTOR_ID]);
            }

            $departments = [Department::COMMERCIAL_ID   => Department::COMMERCIAL];
        }

        $request->validate(array_merge([
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'nullable|string|max:255',
            'email'                 => [
                'required',
                'string',
                'email',
                Rule::unique('profiles')
                // Rule::unique('profiles')->whereNull('deleted_at'), database change required
            ],
            'password'              => 'required|confirmed|min:8',
            'organisation'          => 'nullable|string|max:255',
            'department'            => [
                (isPaidSubscription() ? 'required' : 'nullable'),
                ('in:' . implode(',', array_keys($departments)))
            ],
            'role'                  => ('required|in:' . implode(',', array_keys($roles))),
            'parent_id'             => ('required_if:role,' . Role::SUBCONTRACTOR_ID .'|in:' . $existing_contractors->implode('id', ',')),
            'avatar'                => 'required|image|mimes:jpg,jpeg,png|max:1024',
        ], $optional_fields));

        $profile = new Profile();
        $this->fillProfileDataFromRequest($profile, $request, Constant::ACTION_STORE);
        $profile->team_users_count = env('TEAM_USERS_COUNT_MIN');
        $profile->save();

        return redirect()->route('profiles.show', $profile->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id == Constant::ME) {
            $profile = t_profile();
        } else {
            $profile = Profile::findOrFail($id);

            if ($id == t_profile()->id) {
                return redirect( t_route('profiles.show', Constant::ME));
            }

            if ($profile->email == env('SUPPORT_PROFILE_EMAIL')) {
                abort(404);
            }
        }

        return t_view('profiles.show', [
            'profile' => $profile
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($id == Constant::ME) {
            $profile = t_profile();
        } else {
            $profile = Profile::findOrFail($id);

            if ($id == t_profile()->id) {
                return redirect( t_route('profiles.edit', Constant::ME));
            }

            if ($profile->email == env('SUPPORT_PROFILE_EMAIL')) {
                abort(404);
            }
        }

        $existing_contractors = Profile::where('role', Role::CONTRACTOR_ID)->where('id', '<>', $profile->id)->get();

        if ($profile->isAdmin()) {
            $roles = [Role::ADMIN_ID => Role::ADMIN];
            $departments = Department::getArray();
        } else {
            if (isPaidSubscription()) {
                $roles = Role::getForAdminUsers();
                $departments = Department::getArray();
            } else {
                $roles = [
                    Role::CONTRACTOR_ID     => Role::CONTRACTOR,
                    Role::SUBCONTRACTOR_ID  => Role::SUBCONTRACTOR
                ];
    
                // only single contractor should be in Demo version
                if (!$existing_contractors->isEmpty() || !$profile->isContractor()) {
                    unset($roles[Role::CONTRACTOR_ID]);
                }

                $departments = [Department::COMMERCIAL_ID   => Department::COMMERCIAL];
            }
        }

        return t_view('profiles.edit', [
            'profile_id'    => $id,
            'profile'       => $profile,
            'departments'   => $departments,
            'roles'         => $roles,
            'contractors'   => $existing_contractors,
        ]);
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
        if ($id == Constant::ME) {
            $profile = t_profile();
        } else {
            $profile = Profile::findOrFail($id);

            if ($id == t_profile()->id) {
                return redirect( t_route('profiles.edit', Constant::ME));
            }

            if (!t_profile()->isAdmin() || $profile->email == env('SUPPORT_PROFILE_EMAIL')) {
                abort(404);
            }
        }

        $optional_fields = [];
        $existing_contractors = Profile::where('role', Role::CONTRACTOR_ID)->where('id', '<>', $profile->id)->get();

        if ($profile->isAdmin()) {
            $roles = [Role::ADMIN_ID => Role::ADMIN];
            $departments = Department::getArray();
        } else {
            if (isPaidSubscription()) {
                $roles = Role::getForAdminUsers();
                $departments = Department::getArray();
            } else {
                $roles = [
                    Role::CONTRACTOR_ID     => Role::CONTRACTOR,
                    Role::SUBCONTRACTOR_ID  => Role::SUBCONTRACTOR
                ];
    
                if (!$existing_contractors->isEmpty() || !$profile->isContractor()) {
                    unset($roles[Role::CONTRACTOR_ID]);
                }

                $departments = [Department::COMMERCIAL_ID   => Department::COMMERCIAL];
            }
        }

        $request->validate(array_merge([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'nullable|string|max:255',
            'email'             => 'required|string|email',
            'organisation'      => 'nullable|string|max:255',
            // 'department'        => [
            //     (isPaidSubscription() ? 'required' : 'nullable'),
            //     ('in:' . implode(',', array_keys($departments)))
            // ],
            // 'role'              => 'required|in:' . implode(',', array_keys($roles)),
            'parent_id'         => ('required_if:role,' . Role::SUBCONTRACTOR_ID .'|in:' . $existing_contractors->implode('id', ',')),
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'organisation_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password'          => 'nullable|confirmed|min:8',
        ], $optional_fields));

        $this->fillProfileDataFromRequest($profile, $request,Constant::ACTION_UPDATE);
        $profile->update();

        return $this->jsonSuccess('Updated');
    }

    /**
     * Fill profile fields using request fields
     * 
     * @param  \AppTenant\Models\Profile  $profile
     * @param  \Illuminate\Http\Request  $request
     * @param string $action store/update
     */
    protected function fillProfileDataFromRequest(Profile $profile, Request $request, $action)
    {
        $profile->first_name = $request->get('first_name');
        $profile->last_name = $request->get('last_name');
        $profile->email = $request->get('email');
        $profile->organisation = $request->get('organisation');

        if ($action == Constant::ACTION_STORE) {
            $profile->department = !isPaidSubscription() ? Department::COMMERCIAL_ID : $request->get('department');
            $profile->role = $request->get('role');
        }

        if ($request->get('password')) {
            $profile->password = Hash::make($request->get('password'));
        }

        if ($profile->role == Role::SUBCONTRACTOR_ID) {
            $profile->parent_id = $request->get('parent_id');
        }

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = Str::random() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = config('path.images.profiles') . "/$avatarName";
            Storage::disk('public')->put($avatarPath, $avatar->get());

            // remove old avatar
            $file = config('path.images.profiles') . $profile->avatar;
            if (!empty($profile->avatar) && file_exists($file) && $profile->avatar != Constant::IMG_PATH_PUBLIC_SUPPORT) {
                Storage::disk('public')->delete($file);
            }

            $profile->avatar = $avatarName;
        }

        if ($profile->isContractor()) {
            $oraganisation_logo_old = !empty($profile->organisation_logo) ? (config('path.files.settings') . '/' . $profile->organisation_logo) : '';
            if ($request->get('organisation_logo_delete') && $oraganisation_logo_old && Storage::disk('public')->exists($oraganisation_logo_old)) {
                Storage::disk('public')->delete($oraganisation_logo_old);
                $profile->organisation_logo = null;
            }
            if ($request->file('organisation_logo')) {
                // maybe remove old avatar
                if ($oraganisation_logo_old && Storage::disk('public')->exists($oraganisation_logo_old)) {
                    Storage::disk('public')->delete($oraganisation_logo_old);
                }

                $logo = $request->file('organisation_logo');
                $name = Str::random() . '.' . $logo->getClientOriginalExtension();
                $path = config('path.files.settings') . "/$name";
                Storage::disk('public')->put($path, $logo->get());

                $profile->organisation_logo = $name;
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);

        if ((!t_profile()->isAdmin() && t_profile()->id != $id) || $profile->email == env('SUPPORT_PROFILE_EMAIL') || $profile->isAdmin()) {
            abort(404);
        }

        $profile->subcontractors()->delete();
        $profile->delete();

        return redirect()->route('profiles');
    }

    public function get_task_locks(Request $request)
    {
        $programme_id = 240;
        $guid = $request->guid;
        $profile = Profile::where('last_programme_id', $programme_id)->where('active_task_guid', $guid)->get();
        $locked = true;
        if ($profile->isEmpty()) {
            $locked = false;
            // Lock it
            $guid = $guid;
            $user_id = t_profile()->id;
            $time = time();
            Profile::where('id', $user_id)->update(['active_task_guid' => $guid, 'active_task_lock_time' => $time]);
        }
        $payload = array("locked" => $locked, "user" => $profile);
        echo json_encode($payload);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $profile = t_profile();

        if (!(Hash::check($request->get('current_password'), $profile->password))) {
            return $this->jsonError("Your Current password does not matches with the password you provided. Please try again."); 
        }

        $profile->password = Hash::make($request->get('new_password'));
        $profile->update();

        return $this->jsonSuccess('Password updated successfully');
    }
}
