<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sub_kegiatan';
    protected $fillable = ['no_rek', 'name'];

    public function child()
    {
        return $this->hasMany("App\Models\ChildSubKegiatan", 'child_of')->where('level_sub', '=', 1);
    }
    public function parent()
    {
        return $this->belongsTo("App\Models\ChildSubKegiatan", 'child_of');
    }
    public function lastChild()
    {
        return $this->child()->with('childd');
    }
}
