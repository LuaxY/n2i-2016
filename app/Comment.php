<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function formation()
    {
        return $this->hasOne(Formation::class, 'id', 'formation_id');
    }

    public function page()
    {
        return $this->hasOne(Page::class, 'id', 'page_id');
    }
}
