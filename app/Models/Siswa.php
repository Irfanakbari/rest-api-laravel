<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Siswa extends Model
{
    use  HasFactory;
    protected $table='siswa';
    public $timestamps = false;
    protected $primaryKey='nis';
    protected $fillable = [
        'nis',
        'nama',
        'password',
        'id_kelas',
        'ip'
    ];


}
