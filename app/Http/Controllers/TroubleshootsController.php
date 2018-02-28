<?php

namespace App\Http\Controllers;

use App\Models\Responsibility;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Troubleshoot;
use App\Repositories\Troubleshoot\TroubleshootRepositoryContract;

class TroubleshootsController extends Controller
{
    protected $request;
    protected $troubleshoots;

    public function __construct(
        TroubleshootRepositoryContract $troubleshoots
    )
    {
        $this->troubleshoots = $troubleshoots;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $troubleshoot = Troubleshoot::findOrFail($id);
        return view('tickets.troubleshoots.edit')
            ->withTroubleshoot($troubleshoot)
            ->withUsers(User::all()->pluck('name', 'id'))
            ->withResponsibilities(Responsibility::all()->pluck('name', 'id'))
            ->withLevels(Level::all()->pluck('name', 'id'));
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
        $this->troubleshoots->update($id, $request);
        Session()->flash('flash_message', 'Cập nhật thành công!');
        return redirect()->route("descriptions.show", $id)->with('tab', 'troubleshoot');
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
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function assignTroubleshooter($id, Request $request)
    {
        $this->troubleshoots->assignTroubleshooter($id, $request);
        Session()->flash('flash_message', 'Giao cho thành công!');
        return redirect()->back()->with('tab', 'troubleshoot');
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function approve($id, $result)
    {
        $this->troubleshoots->approve($id, $result);
        Session()->flash('flash_message', 'Biện pháp khắc phục đã được phê duyệt!');
        return redirect()->back()->with('tab', 'troubleshoot');
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function evaluate($id, $result)
    {
        $this->troubleshoots->evaluate($id, $result);
        Session()->flash('flash_message', 'Đánh giá thành công!');
        return redirect()->back()->with('tab', 'prevents');
    }
}
