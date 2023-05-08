<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded=[];

    // generate slug on saved
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            $slug = Str::slug($post->title, '-');
            $post->slug = static::whereSlug($slug)->exists() ?  rand(100,999)."-{$slug}" : $slug;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
