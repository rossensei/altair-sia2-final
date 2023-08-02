<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'workspace_id',
        'taskname',
        'date_sched',
        'status',
    ];

    public function workspace()
    {
        return $this->belongsTo('App\Models\Workspace');
    }

    // public function search($searchKey) 
    // {

    // }
}
