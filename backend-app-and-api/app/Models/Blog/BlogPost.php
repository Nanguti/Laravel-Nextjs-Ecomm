<?php

namespace App\Models\Blog;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'tags',
        'summary',
        'slug',
        'description',
        'photo',
        'quote',
        'post_cat_id',
        'post_tag_id',
        'added_by',
        'status'
    ];
    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
    public function tags()
    {
        return $this->hasMany(BlogTag::class);
    }
    public function commentsCount()
    {
        return $this->comments()->count();
    }
    public function tagsCount()
    {
        return $this->tags()->count();
    }

    public function author_info()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
    public static function getAllPost()
    {
        return BlogPost::with(['categoryInformation', 'author_info'])
            ->orderBy('id', 'DESC')->paginate(10);
    }
    public static function getPostBySlug($slug)
    {
        return BlogPost::with(['tag_info', 'author_info'])
            ->where('slug', $slug)
            ->where('status', 'active')->first();
    }

    public function allComments()
    {
        return $this->hasMany(BlogComment::class)
            ->where('status', 'active');
    }

    public static function getBlogByTag($slug)
    {
        return BlogPost::where('tags', $slug)->paginate(8);
    }

    public static function countActivePost()
    {
        $data = BlogPost::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
}
