<?php
namespace App\Repositories\Prevention;

interface PreventionRepositoryContract
{
    public function assignProposer($id, $requestData);
    public function approve($id, $requestData);
}
