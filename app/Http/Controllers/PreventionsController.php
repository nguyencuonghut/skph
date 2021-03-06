<?php

namespace App\Http\Controllers;

use App\Models\Description;
use App\Models\ReasonType;
use App\Models\User;
use App\Models\Prevention;
use Illuminate\Http\Request;
use App\Repositories\Prevention\PreventionRepositoryContract;
class PreventionsController extends Controller
{
    protected $request;
    protected $preventions;

    public function __construct(
        PreventionRepositoryContract $preventions
    )
    {
        $this->preventions = $preventions;
    }

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prevention = Prevention::findOrFail($id);
        return view('tickets.preventions.edit')
            ->withPrevention($prevention)
            ->withReasonTypes($this->preventions->getAllReasonTypesWithDescription())
            ->withUsers(User::all()->pluck('name', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->preventions->update($id, $request);
        Session()->flash('flash_message', 'Cập nhật thành công!');
        return redirect()->route("descriptions.show", $id)->with('tab', 'prevents');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function assignProposer($id, Request $request)
    {
        $this->preventions->assignProposer($id, $request);
        Session()->flash('flash_message', 'Giao cho thành công!');
        return redirect()->back()->with('tab', 'prevents');
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function assignApprover($id, Request $request)
    {
        $this->preventions->assignApprover($id, $request);
        Session()->flash('flash_message', 'Giao cho thành công!');
        return redirect()->back()->with('tab', 'prevents');
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function approvePrevention($id, $result)
    {
        $this->preventions->approvePrevention($id, $result);
        if('Đồng ý' == $result){
            Session()->flash('flash_message', 'Biện pháp phòng ngừa đã được phê duyệt!');
        }else {
            Session()->flash('flash_message', 'Biện pháp phòng ngừa đã bị từ chối!');
            //Update the status
            $description = Description::findOrFail($id);
            $description->status_id = 3; //Phiếu CAR chua được duyệt hành động KPPN
            $description->save();
        }
        return redirect()->back()->with('tab', 'prevents');
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function approveRootcause($id, $result)
    {
        $this->preventions->approveRootcause($id, $result);
        if('Đồng ý' == $result){
            Session()->flash('flash_message', 'Nguyên nhân gốc rễ đã được phê duyệt!');
        }else {
            //Update the status
            $description = Description::findOrFail($id);
            $description->status_id = 2; //Phiếu CAR chua được duyệt nguyên nhân gốc rễ
            $description->save();
            Session()->flash('flash_message', 'Nguyên nhân gốc rễ đã bị từ chối!');
        }
        return redirect()->back()->with('tab', 'prevents');
    }
}
