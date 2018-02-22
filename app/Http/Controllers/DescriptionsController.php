<?php

namespace App\Http\Controllers;

use App\Models\Prevention;
use App\Models\Troubleshoot;
use App\Models\TroubleshootAction;
use App\Models\PreventionAction;
use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Source;
use App\Models\Action;
use App\Models\User;
use App\Models\Description;
use App\Models\Ticket;
use App\Repositories\Description\DescriptionRepositoryContract;
use App\Repositories\User\UserRepositoryContract;
use Datatables;
use Carbon\Carbon;

class DescriptionsController extends Controller
{
    protected $request;
    protected $descriptions;
    protected $users;

    public function __construct(
        DescriptionRepositoryContract $descriptions,
        UserRepositoryContract $users
    )
    {
        $this->descriptions = $descriptions;
        $this->users = $users;

        $this->middleware('description.create', ['only' => ['create']]);
        $this->middleware('description.assigned', ['only' => ['updateAssign']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tickets.descriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.descriptions.create')
            ->withUsers(User::all()->pluck('name', 'id'))
            ->withAreas(Area::all()->pluck('name', 'id'))
            ->withSources(Source::all()->pluck('name', 'id'))
            ->withActions(Action::all()->pluck('name', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getInsertedId = $this->descriptions->create($request);

        return redirect()->route("descriptions.show", $getInsertedId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $description = Description::findOrFail($id);
        $troubleshoot = Troubleshoot::findOrFail($id);
        $ticket = Ticket::findOrFail($id);
        $prevention = Prevention::findOrFail($id);
        return view('tickets.descriptions.show')
            ->withTicket($ticket)
            ->withDescription($description)
            ->withTroubleshoot($troubleshoot)
            ->withUsers($this->users->getAllUsers())
            ->withActions(TroubleshootAction::all()->where('description_id', $id))
            ->withPrevention($prevention)
            ->withPreventionactions(PreventionAction::all()->where('description_id', $id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $description = Description::findOrFail($id);
        return view('tickets.descriptions.edit')
            ->withDescription($description)
            ->withUsers(User::all()->pluck('name', 'id'))
            ->withAreas(Area::all()->pluck('name', 'id'))
            ->withSources(Source::all()->pluck('name', 'id'))
            ->withActions(Action::all()->pluck('name', 'id'));
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
        $this->descriptions->update($id, $request);
        Session()->flash('flash_message', 'Ticket successfully updated');
        return redirect()->route("descriptions.show", $id);
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
    public function leaderConfirm($id, Request $request)
    {
        $this->descriptions->leaderConfirm($id, $request);
        Session()->flash('flash_message', 'Xác nhận thành công');
        return redirect()->back();
    }
    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function effectivenessAsset($id, Request $request)
    {
        $this->descriptions->effectivenessAsset($id, $request);
        Session()->flash('flash_message', 'Đánh giá hiệu quả thành công');
        return redirect()->back();
    }

    public function anyData()
    {
        $descriptions = Description::select(
            ['id', 'title', 'issue_date', 'answer_date', 'source_id', 'user_id']
        );
        return Datatables::of($descriptions)
            ->addColumn('titlelink', function ($descriptions) {
                return '<a href="descriptions/' . $descriptions->id . '" ">' . $descriptions->title . '</a>';
            })
            ->editColumn('issue_date', function ($descriptions) {
                return $descriptions->issue_date ? with(new Carbon($descriptions->issue_date))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('answer_date', function ($descriptions) {
                return $descriptions->answer_date ? with(new Carbon($descriptions->answer_date))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('source_id', function ($descriptions) {
                return $descriptions->source->name;
            })
            ->editColumn('user_id', function ($descriptions) {
                return $descriptions->user->name;
            })->make(true);
    }
}
