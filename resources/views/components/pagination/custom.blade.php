@if ($paginator->hasPages())
<ul class="pagination home-product__pagination">

    @if ($paginator->onFirstPage())
    <li class="disabled">
        <a class="pagination-item__link">
            <i class="paginaton fas fa-angle-left"></i>
        </a>
    </li>
    @else
    <li class="pagination-item">
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-item__link">
            <i class="paginaton fas fa-angle-left"></i>
        </a>
    </li>
    @endif



    @foreach ($elements as $element)

    @if (is_string($element))
    <li class="disabled"><span>{{ $element }}</span></li>
    @endif



    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="active my-active"><span>{{ $page }}</span></li>
    @else
    <li class="pagination-item pagination-item__active">
        <a href="{{ $url }}" class="pagination-item__link">{{ $page }}</a>
    </li>
    @endif
    @endforeach
    @endif
    @endforeach



    @if ($paginator->hasMorePages())
    <li class="pagination-item">
        <a href="{{ $paginator->nextPageUrl() }}" class="pagination-item__link">
            <i class="paginaton fas fa-angle-right"></i>
        </a>
    </li>
    @else
    <!-- <li class="disabled"><span>Next →</span></li> -->
    <li class="disabled">
        <a class="pagination-item__link">
            <i class="paginaton fas fa-angle-right"></i>
        </a>
    </li>
    @endif
</ul>
@endif