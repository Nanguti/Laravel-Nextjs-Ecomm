<?php

namespace App\Nova;


use App\Nova\Filters\ProductsByCategory;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product\Product>
     */
    public static $model = \App\Models\Product\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'slug',
        'category_id',
        'description',
        'price',
        'stock'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        // 'name',
        // 'is_top'
        return [
            ID::make()->sortable(),
            BelongsTo::make('Category')->required()->sortable(),
            BelongsTo::make('Brand')->nullable()->sortable(),
            Text::make('Product Code')->nullable()->sortable(),
            Text::make('Name')->required()->sortable(),
            Slug::make('Slug')->from('Name')->sortable(),
            Textarea::make('Meta Title')->required()->sortable(),
            Textarea::make('Meta Description')->required()->sortable(),
            Textarea::make('Summary')->required()->sortable(),
            Textarea::make('Description')->required()->sortable(),
            Number::make('Price')->required()->sortable(),
            Number::make('Discount')->nullable()->sortable(),
            Number::make('Stock')->required()->sortable(),
            Number::make('Size')->nullable()->sortable(),

            Select::make('Status')
                ->options([
                    'active' => 'Publish',
                    'inactive' => 'Draft'
                ])->default('inactive'),
            Select::make('Is Featured')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No'
                ])->default(0),
            Select::make('Is Top')
                ->options([
                    '1' => 'Yes',
                    '0' => 'No'
                ])->default(0),
            Image::make('Featured Image')->required(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new ProductsByCategory
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
