@props(['label' => null, 'name'])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-slate-700 dark:text-slate-300 text-sm font-bold mb-2">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'shadow-sm appearance-none border border-slate-300 dark:border-slate-600 rounded-xl w-full py-3 px-4 text-slate-800 dark:text-white leading-tight focus:outline-none focus:ring-4 focus:ring-primary/30 dark:bg-slate-700 dark:focus:ring-primary/50 transition-all duration-300 ease-in-out']) }}
    >

    @error($name)
    <p class="text-danger text-xs italic mt-2">{{ $message }}</p>
    @enderror
</div>
