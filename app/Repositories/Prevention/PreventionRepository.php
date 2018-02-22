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
    const APPROVED = 'approved';


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
}