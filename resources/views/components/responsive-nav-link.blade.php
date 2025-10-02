@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-sky-600 text-start text-base font-medium text-sky-700 bg-sky-50 focus:outline-none focus:text-sky-800 focus:bg-sky-100 focus:border-sky-500 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-sky-800 hover:text-sky-700 hover:bg-sky-50 hover:border-sky-600 focus:outline-none focus:text-sky-800 focus:bg-sky-50 focus:border-sky-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
