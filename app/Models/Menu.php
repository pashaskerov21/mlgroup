<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['parent', 'order', 'destroy'];
    public function getTranslate()
    {
        return $this->hasMany(MenuTranslate::class, 'menu_id', 'id');
    }
}
