<?php

namespace JustBetter\LaravelBladeTailwindMerge;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        ComponentAttributeBag::macro('tailwind', function ($classList) {
            $classList = Arr::toCssClasses($classList);

            if(class_exists('\TailwindMerge\TailwindMerge')) {
                $this->attributes['class'] = \TailwindMerge\TailwindMerge::instance()
                    ->merge($this->attributes['class'] ?? '', $classList);
                
                return $this;
            }
            
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
