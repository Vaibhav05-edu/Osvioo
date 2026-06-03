<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaKit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'uid', 'title', 'bio', 'cover_image', 'theme_color',
        'total_followers', 'engagement_rate', 'top_platform',
        'social_links', 'demographics', 'contact_email', 'is_public', 'views'
    ];

    protected $casts = [
        'social_links' => 'array',
        'demographics' => 'array',
        'is_public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
