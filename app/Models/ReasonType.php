<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function getNameAndDescriptionAttribute()
    {
        return $this->name . ' ' . '- ' . $this->description;
    }
}
