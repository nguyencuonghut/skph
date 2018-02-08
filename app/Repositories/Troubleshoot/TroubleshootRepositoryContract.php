<?php
namespace App\Repositories\Troubleshoot;

interface TroubleshootRepositoryContract
{
    public function assignTroubleshooter($id, $requestData);
    public function approve($id, $requestData);
}
