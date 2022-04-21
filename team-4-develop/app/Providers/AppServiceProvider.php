<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // if ($this->app->isLocal()) {
        //     $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        // }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('search', function ($attributes, string $searchTerm) {
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });
        
            return $this;
        });

        Builder::macro('orSearchWhereHas', function ($attributes, string $searchTerm) {
            return $this->orWhere(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $key => $attribute) {
                    $query->orWhereHas($key, function (Builder $query) use ($searchTerm, $attribute) {
                        $query->search($attribute, $searchTerm);
                    });
                }
            });
        });

        Builder::macro('andWhen', function ($attributes) {
            return $this->where(function (Builder $query) use ($attributes) {
                foreach (Arr::wrap($attributes) as $key => $value) {
                    $query->when($key, function (Builder $query) use ($key, $value) {
                        $query->where($key, $value);
                    });
                }
            });
        });

        Builder::macro('searchWhereHas', function ($attributes, string $id) {
            return $this->where(function (Builder $query) use ($attributes, $id) {
                foreach (Arr::wrap($attributes) as $key => $attribute) {
                    $query->orWhereHas($key, function (Builder $query) use ($id, $attribute) {
                        $query->where($attribute, $id);
                    });
                }
            });
        });
    }
}
