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
    const APPROVED = 'approved';
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
    public function approve($id, $requestData)
    {
        $prevention = Prevention::findOrFail($id);
        $input = $requestData = array_merge(
            $requestData->all(),
            [   'approve_result' => $requestData->approve_prevention_result]
        );

        $prevention->fill($input)->save();
        $prevention = $prevention->fresh();

        event(new \App\Events\PreventionAction($prevention, self::APPROVED));
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
    public function approvedRootcause($id, $requestData)
    {
        $prevention = Prevention::findOrFail($id);
        $input = $requestData = array_merge(
            $requestData->all(),
            [   'root_cause_approve_result' => 'Đồng ý']
        );

        $prevention->fill($input)->save();
        $prevention = $prevention->fresh();

        event(new \App\Events\PreventionAction($prevention, self::APPROVED_ROOT_CAUSE));
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function rejectedRootcause($id, $requestData)
    {
        $prevention = Prevention::findOrFail($id);
        $input = $requestData = array_merge(
            $requestData->all(),
            [   'root_cause_approve_result' => 'Không đồng ý']
        );

        $prevention->fill($input)->save();
        $prevention = $prevention->fresh();

        event(new \App\Events\PreventionAction($prevention, self::REJECTED_ROOT_CAUSE));
    }
}
