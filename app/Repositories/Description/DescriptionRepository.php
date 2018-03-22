<?php
namespace App\Repositories\Description;

use App\Models\Department;
use App\Models\Prevention;
use App\Models\Description;
use App\Models\Troubleshoot;
use Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;

/**
 * Class TaskRepository
 * @package App\Repositories\Description
 */
class DescriptionRepository implements DescriptionRepositoryContract
{
    const CREATED = 'created';
    const UPDATED_ASSIGN = 'updated_assign';
    const EFFECTIVENESS_ASSET = 'effectiveness_asset';
    const LEADER_APPROVED = 'leader_approved';
    const LEADER_REJECTED = 'leader_rejected';

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Description::findOrFail($id);
    }

    /**
     * @param $requestData
     * @return mixed
     */
    public function create($requestData)
    {
        // Save the attached file
        $filename = NULL;
        if($requestData->hasFile('image'))
        {
            $file = $requestData->file('image');
            $filename = time() . '.' . $file->getClientOriginalName();
            $location = public_path('upload/');
            if (!file_exists($location)) {
                mkdir($location,0777,true);
            }
            $requestData->file('image')->move($location, $filename);
        }

        $user = \Auth::user();
        $department_id = $user->department->first()->id;
        $input = $requestData = array_merge(
            $requestData->all(),
            ['user_id' => auth()->id(),
                'image' => $filename,
                'department_id' => $department_id,
                'status_id' => 1]
        );
        $description = Description::create($input);

        // Create new ticket according to this ticket description
        $ticket = new Ticket();
        $ticket->status_id = 1;
        $ticket->description_id = $description->id;
        $ticket->save();

        // Create new troubleshoot according to this ticket description
        $troublehoot = new Troubleshoot();
        $troublehoot->save();

        // Create new prevention according to this ticket description
        $prevention = new Prevention();
        $prevention->save();

        $insertedId = $description->id;
        Session()->flash('flash_message', 'Ticket được tạo thành công!');
        event(new \App\Events\DescriptionAction($description, self::CREATED));

        return $insertedId;
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function updateAssign($id, $requestData)
    {
        $description = Description::with('user')->findOrFail($id);

        $input = $requestData->get('user_id');

        $input = array_replace($requestData->all());
        $description->fill($input)->save();
        $description = $description->fresh();

        event(new \App\Events\DescriptionAction($description, self::UPDATED_ASSIGN));
    }

    /**
     * Statistics for Dashboard
     */

    public function descriptions()
    {
        return Description::all()->count();
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function leaderConfirm($id, $result)
    {
        $description = Description::with('user')->findOrFail($id);
        $input = $requestData = array_merge(
            [   'leader_confirmation_result' => $result]
        );

        $description->fill($input)->save();
        $description = $description->fresh();
        if('Xác nhận' == $result){
            event(new \App\Events\DescriptionAction($description, self::LEADER_APPROVED));
        } else {
            event(new \App\Events\DescriptionAction($description, self::LEADER_REJECTED));
        }
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function update($id, $requestData)
    {
        $description = Description::findOrFail($id);

        // Save the attached file
        $filename = NULL;
        if($requestData->hasFile('image'))
        {
            $file = $requestData->file('image');
            $filename = time() . '.' . $file->getClientOriginalName();
            $location = public_path('upload/');
            if (!file_exists($location)) {
                mkdir($location,0777,true);
            }
            $requestData->file('image')->move($location, $filename);
        } else {
            $filename = $description->image;
        }

        $input = $requestData = array_merge(
            $requestData->all(),
            ['image' => $filename]
        );

        $description->fill($input)->save();
        event(new \App\Events\DescriptionAction($description, self::CREATED));

    }

    /**
     * @param $id
     * @param $requestData
     */
    public function effectivenessAsset($id, $result)
    {
        $description = Description::with('user')->findOrFail($id);
        $input = $requestData = array_merge(
            [   'effectiveness' => $result,
                'effectiveness_user_id' => auth()->id()]
        );

        $description->fill($input)->save();
        $description = $description->fresh();
        event(new \App\Events\DescriptionAction($description, self::EFFECTIVENESS_ASSET));
    }

    /**
     * @param
     */
    public function allDepartmentStatistic()
    {
        $hcns_cnt =  Description::all()->where('department_id', 1)->count();
        $sale_cnt =  Description::all()->where('department_id', 2)->count();
        $ketoan_cnt =  Description::all()->where('department_id', 3)->count();
        $ksnb_cnt =  Description::all()->where('department_id', 4)->count();
        $baotri_cnt =  Description::all()->where('department_id', 5)->count();
        $sx_cnt =  Description::all()->where('department_id', 6)->count();
        $thumua_cnt =  Description::all()->where('department_id', 7)->count();
        $kythuat_cnt =  Description::all()->where('department_id', 8)->count();
        $qlcl_cnt =  Description::all()->where('department_id', 9)->count();
        $kho_cnt =  Description::all()->where('department_id', 10)->count();

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
        //return collect([12, 20, 31, 14, 55, 26, 57, 88, 9, 10]);
    }
    /**
     * @param
     */
    public function allReasonStatistic()
    {
        $human_cnt =  Prevention::all()->where('reason_type_id', 1)->count();
        $machine_cnt =  Prevention::all()->where('reason_type_id', 2)->count();
        $material_cnt =  Prevention::all()->where('reason_type_id', 3)->count();
        $method_cnt =  Prevention::all()->where('reason_type_id', 4)->count();
        $measurement_cnt =  Prevention::all()->where('reason_type_id', 5)->count();
        $environment_cnt =  Prevention::all()->where('reason_type_id', 6)->count();

        return collect([$human_cnt, $machine_cnt, $material_cnt, $method_cnt, $measurement_cnt, $environment_cnt]);
        //return collect([24, 7, 55, 16, 25, 86]);
    }

    /**
     * @param
     */
    public function allDepartmentStatusStatistic()
    {
        $hcns_status_1_cnt =  Description::all()->where('department_id', 1)->where('status_id', 1)->count();
        $hcns_status_2_cnt =  Description::all()->where('department_id', 1)->where('status_id', 2)->count();
        $hcns_status_3_cnt =  Description::all()->where('department_id', 1)->where('status_id', 3)->count();
        $hcns_status_4_cnt =  Description::all()->where('department_id', 1)->where('status_id', 4)->count();
        $hcns_status_5_cnt =  Description::all()->where('department_id', 1)->where('status_id', 5)->count();
        $hcns_cnt = collect([$hcns_status_1_cnt, $hcns_status_2_cnt, $hcns_status_3_cnt, $hcns_status_4_cnt, $hcns_status_5_cnt]);
        //$hcns_cnt = collect([0, 1, 2, 3]);

        $sale_status_1_cnt =  Description::all()->where('department_id', 2)->where('status_id', 1)->count();
        $sale_status_2_cnt =  Description::all()->where('department_id', 2)->where('status_id', 2)->count();
        $sale_status_3_cnt =  Description::all()->where('department_id', 2)->where('status_id', 3)->count();
        $sale_status_4_cnt =  Description::all()->where('department_id', 2)->where('status_id', 4)->count();
        $sale_status_5_cnt =  Description::all()->where('department_id', 2)->where('status_id', 5)->count();
        $sale_cnt = collect([$sale_status_1_cnt, $sale_status_2_cnt, $sale_status_3_cnt, $sale_status_4_cnt, $sale_status_5_cnt]);
        //$sale_cnt = collect([10, 11, 12, 13]);


        $ketoan_status_1_cnt =  Description::all()->where('department_id', 3)->where('status_id', 1)->count();
        $ketoan_status_2_cnt =  Description::all()->where('department_id', 3)->where('status_id', 2)->count();
        $ketoan_status_3_cnt =  Description::all()->where('department_id', 3)->where('status_id', 3)->count();
        $ketoan_status_4_cnt =  Description::all()->where('department_id', 3)->where('status_id', 4)->count();
        $ketoan_status_5_cnt =  Description::all()->where('department_id', 3)->where('status_id', 5)->count();
        $ketoan_cnt = collect([$ketoan_status_1_cnt, $ketoan_status_2_cnt, $ketoan_status_3_cnt, $ketoan_status_4_cnt, $ketoan_status_5_cnt]);
        //$ketoan_cnt = collect([20, 21, 22, 23]);


        $ksnb_status_1_cnt =  Description::all()->where('department_id', 4)->where('status_id', 1)->count();
        $ksnb_status_2_cnt =  Description::all()->where('department_id', 4)->where('status_id', 2)->count();
        $ksnb_status_3_cnt =  Description::all()->where('department_id', 4)->where('status_id', 3)->count();
        $ksnb_status_4_cnt =  Description::all()->where('department_id', 4)->where('status_id', 4)->count();
        $ksnb_status_5_cnt =  Description::all()->where('department_id', 4)->where('status_id', 5)->count();
        $ksnb_cnt = collect([$ksnb_status_1_cnt, $ksnb_status_2_cnt, $ksnb_status_3_cnt, $ksnb_status_4_cnt, $ksnb_status_5_cnt]);
        //$ksnb_cnt = collect([30, 31, 32, 33]);

        $baotri_status_1_cnt =  Description::all()->where('department_id', 5)->where('status_id', 1)->count();
        $baotri_status_2_cnt =  Description::all()->where('department_id', 5)->where('status_id', 2)->count();
        $baotri_status_3_cnt =  Description::all()->where('department_id', 5)->where('status_id', 3)->count();
        $baotri_status_4_cnt =  Description::all()->where('department_id', 5)->where('status_id', 4)->count();
        $baotri_status_5_cnt =  Description::all()->where('department_id', 5)->where('status_id', 5)->count();
        $baotri_cnt = collect([$baotri_status_1_cnt, $baotri_status_2_cnt, $baotri_status_3_cnt, $baotri_status_4_cnt, $baotri_status_5_cnt]);
        //$baotri_cnt = collect([40, 41, 42, 43]);

        $sx_status_1_cnt =  Description::all()->where('department_id', 6)->where('status_id', 1)->count();
        $sx_status_2_cnt =  Description::all()->where('department_id', 6)->where('status_id', 2)->count();
        $sx_status_3_cnt =  Description::all()->where('department_id', 6)->where('status_id', 3)->count();
        $sx_status_4_cnt =  Description::all()->where('department_id', 6)->where('status_id', 4)->count();
        $sx_status_5_cnt =  Description::all()->where('department_id', 6)->where('status_id', 5)->count();
        $sx_cnt = collect([$sx_status_1_cnt, $sx_status_2_cnt, $sx_status_3_cnt, $sx_status_4_cnt, $sx_status_5_cnt]);
        //$sx_cnt = collect([50, 51, 52, 53]);

        $thumua_status_1_cnt =  Description::all()->where('department_id', 7)->where('status_id', 1)->count();
        $thumua_status_2_cnt =  Description::all()->where('department_id', 7)->where('status_id', 2)->count();
        $thumua_status_3_cnt =  Description::all()->where('department_id', 7)->where('status_id', 3)->count();
        $thumua_status_4_cnt =  Description::all()->where('department_id', 7)->where('status_id', 4)->count();
        $thumua_status_5_cnt =  Description::all()->where('department_id', 7)->where('status_id', 5)->count();
        $thumua_cnt = collect([$thumua_status_1_cnt, $thumua_status_2_cnt, $thumua_status_3_cnt, $thumua_status_4_cnt, $thumua_status_5_cnt]);
        //$thumua_cnt = collect([60, 61, 62, 63]);

        $kythuat_status_1_cnt =  Description::all()->where('department_id', 8)->where('status_id', 1)->count();
        $kythuat_status_2_cnt =  Description::all()->where('department_id', 8)->where('status_id', 2)->count();
        $kythuat_status_3_cnt =  Description::all()->where('department_id', 8)->where('status_id', 3)->count();
        $kythuat_status_4_cnt =  Description::all()->where('department_id', 8)->where('status_id', 4)->count();
        $kythuat_status_5_cnt =  Description::all()->where('department_id', 8)->where('status_id', 5)->count();
        $kythuat_cnt = collect([$kythuat_status_1_cnt, $kythuat_status_2_cnt, $kythuat_status_3_cnt, $kythuat_status_4_cnt, $kythuat_status_5_cnt]);
        //$kythuat_cnt = collect([70, 71, 72, 73]);

        $qlcl_status_1_cnt =  Description::all()->where('department_id', 9)->where('status_id', 1)->count();
        $qlcl_status_2_cnt =  Description::all()->where('department_id', 9)->where('status_id', 2)->count();
        $qlcl_status_3_cnt =  Description::all()->where('department_id', 9)->where('status_id', 3)->count();
        $qlcl_status_4_cnt =  Description::all()->where('department_id', 9)->where('status_id', 4)->count();
        $qlcl_status_5_cnt =  Description::all()->where('department_id', 9)->where('status_id', 5)->count();
        $qlcl_cnt = collect([$qlcl_status_1_cnt, $qlcl_status_2_cnt, $qlcl_status_3_cnt, $qlcl_status_4_cnt, $qlcl_status_5_cnt]);
        //$qlcl_cnt = collect([80, 81, 82, 83]);

        $kho_status_1_cnt =  Description::all()->where('department_id', 10)->where('status_id', 1)->count();
        $kho_status_2_cnt =  Description::all()->where('department_id', 10)->where('status_id', 2)->count();
        $kho_status_3_cnt =  Description::all()->where('department_id', 10)->where('status_id', 3)->count();
        $kho_status_4_cnt =  Description::all()->where('department_id', 10)->where('status_id', 4)->count();
        $kho_status_5_cnt =  Description::all()->where('department_id', 10)->where('status_id', 5)->count();
        $kho_cnt = collect([$kho_status_1_cnt, $kho_status_2_cnt, $kho_status_3_cnt, $kho_status_4_cnt, $kho_status_5_cnt]);
        //$kho_cnt = collect([90, 91, 92, 93]);

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
    }


    /**
     * @param
     */
    public function allDepartmentReasonStatistic()
    {
        $hcns_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 1)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $hcns_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 1)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $hcns_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 1)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $hcns_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 1)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $hcns_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 1)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $hcns_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 1)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $hcns_cnt = collect([$hcns_reason_type_1_cnt, $hcns_reason_type_2_cnt, $hcns_reason_type_3_cnt,
         $hcns_reason_type_4_cnt, $hcns_reason_type_5_cnt, $hcns_reason_type_6_cnt]);
        //$hcns_cnt = collect([90, 91, 92, 93, 94, 95]);

        $sale_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 2)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $sale_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 2)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $sale_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 2)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $sale_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 2)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $sale_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 2)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $sale_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 2)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $sale_cnt = collect([$sale_reason_type_1_cnt, $sale_reason_type_2_cnt, $sale_reason_type_3_cnt,
         $sale_reason_type_4_cnt, $sale_reason_type_5_cnt, $sale_reason_type_6_cnt]);
        //$sale_cnt = collect([80, 81, 82, 83, 84, 85, 86]);


        $ketoan_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 3)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $ketoan_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 3)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $ketoan_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 3)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $ketoan_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 3)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $ketoan_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 3)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $ketoan_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 3)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $ketoan_cnt = collect([$ketoan_reason_type_1_cnt, $ketoan_reason_type_2_cnt, $ketoan_reason_type_3_cnt,
         $ketoan_reason_type_4_cnt, $ketoan_reason_type_5_cnt, $ketoan_reason_type_6_cnt]);
        //$ketoan_cnt = collect([70, 71, 72, 73, 74, 75]);

        $ksnb_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 4)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $ksnb_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 4)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $ksnb_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 4)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $ksnb_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 4)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $ksnb_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 4)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $ksnb_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 4)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $ksnb_cnt = collect([$ksnb_reason_type_1_cnt, $ksnb_reason_type_2_cnt, $ksnb_reason_type_3_cnt,
         $ksnb_reason_type_4_cnt, $ksnb_reason_type_5_cnt, $ksnb_reason_type_6_cnt]);
        //$ksnb_cnt = collect([60, 61, 62, 63, 64, 65]);

        $baotri_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 5)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $baotri_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 5)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $baotri_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 5)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $baotri_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 5)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $baotri_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 5)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $baotri_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 5)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $baotri_cnt = collect([$baotri_reason_type_1_cnt, $baotri_reason_type_2_cnt, $baotri_reason_type_3_cnt,
         $baotri_reason_type_4_cnt, $baotri_reason_type_5_cnt, $baotri_reason_type_5_cnt]);
        //$baotri_cnt = collect([50, 51, 52, 53, 54, 55]);

        $sx_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 6)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $sx_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 6)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $sx_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 6)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $sx_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 6)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $sx_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 6)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $sx_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 6)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $sx_cnt = collect([$sx_reason_type_1_cnt, $sx_reason_type_2_cnt, $sx_reason_type_3_cnt,
         $sx_reason_type_4_cnt, $sx_reason_type_5_cnt, $sx_reason_type_6_cnt]);
        //$sx_cnt = collect([40, 41, 42, 43, 44, 45]);

        $thumua_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 7)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $thumua_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 7)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $thumua_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 7)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $thumua_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 7)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $thumua_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 7)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $thumua_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 7)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $thumua_cnt = collect([$thumua_reason_type_1_cnt, $thumua_reason_type_2_cnt, $thumua_reason_type_3_cnt,
         $thumua_reason_type_4_cnt, $thumua_reason_type_5_cnt, $thumua_reason_type_6_cnt]);
        //$thumua_cnt = collect([30, 31, 32, 33, 34, 35]);

        $kythuat_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 8)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $kythuat_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 8)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $kythuat_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 8)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $kythuat_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 8)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $kythuat_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 8)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $kythuat_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 8)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $kythuat_cnt = collect([$kythuat_reason_type_1_cnt, $kythuat_reason_type_2_cnt, $kythuat_reason_type_3_cnt,
         $kythuat_reason_type_4_cnt, $kythuat_reason_type_5_cnt, $kythuat_reason_type_6_cnt]);
        //$kythuat_cnt = collect([20, 21, 22, 23, 24, 25]);

        $qlcl_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 9)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $qlcl_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 9)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $qlcl_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 9)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $qlcl_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 9)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $qlcl_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 9)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $qlcl_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 9)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $qlcl_cnt = collect([$qlcl_reason_type_1_cnt, $qlcl_reason_type_2_cnt, $qlcl_reason_type_3_cnt,
         $qlcl_reason_type_4_cnt, $qlcl_reason_type_5_cnt, $qlcl_reason_type_6_cnt]);
        //$qlcl_cnt = collect([10, 11, 12, 13, 14, 15]);

        $kho_reason_type_1_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 10)
                    ->where('preventions.reason_type_id', 1);
            })
            ->count();
        $kho_reason_type_2_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 10)
                    ->where('preventions.reason_type_id', 2);
            })
            ->count();
        $kho_reason_type_3_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 10)
                    ->where('preventions.reason_type_id', 3);
            })
            ->count();
        $kho_reason_type_4_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 10)
                    ->where('preventions.reason_type_id', 4);
            })
            ->count();
        $kho_reason_type_5_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 10)
                    ->where('preventions.reason_type_id', 5);
            })
            ->count();
        $kho_reason_type_6_cnt = DB::table('preventions')
            ->join('descriptions', function($join)
            {
                $join->on('descriptions.id', '=', 'preventions.id')
                    ->where('descriptions.department_id', 10)
                    ->where('preventions.reason_type_id', 6);
            })
            ->count();
        $kho_cnt = collect([$kho_reason_type_1_cnt, $kho_reason_type_2_cnt, $kho_reason_type_3_cnt,
         $kho_reason_type_4_cnt, $kho_reason_type_5_cnt, $kho_reason_type_6_cnt]);
        //$kho_cnt = collect([0, 1, 2, 3, 4, 5]);

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
    }

    /**
     * @param
     */
    public function allTroubleshootActionsOnTimeRateStatistic()
    {
        if(0 == Description::all()->where('department_id', 1)->count()) {
            $hcns_cnt = 0;
        } else {
            $hcns_cnt = (int)(100 * Description::all()->where('department_id', 1)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $hcns_cnt = Description::all()->where('department_id', 1)->count());
        }
        if(0 == Description::all()->where('department_id', 2)->count()) {
            $sale_cnt = 0;
        } else {
            $sale_cnt = (int)(100 *  Description::all()->where('department_id', 2)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $sale_cnt = Description::all()->where('department_id', 2)->count());
        }
        if(0 == Description::all()->where('department_id', 3)->count()) {
            $ketoan_cnt = 0;
        } else {
            $ketoan_cnt = (int)(100 *  Description::all()->where('department_id', 3)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $ketoan_cnt = Description::all()->where('department_id', 3)->count());
        }
        if(0 == Description::all()->where('department_id', 4)->count()) {
            $ksnb_cnt = 0;
        } else {
            $ksnb_cnt = (int)(100 *  Description::all()->where('department_id', 4)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $ksnb_cnt = Description::all()->where('department_id', 4)->count());
        }
        if(0 == Description::all()->where('department_id', 5)->count()) {
            $baotri_cnt = 0;
        } else {
            $baotri_cnt = (int)(100 *  Description::all()->where('department_id', 5)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $baotri_cnt = Description::all()->where('department_id', 5)->count());
        }
        if(0 == Description::all()->where('department_id', 6)->count()) {
            $sx_cnt = 0;
        } else {
            $sx_cnt = (int)(100 *  Description::all()->where('department_id', 6)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $sx_cnt = Description::all()->where('department_id', 6)->count());
        }
        if(0 == Description::all()->where('department_id', 6)->count()) {
            $thumua_cnt = 0;
        } else {
            $thumua_cnt = (int)(100 *  Description::all()->where('department_id', 7)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $thumua_cnt = Description::all()->where('department_id', 7)->count());
        }
        if(0 == Description::all()->where('department_id', 8)->count()) {
            $kythuat_cnt = 0;
        } else {
            $kythuat_cnt = (int)(100 *  Description::all()->where('department_id', 8)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $kythuat_cnt = Description::all()->where('department_id', 8)->count());
        }
        if(0 == Description::all()->where('department_id', 9)->count()) {
            $qlcl_cnt = 0;
        } else {
            $qlcl_cnt = (int)(100 *  Description::all()->where('department_id', 9)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $qlcl_cnt = Description::all()->where('department_id', 9)->count());
        }
        if(0 == Description::all()->where('department_id', 9)->count()) {
            $kho_cnt = 0;
        } else {
            $kho_cnt = (int)(100 *  Description::all()->where('department_id', 10)
                    ->where('is_troubleshoot_actions_on_time', true)->count() /
                $kho_cnt = Description::all()->where('department_id', 10)->count());
        }

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
    }


    /**
     * @param
     */
    public function allPreventionActionsOnTimeRateStatistic()
    {
        if(0 == Description::all()->where('department_id', 1)->count()) {
            $hcns_cnt = 0;
        } else {
            $hcns_cnt = (int)(100 * Description::all()->where('department_id', 1)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $hcns_cnt = Description::all()->where('department_id', 1)->count());
        }
        if(0 == Description::all()->where('department_id', 2)->count()) {
            $sale_cnt = 0;
        } else {
            $sale_cnt = (int)(100 *  Description::all()->where('department_id', 2)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $sale_cnt = Description::all()->where('department_id', 2)->count());
        }
        if(0 == Description::all()->where('department_id', 3)->count()) {
            $ketoan_cnt = 0;
        } else {
            $ketoan_cnt = (int)(100 *  Description::all()->where('department_id', 3)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $ketoan_cnt = Description::all()->where('department_id', 3)->count());
        }
        if(0 == Description::all()->where('department_id', 4)->count()) {
            $ksnb_cnt = 0;
        } else {
            $ksnb_cnt = (int)(100 *  Description::all()->where('department_id', 4)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $ksnb_cnt = Description::all()->where('department_id', 4)->count());
        }
        if(0 == Description::all()->where('department_id', 5)->count()) {
            $baotri_cnt = 0;
        } else {
            $baotri_cnt = (int)(100 *  Description::all()->where('department_id', 5)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $baotri_cnt = Description::all()->where('department_id', 5)->count());
        }
        if(0 == Description::all()->where('department_id', 6)->count()) {
            $sx_cnt = 0;
        } else {
            $sx_cnt = (int)(100 *  Description::all()->where('department_id', 6)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $sx_cnt = Description::all()->where('department_id', 6)->count());
        }
        if(0 == Description::all()->where('department_id', 6)->count()) {
            $thumua_cnt = 0;
        } else {
            $thumua_cnt = (int)(100 *  Description::all()->where('department_id', 7)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $thumua_cnt = Description::all()->where('department_id', 7)->count());
        }
        if(0 == Description::all()->where('department_id', 8)->count()) {
            $kythuat_cnt = 0;
        } else {
            $kythuat_cnt = (int)(100 *  Description::all()->where('department_id', 8)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $kythuat_cnt = Description::all()->where('department_id', 8)->count());
        }
        if(0 == Description::all()->where('department_id', 9)->count()) {
            $qlcl_cnt = 0;
        } else {
            $qlcl_cnt = (int)(100 *  Description::all()->where('department_id', 9)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $qlcl_cnt = Description::all()->where('department_id', 9)->count());
        }
        if(0 == Description::all()->where('department_id', 9)->count()) {
            $kho_cnt = 0;
        } else {
            $kho_cnt = (int)(100 *  Description::all()->where('department_id', 10)
                    ->where('is_prevention_actions_on_time', true)->count() /
                $kho_cnt = Description::all()->where('department_id', 10)->count());
        }

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
    }
}
