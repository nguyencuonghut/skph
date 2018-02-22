<?php

namespace App\Http\Controllers;

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
        //
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
        //
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
    public function assignProposer($id, Request $request)
    {
        $this->preventions->assignProposer($id, $request);
        Session()->flash('flash_message', 'Giao cho thành công!');
        return redirect()->back();
    }
}
