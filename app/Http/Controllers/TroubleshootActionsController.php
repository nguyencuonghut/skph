<?php

namespace App\Http\Controllers;

use App\Models\Troubleshoot;
use App\Models\TroubleshootAction;
use App\Models\User;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;

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
        $troubleshoot = Troubleshoot::findOrFail($troubleshootaction->description_id);
        if((\Auth::id() == $troubleshootaction->user_id)  || (\Auth::id() == $troubleshoot->troubleshooter_id)){
            return view('tickets.troubleshoots.actions.edit')
                ->withTroubleshootaction($troubleshootaction)
                ->withUsers(User::all()->pluck('name', 'id'));
        }else{
            Session()->flash('flash_message_warning', 'Bạn không có quyền cập nhật!');
            return redirect()->route("descriptions.show", $troubleshootaction->description_id)->with('tab', 'troubleshoot');
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markComplete($id)
    {
        $troubleshootaction = TroubleshootAction::findOrFail($id);
        if(\Auth::id() == $troubleshootaction->user_id) {
            $troubleshootaction->status = 'Closed';
            $troubleshootaction->save();

            Session()->flash('flash_message', 'Đã hoàn thành một hành động khắc phục!');
            return redirect()->route("descriptions.show", $troubleshootaction->description_id)->with('tab', 'troubleshoot');
        }else{
            Session()->flash('flash_message_warning', 'Bạn không có quyền đánh dấu hoàn thành!');
            return redirect()->route("descriptions.show", $troubleshootaction->description_id)->with('tab', 'troubleshoot');
        }
    }

    public function myActionsData()
    {
        $actions = TroubleshootAction::select(
            ['id', 'action', 'user_id', 'description_id', 'status', 'deadline']
        )->where('user_id', \Auth::id())->orderBy('id', 'desc');
        return Datatables::of($actions)
            ->addColumn('action', function ($actions) {
                return $actions->action;

            })
            ->editColumn('user_id', function ($actions) {
                return $actions->user->name;
            })
            ->editColumn('status', function ($actions) {
                return $actions->status;
            })
            ->editColumn('deadline', function ($actions) {
                return $actions->deadline ? with(new Carbon($actions->deadline))
                    ->format('d/m/Y') : '';
            })
            ->add_column('edit', '
                <a href="{{ route(\'troubleshootactions.edit\', $id) }}" class="btn btn-warning btn-xs" ><i class="fa fa-edit"></i></a>')
            ->add_column('markCompleted', '
                <a href="{{ route(\'troubleshootActionMarkComplete\', $id) }}" class="btn btn-success btn-xs" ><i class="fa fa-check-circle"></i></a>')
            ->make(true);
    }
}
