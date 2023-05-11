<?php

namespace JustBetter\LaravelBladeTailwindMerge;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        ComponentAttributeBag::macro('tailwind', function ($classList) {
            $this->attributes['class'] = collect(explode(" ", $classList))
                ->mapWithKeys(fn($v) => [Str::of($v)->match("/.*?\-/")->toString() => $v])
                ->merge(
                    collect(explode(" ", $this->attributes['class'] ?? ''))
                        ->mapWithKeys(fn($v) => [Str::of($v)->match("/.*?\-/")->toString() => $v])
                )
                ->flatten()
                ->join(' ');

            return $this;
        });
    }
}
