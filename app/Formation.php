<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'formation_id', 'id');
    }
}
