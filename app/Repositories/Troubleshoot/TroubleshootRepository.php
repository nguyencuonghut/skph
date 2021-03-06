<?php
namespace App\Repositories\Troubleshoot;

use App\Models\Troubleshoot;
use Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;

/**
 * Class TroubleshootRepository
 * @package App\Troubleshoot\Troubleshoot
 */
class TroubleshootRepository implements TroubleshootRepositoryContract
{
    const CREATED = 'created';
    const ASSIGNED_TROUBLESHOOTER = 'assigned_troubleshooter';
    const REQUEST_TO_APPROVE = 'request_to_approve';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    const SERIOUSLY = 'seriously';
    const NORMALLY = 'normally';


    /**
     * @param $id
     * @param $requestData
     */
    public function assignTroubleshooter($id, $requestData)
    {
        $troubleshoot = Troubleshoot::findOrFail($id);

        $troubleshoot->troubleshooter_id = $requestData->troubleshooter_id;
        $troubleshoot->save();

        $troubleshoot = $troubleshoot->fresh();
        event(new \App\Events\TroubleshootAction($troubleshoot, self::ASSIGNED_TROUBLESHOOTER));
    }

    public function update($id, $requestData)
    {
        $troubleshoot = Troubleshoot::findOrFail($id);
        $troubleshoot->fill($requestData->all())->save();

        event(new \App\Events\TroubleshootAction($troubleshoot, self::REQUEST_TO_APPROVE));
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function approve($id, $result)
    {
        $troubleshoot = Troubleshoot::findOrFail($id);
        $input = $requestData = array_merge(
            [   'approve_result' => $result]
        );

        $troubleshoot->fill($input)->save();
        $troubleshoot = $troubleshoot->fresh();

        if('Đồng ý' == $result) {
            event(new \App\Events\TroubleshootAction($troubleshoot, self::APPROVED));
        } else {
            event(new \App\Events\TroubleshootAction($troubleshoot, self::REJECTED));
        }
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function evaluate($id, $result)
    {
        $troubleshoot = Troubleshoot::findOrFail($id);
        $input = $requestData = array_merge(
            [   'evaluate_result' => $result,
                'evaluater_id' => auth()->id()]
        );

        $troubleshoot->fill($input)->save();
        $troubleshoot = $troubleshoot->fresh();

        if('Nghiêm trọng' == $result){
            event(new \App\Events\TroubleshootAction($troubleshoot, self::SERIOUSLY));
        } else {
            event(new \App\Events\TroubleshootAction($troubleshoot, self::NORMALLY));
        }
    }
}
