@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-white border border-slate-200 cursor-default rounded-xl">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-brand-700 bg-white border border-slate-200 rounded-xl hover:text-brand-800 hover:border-brand-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 focus-visible:text-brand-800">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-brand-700 bg-white border border-slate-200 rounded-xl hover:text-brand-800 hover:border-brand-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 focus-visible:text-brand-800">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative ml-3 inline-flex items-center px-4 py-2 text-sm font-medium text-slate-400 bg-white border border-slate-200 cursor-default rounded-xl">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-slate-600">
                    <span class="font-semibold text-slate-800">{{ __('Showing') }}</span>
                    <span class="mx-1">{{ $paginator->firstItem() }}</span>
                    <span class="font-semibold text-slate-800">{{ __('to') }}</span>
                    <span class="mx-1">{{ $paginator->lastItem() }}</span>
                    <span class="font-semibold text-slate-800">{{ __('of') }}</span>
                    <span class="ml-1">{{ $paginator->total() }}</span>
                    <span class="font-semibold text-slate-800">{{ __('results') }}</span>
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-xl shadow-sm ring-1 ring-slate-200 bg-white">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-400 cursor-default rounded-l-xl">
                                <i class="fa-solid fa-chevron-left"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-brand-700 hover:text-brand-800 focus:z-20 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 focus-visible:text-brand-800 rounded-l-xl">
                            <i class="fa-solid fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-500">...</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative inline-flex items-center px-3 py-2 text-sm font-semibold text-brand-800 bg-brand-50 rounded-lg shadow-sm ring-1 ring-brand-300">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-700 hover:text-brand-700 hover:bg-brand-50 rounded-lg focus:z-20 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 focus-visible:text-brand-800">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-brand-700 hover:text-brand-800 rounded-r-xl focus:z-20 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 focus-visible:text-brand-800">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-slate-400 cursor-default rounded-r-xl">
                                <i class="fa-solid fa-chevron-right"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
