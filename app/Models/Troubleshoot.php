<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Troubleshoot extends Model
{
    protected $fillable = [
        'responsibility_id',
        'level_id',
        'troubleshooter_id',
        'approver_id',
        'reason',
        'deadline',
        'approve_result',
        'evaluate_result',
        'evaluater_id',
    ];

    public function responsibility()
    {
        return $this->belongsTo(Responsibility::class, 'responsibility_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function troubleshooter()
    {
        return $this->belongsTo(User::class, 'troubleshooter_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function evaluater()
    {
        return $this->belongsTo(User::class, 'evaluater_id');
    }
    public function desciption()
    {

        return $this->hasOne(Description::class, 'description_id', 'id');
    }

    public function getAssignedUserAttribute()
    {
        return User::findOrFail($this->troubleshooter_id);
    }

    public function getApprovedUserAttribute()
    {
        return User::findOrFail($this->approver_id);
    }

    public function getDescriptionTitleAttribute()
    {
        $description = Description::findOrFail($this->id);
        return $description->title;
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'source');
    }
}
