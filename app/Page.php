<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class, 'page_id', 'id');
    }
}
