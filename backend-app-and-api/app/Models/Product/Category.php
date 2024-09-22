<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'image_url',
        'status',
        'is_parent',
        'parent_id',
        'added_by',
        'is_popular',
        'is_brand'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public static function getAllCategory()
    {
        return  Category::orderBy('id', 'DESC')
            ->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id)
    {
        return Category::whereIn('id', $cat_id)
            ->update(['is_parent' => 1]);
    }
    public static function getChildByParentID($id)
    {
        return Category::where('parent_id', $id)
            ->orderBy('id', 'ASC')->pluck('title', 'id');
    }

    public function child_cat()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->where('status', 'active');
    }
    public static function getAllParentWithChild()
    {
        return Category::with('child_cat')->where('is_parent', 1)
            ->where('status', 'active')->orderBy('title', 'ASC')->get();
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id');
    }
    public function products_category()
    {
        return $this->belongsToMany(Product::class);
    }
    public function sub_products()
    {
        return $this->hasMany(Product::class, 'child_cat_id', 'id')->where('status', 'active');
    }
    public static function getProductByCat($slug, $productsPerPage = 10)
    {
        return Category::with('products')->where('slug', $slug)
            ->first();
    }
    public static function getProductBySubCat($slug)
    {
        // return $slug;
        return Category::with('sub_products')->where('slug', $slug)->first();
    }
    public static function countActiveCategory()
    {
        $data = Category::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public function sub_categories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->with('subCategories');
    }
}
