<style>
    .search-result {
        position: absolute;
        background-color: #2c2c2f;
        height: fit-content;
        max-height: 280px;
        overflow-y: scroll;
        padding: 10px;
        z-index: 100;
    }

    .result-item:hover {
        background-color: rgba(255, 255, 255, 0.2);
        cursor: pointer;
    }
</style>

<div class="search-result col-11 rounded-3 text-white">
    @if ($filteredDesigns->isNotEmpty())
        @foreach ($filteredDesigns as $design)
            <p class="result-item m-0 p-2" data-title="{{ $design->title }}">{{ $design->title }}</p>
        @endforeach
    @else
        <p class="m-0">No design found</p>
    @endif
</div>
