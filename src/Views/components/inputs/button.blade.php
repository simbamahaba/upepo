<button {{ $attributes->merge(['type' => 'submit', 'class' => 'pure-button']) }}>
    {{ $slot }}
</button>
