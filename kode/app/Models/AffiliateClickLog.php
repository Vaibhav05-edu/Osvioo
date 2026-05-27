<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateClickLog extends Model
{
    protected $guarded = [];
    
    public function referral()
    {
        return $this->belongsTo(User::class, 'referral_id');
    }
