<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSetting extends Model
{
    protected $fillable = [
        'headline_1',
        'headline_2',
        'typing_texts',
        'description',
        'hero_image',
        'cta_text',
        'cta_url',
    ];

    protected $casts = [
        'typing_texts' => 'array',
    ];
}
