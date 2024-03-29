<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategories extends Model
{
    use HasFactory;
    protected $fillable = ['header_status', 'order', 'destroy'];
    public function getTranslate(){
        return $this->hasMany(ProjectCategoryTranslate::class, 'category_id', 'id');
    }
    public function getProjects(){
        return $this->hasMany(Project::class, 'category_id', 'id');
    }
}
