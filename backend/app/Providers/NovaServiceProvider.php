<?php

namespace App\Providers;

use App\Nova\BlogCategory;
use App\Nova\BlogComment;
use App\Nova\BlogPost;
use App\Nova\BlogTag;
use App\Nova\Category;
use App\Nova\Coupon;
use App\Nova\Order;
use App\Nova\OrderItem;
use App\Nova\Product;
use App\Nova\Review;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use App\Nova\User;
use App\Nova\Wishlist;
use Illuminate\Http\Request;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [

                //MenuSection::dashboard(MainDashboard::class)->icon('chart-bar'),

                MenuSection::make('User Management', [
                    MenuItem::resource(User::class),
                ])->icon('users')->collapsable(),

                MenuSection::make('Product Management', [
                    MenuItem::resource(Category::class),
                    MenuItem::resource(Product::class),
                    MenuItem::resource(Review::class),
                    MenuItem::resource(Wishlist::class),                                   
                ])->icon('document-text')->collapsable(),

                MenuSection::make('Order Management', [
                    MenuItem::resource(Order::class),
                    MenuItem::resource(OrderItem::class),
                    MenuItem::resource(Coupon::class),
                ])->icon('document-text')->collapsable(),

                MenuSection::make('Blog Management', [
                    MenuItem::resource(BlogCategory::class),
                    MenuItem::resource(BlogPost::class),
                    MenuItem::resource(BlogTag::class),
                    MenuItem::resource(BlogComment::class),                    
               
                ])->icon('document-text')->collapsable(),
                MenuSection::make('Roles & Permissions', [
                    MenuItem::make('Roles',"/resources/roles"),
                    MenuItem::make('Permissions',"/resources/permissions"),
                ])->icon('lock-closed')->collapsable(),
                
                    
            ];
        });

        Nova::style('prism-css', asset('assets/prism.css'));
        Nova::script('prism-js', asset('assets/prism.js'));
        
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
           \Vyuldashev\NovaPermission\NovaPermissionTool::make(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
