@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-sky-800 text-sm font-medium leading-5 text-sky-900 focus:outline-none focus:border-sky-500 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-sky-800 hover:text-sky-700 hover:border-sky-800 focus:outline-none focus:text-sky-700 focus:border-sky-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
