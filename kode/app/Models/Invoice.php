<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];
    
    protected $casts = [
        'details' => 'array',
        'watermark_removed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

