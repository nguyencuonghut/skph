<?php

namespace App\Http\Controllers;

use App\Models\TroubleshootAction;
use App\Models\User;
use Illuminate\Http\Request;

class TroubleshootActionsController extends Controller
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
        $troubleshoot_action = new TroubleshootAction();
        $troubleshoot_action->action = $request->action;
        $troubleshoot_action->user_id = $request->user_id;
        $troubleshoot_action->status = 'Open';
        $troubleshoot_action->deadline = $request->deadline;
        $troubleshoot_action->description_id = $id;
        $troubleshoot_action->save();

        return redirect()->route("descriptions.show", $id)->with('tab', 'troubleshoot');;
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
        $troubleshootaction = TroubleshootAction::findOrFail($id);
        return view('tickets.troubleshoots.actions.edit')
            ->withTroubleshootaction($troubleshootaction)
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
        $troubleshootaction = TroubleshootAction::findOrFail($id);
        $troubleshootaction->action = $request->action;
        $troubleshootaction->user_id = $request->user_id;
        $troubleshootaction->deadline = $request->deadline;
        $troubleshootaction->status = $request->status;
        $troubleshootaction->save();

        Session()->flash('flash_message', 'Cập nhật biện pháp khắc phục thành công');
        return redirect()->route("descriptions.show", $troubleshootaction->description_id)->with('tab', 'troubleshoot');
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
