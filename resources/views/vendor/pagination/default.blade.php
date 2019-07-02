@if ($paginator->hasPages())
    <div class="layui-box layui-laypage layui-laypage-default">
        @if ($paginator->onFirstPage())
            <a href="javascript:;" class="layui-laypage-prev layui-btn-disabled" data-page="1">上一页</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="layui-laypage-prev" data-page="1">上一页</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                {{--<li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>--}}
                <span class="layui-laypage-spr">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="layui-laypage-curr">
                                <em class="layui-laypage-em"></em>
                                <em>{{ $page }}</em>
                            </span>
                    @else
                        <a href="{{ $url }}" data-page="{{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="layui-laypage-next" data-page="3">下一页</a>
        @else
            <a href="javascript:;" class="layui-laypage-next layui-btn-disabled" data-page="3">下一页</a>
        @endif
    </div>
@endif