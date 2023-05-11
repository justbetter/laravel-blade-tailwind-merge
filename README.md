# Laravel Blade Tailwind Merge

This package adds a `->tailwind()` method to the attribute bag used within [Blade Components](https://laravel.com/docs/master/blade#component-attributes) which let you overwrite classes.

## Example

Let's say you've a Blade "link" component like this:
```
<a {{ $attributes->merge(['class' => 'flex px-5']) }}>
   {{ $slot }}
</a>
```
When you're using this like:
```
<x-button href="/" class="px-3">Home</x-button>
```
You end up with `flex px-5 px-3` instead of `flex px-3`. Because [Tailwind classes are sorted](https://github.com/tailwindlabs/tailwindcss/pull/10382) and `px-5` is listed after `px-3` our "overwrite" won't do anything.

## Installation

```
composer require justbetter/laravel-blade-tailwind-merge
```

## Usage

From the example above, just use `tailwind('...')` instead of `merge(['class' => '...')` or `class('...')` when you need this.
```
<a {{ $attributes->tailwind('flex px-5') }}>
   {{ $slot }}
</a>
```

## Known issues

Currently the merging works only by checking the first part before the dash. So `text-red-500` overwrites `text-xl` and visa versa because we only check for `text-*`. To fix this we need to know all Tailwind options just like [tailwind-merge](https://github.com/dcastil/tailwind-merge) does. Maybe in the future... but a PR is welcome!

## References

- [Tailwind Merge](https://github.com/dcastil/tailwind-merge)
- [Pull request to have this within the framework](https://github.com/laravel/framework/pull/45475)
- [Idea from @mpociot on Twitter](https://twitter.com/marcelpociot/status/1310935864848117760)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
