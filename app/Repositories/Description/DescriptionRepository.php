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
                'department_id' => $department_id]
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

        //return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
        //    $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
        return collect([12, 20, 31, 14, 55, 26, 57, 88, 9, 10]);
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

        //return collect([$human_cnt, $machine_cnt, $material_cnt, $method_cnt, $measurement_cnt, $environment_cnt]);
        return collect([24, 7, 55, 16, 25, 86]);
    }

    /**
     * @param
     */
    public function allTroubleshootableRateStatistic()
    {
        if(0 == Description::all()->where('department_id', 1)->count()) {
            $hcns_cnt = 0;
        } else {
            $hcns_cnt = (int)(100 * Description::all()->where('department_id', 1)
                ->where('troubleshoot_action_count', '>', 0)->count() /
                $hcns_cnt = Description::all()->where('department_id', 1)->count());
        }
        if(0 == Description::all()->where('department_id', 2)->count()) {
            $sale_cnt = 0;
        } else {
            $sale_cnt = (int)(100 *  Description::all()->where('department_id', 2)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $sale_cnt = Description::all()->where('department_id', 2)->count());
        }
        if(0 == Description::all()->where('department_id', 3)->count()) {
            $ketoan_cnt = 0;
        } else {
            $ketoan_cnt = (int)(100 *  Description::all()->where('department_id', 3)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $ketoan_cnt = Description::all()->where('department_id', 3)->count());
        }
        if(0 == Description::all()->where('department_id', 4)->count()) {
            $ksnb_cnt = 0;
        } else {
            $ksnb_cnt = (int)(100 *  Description::all()->where('department_id', 4)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $ksnb_cnt = Description::all()->where('department_id', 4)->count());
        }
        if(0 == Description::all()->where('department_id', 5)->count()) {
            $baotri_cnt = 0;
        } else {
            $baotri_cnt = (int)(100 *  Description::all()->where('department_id', 5)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $baotri_cnt = Description::all()->where('department_id', 5)->count());
        }
        if(0 == Description::all()->where('department_id', 6)->count()) {
            $sx_cnt = 0;
        } else {
            $sx_cnt = (int)(100 *  Description::all()->where('department_id', 6)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $sx_cnt = Description::all()->where('department_id', 6)->count());
        }
        if(0 == Description::all()->where('department_id', 6)->count()) {
            $thumua_cnt = 0;
        } else {
            $thumua_cnt = (int)(100 *  Description::all()->where('department_id', 7)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $thumua_cnt = Description::all()->where('department_id', 7)->count());
        }
        if(0 == Description::all()->where('department_id', 8)->count()) {
            $kythuat_cnt = 0;
        } else {
            $kythuat_cnt = (int)(100 *  Description::all()->where('department_id', 8)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $kythuat_cnt = Description::all()->where('department_id', 8)->count());
        }
        if(0 == Description::all()->where('department_id', 9)->count()) {
            $qlcl_cnt = 0;
        } else {
            $qlcl_cnt = (int)(100 *  Description::all()->where('department_id', 9)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $qlcl_cnt = Description::all()->where('department_id', 9)->count());
        }
        if(0 == Description::all()->where('department_id', 9)->count()) {
            $kho_cnt = 0;
        } else {
            $kho_cnt = (int)(100 *  Description::all()->where('department_id', 10)
                    ->where('troubleshoot_action_count', '>', 0)->count() /
                $kho_cnt = Description::all()->where('department_id', 10)->count());
        }

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
    }

    /**
     * @param
     */
    public function allPreventionableRateStatistic()
    {
        if(0 == Description::all()->where('department_id', 1)->count()) {
            $hcns_cnt = 0;
        } else {
            $hcns_cnt = (int)(100 * Description::all()->where('department_id', 1)
                    ->where('prevention_action_count', '>', 0)->count() /
                $hcns_cnt = Description::all()->where('department_id', 1)->count());
        }
        if(0 == Description::all()->where('department_id', 2)->count()) {
            $sale_cnt = 0;
        } else {
            $sale_cnt = (int)(100 *  Description::all()->where('department_id', 2)
                    ->where('prevention_action_count', '>', 0)->count() /
                $sale_cnt = Description::all()->where('department_id', 2)->count());
        }
        if(0 == Description::all()->where('department_id', 3)->count()) {
            $ketoan_cnt = 0;
        } else {
            $ketoan_cnt = (int)(100 *  Description::all()->where('department_id', 3)
                    ->where('prevention_action_count', '>', 0)->count() /
                $ketoan_cnt = Description::all()->where('department_id', 3)->count());
        }
        if(0 == Description::all()->where('department_id', 4)->count()) {
            $ksnb_cnt = 0;
        } else {
            $ksnb_cnt = (int)(100 *  Description::all()->where('department_id', 4)
                    ->where('prevention_action_count', '>', 0)->count() /
                $ksnb_cnt = Description::all()->where('department_id', 4)->count());
        }
        if(0 == Description::all()->where('department_id', 5)->count()) {
            $baotri_cnt = 0;
        } else {
            $baotri_cnt = (int)(100 *  Description::all()->where('department_id', 5)
                    ->where('prevention_action_count', '>', 0)->count() /
                $baotri_cnt = Description::all()->where('department_id', 5)->count());
        }
        if(0 == Description::all()->where('department_id', 6)->count()) {
            $sx_cnt = 0;
        } else {
            $sx_cnt = (int)(100 *  Description::all()->where('department_id', 6)
                    ->where('prevention_action_count', '>', 0)->count() /
                $sx_cnt = Description::all()->where('department_id', 6)->count());
        }
        if(0 == Description::all()->where('department_id', 6)->count()) {
            $thumua_cnt = 0;
        } else {
            $thumua_cnt = (int)(100 *  Description::all()->where('department_id', 7)
                    ->where('prevention_action_count', '>', 0)->count() /
                $thumua_cnt = Description::all()->where('department_id', 7)->count());
        }
        if(0 == Description::all()->where('department_id', 8)->count()) {
            $kythuat_cnt = 0;
        } else {
            $kythuat_cnt = (int)(100 *  Description::all()->where('department_id', 8)
                    ->where('prevention_action_count', '>', 0)->count() /
                $kythuat_cnt = Description::all()->where('department_id', 8)->count());
        }
        if(0 == Description::all()->where('department_id', 9)->count()) {
            $qlcl_cnt = 0;
        } else {
            $qlcl_cnt = (int)(100 *  Description::all()->where('department_id', 9)
                    ->where('prevention_action_count', '>', 0)->count() /
                $qlcl_cnt = Description::all()->where('department_id', 9)->count());
        }
        if(0 == Description::all()->where('department_id', 9)->count()) {
            $kho_cnt = 0;
        } else {
            $kho_cnt = (int)(100 *  Description::all()->where('department_id', 10)
                    ->where('prevention_action_count', '>', 0)->count() /
                $kho_cnt = Description::all()->where('department_id', 10)->count());
        }

        return collect([$hcns_cnt, $sale_cnt, $ketoan_cnt, $ksnb_cnt, $baotri_cnt,
            $sx_cnt, $thumua_cnt, $kythuat_cnt, $qlcl_cnt, $kho_cnt]);
    }
}
