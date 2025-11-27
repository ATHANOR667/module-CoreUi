<div class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
    <div class="overflow-x-auto">
        <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-slate-200 dark:divide-slate-700']) }}>
            {{ $slot }}
        </table>
    </div>
</div>
