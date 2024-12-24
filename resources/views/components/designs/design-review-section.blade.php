<div>
    <hr>
    <h2 class="pb-2">@lang('designs.reviews')</h2>
    @foreach ($design->reviews as $review)
        <div class="d-flex mt-1">
            <div class="align-items-start rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
                @if ($review->user->image)
                    <img src="{{ asset('storage/' . $review->user->image) }}" alt="{{ $review->user->name }}"
                        style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <img src="{{ asset('img/' . $review->user->gender . ' icon.png') }}" alt="{{ $review->user->name }}"
                        style="width: 100%; height: 100%; object-fit: cover;">
                @endif
            </div>
            <div class="d-flex flex-column ms-2">
                <div class="d-flex align-items-center">
                    <a href="{{ route('designs.seller', ['seller' => $review->user->username]) }}"
                        class="text-decoration-none color-inherit m-0 me-2">
                        <small class="m-0">{{ '@' . $review->user->username }}</small>
                    </a>
                    <small>{{ $review->created_at->diffForHumans() }}</small>
                </div>
                <div class="d-inline-flex">
                    @for ($i = 0; $i < $review->rating; $i++)
                        <i class="bi bi-star-fill text-warning me-1"></i>
                    @endfor
                </div>
                <p>{{ $review->feedback }}</p>
            </div>
            <hr>
        </div>
    @endforeach
</div>
