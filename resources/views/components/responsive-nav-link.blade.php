@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-secondary text-start text-base font-medium text-white bg-gray-700 focus:outline-none focus:text-secondary focus:bg-gray-600 focus:border-secondary transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-300 hover:text-secondary hover:bg-gray-700 hover:border-secondary focus:outline-none focus:text-secondary focus:bg-gray-700 focus:border-secondary transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
