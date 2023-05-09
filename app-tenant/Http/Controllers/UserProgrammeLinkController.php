<?php

namespace AppTenant\Http\Controllers;

use AppTenant\Http\Controllers\BaseController\BaseController;
use AppTenant\Models\user_programme_link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProgrammeLinkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


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
        //return $request->programme_id;
        $request->validate([
            'programme_id'  => 'required|int|exists:programmes,id',
            'date_from'     => 'required|date_format:"d/m/Y"',
            'date_to'       => 'required|date_format:"d/m/Y"|after_or_equal:date_from',
        ]);

        $date_from = Carbon::createFromFormat('d/m/Y', $request->get('date_from'));
        $date_to = Carbon::createFromFormat('d/m/Y', $request->get('date_to'));

        user_programme_link::updateOrCreate(
            ["user_id"  =>  t_profile()->id],
            [
                "user_id"           => t_profile()->id,
                "programme_id"      => $request->programme_id,
                "date_range_start"  => $date_from->format('Y-m-d'),
                "date_range_end"    => $date_to->format('Y-m-d'),
            ]

        );
        return $this->jsonSuccess('Date Range Changed Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \AppTenant\Models\user_programme_link  $user_programme_link
     * @return \Illuminate\Http\Response
     */
    public function show(user_programme_link $user_programme_link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AppTenant\Models\user_programme_link  $user_programme_link
     * @return \Illuminate\Http\Response
     */
    public function edit(user_programme_link $user_programme_link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \AppTenant\Models\user_programme_link  $user_programme_link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user_programme_link $user_programme_link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \AppTenant\Models\user_programme_link  $user_programme_link
     * @return \Illuminate\Http\Response
     */
    public function destroy(user_programme_link $user_programme_link)
    {
        //
    }
}
