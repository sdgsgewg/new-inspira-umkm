@php
    $replyAmount = $comment->replies->count();
@endphp
@if ($replyAmount > 0)
    {{-- Button to toggle reply section --}}
    <div>
        <button class="toggleReplyBtn btn btn-dark rounded-pill text-primary-emphasis d-inline-flex gap-1"
            data-id="{{ $comment->id }}" data-reply-amount="{{ $replyAmount }}"
            onclick="toggleReply({{ $comment->id }})">
            <i class="bi bi-caret-down"></i> {{ $replyAmount }}
            {{ $replyAmount > 1 ? __('designs.replies') : __('designs.reply') }}
        </button>
    </div>
    @foreach ($comment->replies as $reply)
        <div class="mt-1">
            {{-- Reply Area --}}
            <div class="reply-section my-0" data-id={{ $comment->id }} style="display: none;">
                <div class="d-flex">
                    <div class="align-items-start rounded-circle overflow-hidden" style="width: 40px; height: 40px;">
                        @if ($reply->user->image)
                            <img src="{{ $reply->user->image }}" alt="{{ $reply->user->name }}"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ secure_asset('img/' . $reply->user->gender . '.png') }}"
                                alt="{{ $reply->user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div class="col-11 d-flex flex-column ms-2">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('books.seller', ['seller' => $reply->user->username]) }}"
                                class="text-decoration-none color-inherit m-0 me-2">
                                <small class="m-0">{{ '@' . $reply->user->username }}</small>
                            </a>
                            <small>{{ $reply->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="d-flex">
                            @if ($reply->parent_id != null)
                                <a href="{{ route('books.seller', ['seller' => $reply->parentReply->user->username]) }}"
                                    class="text-decoration-none m-0 me-1">{{ '@' . $reply->parentReply->user->username }}
                                </a>
                                <p class="m-0 ms-1">
                                    {{ $reply->reply_text }}
                                </p>
                            @else
                                <p class="m-0">
                                    {{ $reply->reply_text }}
                                </p>
                            @endif

                        </div>

                        {{-- Like, Dislike, Reply (Reply) --}}
                        <div class="d-flex flex-row my-0 align-items-center">
                            <div class="cursor-pointer">
                                <button class="btn btn-dark rounded-circle p-0 px-1 me-2">
                                    <i class="bi bi-hand-thumbs-up"></i>
                                </button>
                            </div>
                            <div class="cursor-pointer">
                                <button class="btn btn-dark rounded-circle p-0 px-1">
                                    <i class="bi bi-hand-thumbs-down"></i>
                                </button>
                            </div>
                            {{-- Button buat reply ke reply lain --}}
                            <div class="cursor-pointer">
                                <button onclick="showReplyToReplyForm({{ $reply->id }})"
                                    class="toggleButton btn btn-dark rounded-pill my-0"
                                    data-id={{ $reply->id }}>@lang('designs.reply')
                                </button>
                            </div>
                        </div>

                        {{-- Reply to Another Reply Form --}}
                        <form action="{{ route('replies.store') }}" method="POST">
                            @csrf
                            <div class="replyToReplyForm col-12" style="display: none;" data-id={{ $reply->id }}>
                                <div class="mb-3">
                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                    <input type="hidden" name="reply_id" value="{{ $reply->id }}">
                                    <textarea name="reply" class="replyToReply form-control" data-id={{ $reply->id }} placeholder="@lang('designs.write_reply')"
                                        rows="1" required oninput="handleReplyToReplyBtn({{ $reply->id }})"></textarea>
                                </div>
                                <div class="justify-content-end gap-3">
                                    <button class="cancel btn btn-secondary" data-id={{ $reply->id }} type="button"
                                        onclick="hideReplyToReplyForm({{ $reply->id }})">@lang('designs.cancel')</button>
                                    <button type="submit" class="replyToReplyBtn btn btn-primary"
                                        data-id={{ $reply->id }} disabled>@lang('designs.reply')</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    @endforeach
@endif
