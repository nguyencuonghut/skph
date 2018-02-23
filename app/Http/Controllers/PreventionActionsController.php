<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreventionAction;
use App\Models\User;

class PreventionActionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id)
    {
        $prevention_action = new PreventionAction();
        $prevention_action->action = $request->action;
        $prevention_action->budget = $request->budget;
        $prevention_action->user_id = $request->user_incharge_id;
        $prevention_action->where = $request->where;
        $prevention_action->when = $request->when;
        $prevention_action->how = $request->how;
        $prevention_action->description_id = $id;
        $prevention_action->status = 'Open';
        $prevention_action->save();

        return redirect()->route("descriptions.show", $id)->with('tab', 'prevents');
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
        $preventionaction = PreventionAction::findOrFail($id);
        return view('tickets.preventions.actions.edit')
            ->withPreventionaction($preventionaction)
            ->withUsers(User::all()->pluck('name', 'id'));
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
        $preventionaction = PreventionAction::findOrFail($id);
        $preventionaction->action = $request->action;
        $preventionaction->budget = $request->budget;
        $preventionaction->user_id = $request->user_id;
        $preventionaction->where = $request->where;
        $preventionaction->when = $request->when;
        $preventionaction->how = $request->how;
        $preventionaction->status = $request->status;
        $preventionaction->save();

        Session()->flash('flash_message', 'Cập nhật biện pháp phòng ngừa thành công');
        return redirect()->route("descriptions.show", $preventionaction->description_id)->with('tab', 'prevents');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
