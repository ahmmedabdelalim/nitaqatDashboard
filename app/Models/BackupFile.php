<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupFile extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'path', 'size'];
}
