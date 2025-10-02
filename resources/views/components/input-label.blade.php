@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-sky-700']) }}>
    {{ $value ?? $slot }}
</label>
