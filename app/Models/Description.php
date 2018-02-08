<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    protected $table =  'descriptions';

    protected $fillable = [
        'title',
        'issue_date',
        'answer_date',
        'area_id',
        'source_id',
        'action_id',
        'what',
        'why',
        'when',
        'where',
        'who',
        'how_1',
        'how_2',
        'image',
        'user_id',
        'leader_id',
        'leader_confirmation_result',
    ];

    protected $hidden = ['remember_token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id');
    }

    public function getAssignedUserAttribute()
    {
        return User::findOrFail($this->user_id);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'source');
    }

}
