<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory;

    // Table ka naam agar plural se alag ho (optional)
    protected $table = 'faqs';

    // Jo data hum mass-assign (save) kar sakte hain
    protected $fillable = [
        'question',
        'answer',
        'fb_link',
        'x_link',
        'linkedin_link',
        'website_link',
        'order',
        'is_active'
    ];

    // Data types ko cast karne ke liye (optional)
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
