<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreventionAction extends Model
{
    protected $fillable = [
        'action',
        'budget',
        'user_id',
        'where',
        'when',
        'how',
        'status',
        'description_id',
        'is_on_time',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
