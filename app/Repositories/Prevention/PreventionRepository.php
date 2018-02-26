<?php
namespace App\Repositories\Prevention;

use App\Models\Prevention;
use Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;

/**
 * Class PreventionRepository
 * @package App\Prevention\Prevention
 */
class PreventionRepository implements PreventionRepositoryContract
{
    const CREATED = 'created';
    const ASSIGNED_PROPOSER = 'assigned_proposer';
    const REQUEST_TO_APPROVE = 'request_to_approve';
    const REQUEST_TO_APPROVE_ROOT_CAUSE = 'request_to_approve_root_cause';
    const APPROVED_PREVENTION = 'approved_prevention';
    const REJECTED_PREVENTION = 'rejected_prevention';
    const APPROVED_ROOT_CAUSE = 'approved_root_cause';
    const REJECTED_ROOT_CAUSE = 'rejected_root_cause';


    /**
     * @param $id
     * @param $requestData
     */
    public function assignProposer($id, $requestData)
    {
        $prevention = Prevention::findOrFail($id);

        $prevention->proposer_id = $requestData->proposer_id;
        $prevention->save();

        $prevention = $prevention->fresh();
        event(new \App\Events\PreventionAction($prevention, self::ASSIGNED_PROPOSER));
    }

    public function assignApprover($id, $requestData)
    {
        $prevention = Prevention::findOrFail($id);

        $prevention->approver_id = $requestData->approver_id;
        $prevention->save();

        $prevention = $prevention->fresh();

        event(new \App\Events\PreventionAction($prevention, self::REQUEST_TO_APPROVE));
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function approvePrevention($id, $result)
    {
        $prevention = Prevention::findOrFail($id);
        $input = $requestData = array_merge(
            [   'approve_result' => $result]
        );

        $prevention->fill($input)->save();
        $prevention = $prevention->fresh();

        if('Đồng ý' == $result) {
            event(new \App\Events\PreventionAction($prevention, self::APPROVED_PREVENTION));

        } else {
            event(new \App\Events\PreventionAction($prevention, self::REJECTED_PREVENTION));
        }
    }

    public function update($id, $requestData)
    {
        $prevention = Prevention::findOrFail($id);
        $prevention->fill($requestData->all())->save();

        event(new \App\Events\PreventionAction($prevention, self::REQUEST_TO_APPROVE_ROOT_CAUSE));
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function approveRootcause($id, $result)
    {
        $prevention = Prevention::findOrFail($id);
        $input = $requestData = array_merge(
            [   'root_cause_approve_result' => $result]
        );

        $prevention->fill($input)->save();
        $prevention = $prevention->fresh();

        if('Đồng ý' == $result) {
            event(new \App\Events\PreventionAction($prevention, self::APPROVED_ROOT_CAUSE));

        } else {
            event(new \App\Events\PreventionAction($prevention, self::REJECTED_ROOT_CAUSE));
        }
    }
}
