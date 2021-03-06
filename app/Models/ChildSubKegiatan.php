<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildSubKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'child_sub_kegiatan';
    protected $fillable = ['no_rek_sub', 'name', 'child_of', 'level_sub'];

    public function child()
    {
        return $this->hasMany("App\Models\ChildSubKegiatan", 'child_of')->where('level_sub', '!=', 1);;
    }
    public function parent()
    {
        return $this->belongsTo("App\Models\ChildSubKegiatan", 'child_of');
        // super parent        
    }
    public function superParent()
    {
        return $this->belongsTo("App\Models\SubKegiatan", 'child_of', 'id');
        // return 
    }

    public function childd()
    {
        return $this->child()->with('childd');
    }
    public function parentt()
    {
        return $this->parent()->with('parentt');
    }

    public function lastChild()
    {
        return $this->child()->with('childd');
    }
    public function rootParent()
    {
        return $this->parent()->with('parentt');
    }
}
