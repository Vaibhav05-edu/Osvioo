<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'description',
        'order',
        'status'
    ];

    // Status check karne ke liye helper (optional)
    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order', 'asc');
    }
}