<?php
namespace App\Repositories\Description;

interface DescriptionRepositoryContract
{

    public function find($id);

    public function create($requestData);

    public function updateAssign($id, $requestData);
    
    public function descriptions();
}
