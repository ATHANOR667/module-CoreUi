<a href="{{ $url }}"
   class="group flex items-start gap-4 p-5 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-primary/50 hover:bg-slate-50 transition-all duration-200 cursor-pointer text-left w-full">

    <div class="shrink-0 p-3 bg-slate-100 rounded-lg group-hover:bg-primary/10 group-hover:text-primary transition-colors text-slate-500">
        {{ $icon ?? '' }}
    </div>

    <div>
        <h3 class="text-base font-semibold text-slate-800 group-hover:text-primary transition-colors">
            {{ $title }}
        </h3>

        @if($description)
            <p class="mt-1 text-sm text-slate-500">
                {{ $description }}
            </p>
        @endif
    </div>
</a>
