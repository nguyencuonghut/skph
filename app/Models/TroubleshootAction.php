<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TroubleshootAction extends Model
{
    protected $fillable = [
    'action',
    'user_id',
    'status',
    'deadline',
    'description_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
