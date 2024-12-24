<div>
    <form class="searchForm{{ $id }}" action="{{ route('designs.filter') }}" method="get"
        onsubmit="return validateSearch(this)">
        <!-- Include existing query parameters as hidden fields -->
        @foreach (request()->except('search', '_token') as $key => $value)
            @if (is_array($value))
                @foreach ($value as $subValue)
                    @if (is_array($subValue))
                        @foreach ($subValue as $innerValue)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $innerValue }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}[]" value="{{ $subValue }}">
                    @endif
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach

        <div class="position-relative input-group">
            <div class="col-12">
                <input type="text" class="form-control rounded-pill ps-4 searchInput{{ $id }}"
                    placeholder=@lang('designs.search') name="search" value="{{ request('search') }}" autocomplete="off"
                    style="padding-right: 80px;">
            </div>
            <div class="position-absolute search-btn" style="right: 0%; top: 0%;">
                <button class="btn btn-outline-success rounded-pill px-4" type="submit" style="padding: 5.8px 0;">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<div class="position-relative searchResults{{ $id }}"></div>

<script src="{{ asset('js/designs/search.js') }}?v={{ time() }}"></script>
