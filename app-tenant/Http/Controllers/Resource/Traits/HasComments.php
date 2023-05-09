<?php

namespace AppTenant\Http\Controllers\Resource\Traits;

use AppTenant\Events\CommentCreated;
use AppTenant\Models\Activity;
use Illuminate\Http\Request;

trait HasComments
{
    /**
     * Resource route for adding comment
     * @param Request $request
     * @param int $id of the resource
     * @return array jsonSuccess
     */
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'new-comment'  => 'required|string|min:1|max:10000'
        ]);

        $resource = $this->resource_model::findOrFail($id);

        if ($resource->isDraft()) {
            abort(404);
        }

        $comment = $resource->comment($request->get('new-comment'));
        Activity::resource("Added comment for", $resource);
        CommentCreated::dispatch($comment);

        return $this->jsonSuccess();
    }
}