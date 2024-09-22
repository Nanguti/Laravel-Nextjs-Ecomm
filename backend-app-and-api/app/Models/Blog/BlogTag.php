<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'status'
    ];

    public function posts()
    {
        return $this->hasMany(BlogPost::class);
    }
}
