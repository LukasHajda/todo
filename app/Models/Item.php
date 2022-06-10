<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'heading',
        'description',
        'category_id',
        'user_id',
    ];


    public function users() {
        return $this->belongsToMany(User::class, 'item_user')->withTimestamps();
    }


}
