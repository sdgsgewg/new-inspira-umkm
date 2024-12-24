<div class="mt-0">
    <hr>
    <h2 class="mb-3">@lang('designs.discussions')</h2>

    <!-- Comment Form -->
    <form action="{{ route('comments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <input type="hidden" name="design_id" value="{{ $design->id }}">
            <textarea name="comment" id="comment" class="form-control" placeholder="@lang('designs.write_comment')" rows="3" required
                oninput="handlePostBtn()" onclick="toggleCommentButtonVisibility()"></textarea>
        </div>
        <!-- Button Container -->
        <div id="commentBtnContainer" class="justify-content-end gap-3" style="display: none;">
            <button id="cancel" type="button" class="btn btn-secondary"
                onclick="hideCommentButtonContainer()">@lang('designs.cancel')</button>
            <button id="post" type="submit" class="btn btn-primary" disabled>@lang('designs.post')</button>
        </div>
    </form>

    <hr>

    @if ($comments->count() > 0)
        <!-- Existing Comments -->
        <div class="comments-list">
            @foreach ($comments as $comment)
                <div class="mb-3">
                    @include('components.designs.comments.comment-section')
                </div>
            @endforeach
        </div>
        <hr>
    @endif
</div>
