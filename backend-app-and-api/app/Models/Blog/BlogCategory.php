<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];
    public function posts()
    {
        return $this->hasMany(BlogPost::class);
    }
    public static function getBlogByCategory($slug)
    {
        return BlogCategory::with('post')->where('slug', $slug)
            ->first();
    }
}
