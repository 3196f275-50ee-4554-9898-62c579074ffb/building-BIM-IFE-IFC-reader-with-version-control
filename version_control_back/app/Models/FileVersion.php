<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileVersion extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'file_path', 'version', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
