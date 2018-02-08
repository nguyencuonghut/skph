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
    const APPROVE_REQUEST = 'approve_request';
    const APPROVED = 'approved';


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

        event(new \App\Events\TroubleshootAction($troubleshoot, self::APPROVE_REQUEST));
    }

    /**
     * @param $id
     * @param $requestData
     */
    public function approve($id, $requestData)
    {
        $troubleshoot = Troubleshoot::findOrFail($id);
        $input = $requestData = array_merge(
            $requestData->all(),
            [   'approve_result' => $requestData->approve_result]
        );

        $troubleshoot->fill($input)->save();
        $troubleshoot = $troubleshoot->fresh();

        event(new \App\Events\TroubleshootAction($troubleshoot, self::APPROVED));
    }
}
