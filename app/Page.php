<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function formation()
    {
        return $this->hasOne(Formation::class, 'id', 'formation_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'page_id', 'id');
    }
}
