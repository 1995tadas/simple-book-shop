<button {{ $attributes->merge(['type' => 'submit', 'class' => ' hover:opacity-50 py-1 px-5 border-2 border-black rounded focus:outline-none cursor-pointer']) }}>
    {{ $slot }}
</button>
