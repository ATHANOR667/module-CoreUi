<button {{ $attributes->merge(['class' => $classes(), 'type' => 'button']) }}>
    {{ $slot }}
</button>
