<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'body', 'thumbnail',
    ];

    protected $with = [
        'author', 'category', 'tags', 
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTakeImageAttribute()
    {
        return "/storage/" . $this->thumbnail;
    }
}
