<?php

namespace App\Models\Product;

use App\Models\Cart\Cart;
use App\Models\Customer\Wishlist;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $sortable = [
        'index_column' => 'sort_order',
        'sort_when_creating' => true,
    ];
    protected $fillable = [
        'name',
        'product_code',
        'slug',
        'summary',
        'description',
        'category_id',
        'price',
        'brand_id',
        'discount',
        'status',
        'feature_image',
        'size',
        'stock',
        'is_featured',
        'is_top'
    ];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(Media::class, 'model_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subCategoryInformation()
    {
        return $this->belongsTo(Category::class, 'child_category_id');
    }
    public static function getAllProduct()
    {
        return Product::with(['cat_info', 'subCategoryInformation'])
            ->orderBy('id', 'desc')
            ->paginate(10);
    }
    public function relatedProducts()
    {
        return $this->hasMany(Product::class, 'cat_id', 'cat_id')
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->limit(4);
    }
    public function productReviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id')
            ->with('user_info')
            ->where('status', 'active')
            ->orderBy('id', 'DESC');
    }
    public static function getProductBySlug($slug)
    {
        return Product::with([
            'categoryInformation',
            'relatedProducts',
            'productReviews'
        ])
            ->where('slug', $slug)
            ->first();
    }
    public static function countActiveProduct()
    {
        $data = Product::where('status', 'active')
            ->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public function carts()
    {
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(130)
            ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')->singleFile();
        $this->addMediaCollection('product_images_collection');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
