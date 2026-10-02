<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'title', 'description', 'activity_date',
        'system_count', 'log_count', 'status', 'created_by',
    ];

    protected $casts = ['activity_date' => 'date'];

    public function updates()
    {
        return $this->hasMany(ActivityUpdate::class)->latest();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}