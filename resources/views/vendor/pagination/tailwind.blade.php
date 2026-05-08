@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-slate-500">
            Mostrando <span class="font-semibold text-brand-900">{{ $paginator->firstItem() }}</span>
            a <span class="font-semibold text-brand-900">{{ $paginator->lastItem() }}</span>
            de <span class="font-semibold text-brand-900">{{ $paginator->total() }}</span> registros
        </div>

        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-brand-100 bg-white/80 text-slate-300">
                    <span aria-hidden="true">&lsaquo;</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-brand-100 bg-white text-brand-900 shadow-sm transition hover:bg-brand-50" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&lsaquo;</span>
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-2 text-sm text-slate-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex h-10 min-w-10 items-center justify-center rounded-full bg-brand-800 px-3 text-sm font-semibold text-white shadow-soft">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="inline-flex h-10 min-w-10 items-center justify-center rounded-full border border-brand-100 bg-white px-3 text-sm font-semibold text-brand-900 shadow-sm transition hover:bg-brand-50" aria-label="@lang('Go to page :page', ['page' => $page])">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-brand-100 bg-white text-brand-900 shadow-sm transition hover:bg-brand-50" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&rsaquo;</span>
                </a>
            @else
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-brand-100 bg-white/80 text-slate-300">
                    <span aria-hidden="true">&rsaquo;</span>
                </span>
            @endif
        </div>
    </nav>
@endif
