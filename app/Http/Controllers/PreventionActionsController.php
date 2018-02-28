<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PreventionAction;
use App\Models\User;
use Datatables;
use Carbon\Carbon;

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
        if(\Auth::id() == $preventionaction->user_id){
            return view('tickets.preventions.actions.edit')
                ->withPreventionaction($preventionaction)
                ->withUsers(User::all()->pluck('name', 'id'));
        }else{
            Session()->flash('flash_message_warning', 'Bạn không có quyền sửa!');
            return redirect()->route("descriptions.show", $preventionaction->description_id)->with('tab', 'prevents');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markComplete($id)
    {
        $preventionaction = PreventionAction::findOrFail($id);

        if(\Auth::id() == $preventionaction->user_id) {
            $preventionaction->status = 'Closed';
            $preventionaction->save();

            Session()->flash('flash_message', 'Đã hoàn thành một hành động khắc phục!');
            return redirect()->route("descriptions.show", $preventionaction->description_id)->with('tab', 'prevents');
        }else{
            Session()->flash('flash_message_warning', 'Bạn không có quyền đánh dấu hoàn thành!');
            return redirect()->route("descriptions.show", $preventionaction->description_id)->with('tab', 'prevents');
        }
    }


    public function myActionsData()
    {
        $actions = PreventionAction::select(
            ['id', 'action', 'budget', 'user_id', 'description_id', 'status', 'when']
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
            ->editColumn('when', function ($actions) {
                return $actions->when ? with(new Carbon($actions->when))
                    ->format('d/m/Y') : '';
            })
            ->add_column('edit', '
                <a href="{{ route(\'preventionactions.edit\', $id) }}" class="btn btn-warning btn-xs" ><i class="fa fa-edit"></i></a>')
            ->add_column('markCompleted', '
                <a href="{{ route(\'preventionActionMarkComplete\', $id) }}" class="btn btn-success btn-xs" ><i class="fa fa-check-circle"></i></a>')
            ->make(true);
    }
}
