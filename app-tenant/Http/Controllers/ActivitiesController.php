<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\Activity;
use AppTenant\Models\Statical\Format;
use Illuminate\Http\Request;

class ActivitiesController extends BaseController
{
    /**
     * Get previous activities
     * @param Request $request
     * @return array
     */
    public function loadPrevious(Request $request)
    {
        $request->validate([
            'before'  => 'int|min:1|max:200000000',
        ]);
        $activities_count = 25;
        $activities = Activity::with('profile')
                        ->visibleForCurrentUser()
                        ->where('id', '<', $request->get('before'))
                        ->take($activities_count)
                        ->latest()
                        ->get();
        
        $activities = $activities->map(function($item) {
                    $item->date_created = date(Format::DATE_WITH_TIME_READABLE, strtotime($item->created_at));
                    $item->author_name = $item->profile->name;
                    return $item->only(['id', 'text', 'img', 'date_created', 'author_name']);
                });
                
        return $this->jsonSuccess('', [
            'activities'        => $activities,
            'has_other_items'   => $activities->count() == $activities_count,
        ]);
    }
}
