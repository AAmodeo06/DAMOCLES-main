@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-sky-800 focus:border-sky-900 focus:ring-sky-800 rounded-md shadow-sm w-full']) !!}>
