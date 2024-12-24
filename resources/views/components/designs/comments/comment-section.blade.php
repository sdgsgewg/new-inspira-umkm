{{-- Comment Area --}}
<div class="comment-section my-0">
    <div class="d-flex">
        <div class="align-items-start rounded-circle overflow-hidden" style="width: 50px; height: 50px;">
            @if ($comment->user->image)
                <img src="{{ secure_asset('storage/' . $comment->user->image) }}" alt="{{ $comment->user->name }}"
                    style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <img src="{{ secure_asset('img/' . $comment->user->gender . ' icon.png') }}" alt="{{ $comment->user->name }}"
                    style="width: 100%; height: 100%; object-fit: cover;">
            @endif
        </div>
        <div class="col-11 d-flex flex-column ms-2">
            <div class="d-flex align-items-center m-0">
                {{-- <a href="{{ route('designs.seller', ['seller' => $comment->user->username]) }}"
                    class="text-decoration-none color-inherit m-0 me-2"> --}}
                <small class="me-2">{{ '@' . $comment->user->username }}</small>
                {{-- </a> --}}
                <small class="m-0">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div>
                <p class="m-0">
                    {{ $comment->comment_text }}
                </p>
            </div>

            {{-- Like, Dislike, Reply (Comment) --}}
            <div class="d-flex flex-row my-0 align-items-center">
                <div class="cursor-pointer">
                    <button class="btn custom-btn rounded-circle p-0 px-1 me-2">
                        <i class="bi bi-hand-thumbs-up"></i>
                    </button>
                </div>
                <div class="cursor-pointer">
                    <button class="btn custom-btn rounded-circle p-0 px-1">
                        <i class="bi bi-hand-thumbs-down"></i>
                    </button>
                </div>
                <div class="cursor-pointer">
                    <button onclick="showReplyForm({{ $comment->id }})"
                        class="toggleButton btn custom-btn rounded-pill my-0"
                        data-id={{ $comment->id }}>@lang('designs.reply')
                    </button>
                </div>
            </div>

            <!-- Reply Form -->
            <form action="{{ route('replies.store') }}" method="POST" class="col-12">
                @csrf
                <div class="replyForm col-12" style="display: none;" data-id={{ $comment->id }}>
                    <div class="col-12 mb-3">
                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                        <textarea name="reply" class="reply form-control" data-id={{ $comment->id }} placeholder="@lang('designs.write_reply')"
                            rows="2" required oninput="handleReplyBtn({{ $comment->id }})"></textarea>
                    </div>
                    <div class="col-12 justify-content-end gap-3">
                        <button class="cancel btn btn-secondary" data-id={{ $comment->id }} type="button"
                            onclick="hideReplyForm({{ $comment->id }})">@lang('designs.cancel')</button>
                        <button type="submit" class="replyBtn btn btn-primary" data-id={{ $comment->id }}
                            disabled>@lang('designs.reply')</button>
                    </div>
                </div>
            </form>

            @include('components.designs.comments.reply-section')
        </div>

    </div>

</div>
