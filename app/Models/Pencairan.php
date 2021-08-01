<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pencairan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pencairan';
    protected $fillable = ['no_rek', 'year', 'nominal', 'triwulan', 'tgl_kegiatan', 'tgl_pencairan', 'archive', 'ket'];
}
