<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AutoDmTrigger extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'user_id',
        'social_account_id',
        'keyword',
        'reply_text',
        'match_type',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uid = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function socialAccount()
    {
        return $this->belongsTo(SocialAccount::class);
    }
}
