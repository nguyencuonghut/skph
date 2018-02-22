<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prevention extends Model
{
    protected $fillable = [
        'proposer_id',
        'approver_id',
        'approve_result',
    ];

    public function proposer()
    {
        return $this->belongsTo(User::class, 'proposer_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }


    public function getAssignedUserAttribute()
    {
        return User::findOrFail($this->proposer_id);
    }

    public function getApprovedUserAttribute()
    {
        return User::findOrFail($this->approver_id);
    }
}
