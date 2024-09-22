<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'replied_comment',
        'parent_id',
        'status'
    ];

    public function user_info()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
    public static function getAllComments()
    {
        return BlogComment::with('user_info')->paginate(10);
    }

    public static function getAllUserComments()
    {
        return BlogComment::where('user_id', auth()->user()->id)
            ->with('user_info')->paginate(10);
    }

    public function post()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')
            ->where('status', 'active');
    }
}
