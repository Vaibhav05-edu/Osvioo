<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class BrandDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid', 'user_id', 'brand_name', 'status', 'agreed_amount', 'deliverables', 'notes'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uid = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
