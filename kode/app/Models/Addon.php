<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $guarded = [];
    
    public function userAddons()
    {
        return $this->hasMany(UserAddon::class);
    }
