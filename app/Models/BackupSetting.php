<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupSetting extends Model
{
    protected $table = 'backup_settings';
    protected $fillable = ['enabled', 'time', 'frequency', 'day_of_week'];
}
