<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'background_photo',
        'title',
        'description',
    ];

    protected $appends = [
        'background_photo_url'
    ];

    public function getBackgroundPhotoUrlAttribute() {
        $url = $this->background_photo ? asset("images/background-photos/" . $this->background_photo) : 'https://online.neas.org.au/wp-content/plugins/learndash-course-grid/assets/img/thumbnail.jpg';
        return $url;
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }
}
