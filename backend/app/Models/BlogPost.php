<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'slug',
        'category_id',
        'author_id',
        'content'
    ];
    public function category(){
        return $this->belongsTo(BlogCategory::class);
    }
    public function comments(){
        return $this->hasMany(BlogComment::class);
    }
    public function tags(){
        return $this->hasMany(BlogTag::class);
    }
    public function commentsCount(){
        return $this->comments()->count();
    }
    public function tagsCount(){
        return $this->tags()->count();
    }
}
