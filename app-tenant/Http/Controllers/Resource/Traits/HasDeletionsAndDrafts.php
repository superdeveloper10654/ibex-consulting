<?php

namespace AppTenant\Http\Controllers\Resource\Traits;

use AppTenant\Models\Activity;

trait HasDeletionsAndDrafts
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = $this->resource_model::findOrFail($id);
        $link = $resource->link();
        $resource->delete();
        Activity::resource("Removed", $resource);

        return redirect($link);
    }

    /**
     * Remove the specified drafted resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyDraft($id)
    {
        $resource = $this->resource_model::findMineDraftedOrFail($id);
        $link = $resource->link();
        $resource->delete();

        return redirect($link);
    }
}