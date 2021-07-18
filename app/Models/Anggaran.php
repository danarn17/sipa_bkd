<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggaran extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'anggaran';
    protected $fillable = ['year', 'triwulan_1', 'triwulan_2', 'triwulan_3', 'triwulan_4'];
}
