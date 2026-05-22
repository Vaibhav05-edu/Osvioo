<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoDmStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'auto_dm_trigger_id',
        'step_order',
        'reply_text',
        'delay_seconds',
    ];

    public function trigger()
    {
        return $this->belongsTo(AutoDmTrigger::class, 'auto_dm_trigger_id');
    }
}
