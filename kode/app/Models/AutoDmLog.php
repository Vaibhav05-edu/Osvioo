<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoDmLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'social_account_id',
        'sender_id',
        'received_message',
        'reply_sent',
        'status',
        'error_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function socialAccount()
    {
        return $this->belongsTo(SocialAccount::class);
    }
}
