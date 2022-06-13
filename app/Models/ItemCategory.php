<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model {


    public function items() {
        return $this->hasMany(Item::class);
    }

    public function color() {
        switch ($this->name) {
            case 'low':
                return 'text-success';
            case 'medium':
                return 'text-warning';
            default:
                return 'text-danger';
        }
    }
}
