<div class="modal fade" id="sendFeedbackModal-{{ $design->id }}" tabindex="-1"
    aria-labelledby="sendFeedbackModalLabel-{{ $design->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sendFeedbackModalLabel-{{ $design->id }}">
                    @lang('feedback.send_feedback_form')
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form for sending feedback -->
            <form action="{{ route('sendFeedback') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="col-12 mb-3 d-flex flex-row">
                        <div class="img-wrapper col-2 col-lg-2">
                            @if ($design->image)
                                <img src="{{ secure_asset('storage/' . $design->image) }}" alt="...">
                            @else
                                <img src="{{ secure_asset('img/' . $design->product->name) . '.jpg' }}" alt="...">
                            @endif
                        </div>
                        <div class="card-info col-10 col-lg-10 ps-3">
                            <div>
                                <p class="fw-bold">{{ $design->title }}</p>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="design_id" value="{{ $design->id }}">

                    <div class="mb-3">
                        <label for="rating-{{ $design->id }}"
                            class="form-label">{{ __('feedback.rate') . ':' }}</label>
                        <select class="form-select" id="rating-{{ $design->id }}" name="rating" required>
                            <option value="" disabled selected>@lang('feedback.select_rating')</option>
                            <option value="1">1 - @lang('feedback.very_bad')</option>
                            <option value="2">2 - @lang('feedback.bad')</option>
                            <option value="3">3 - @lang('feedback.average')</option>
                            <option value="4">4 - @lang('feedback.good')</option>
                            <option value="5">5 - @lang('feedback.very_good')</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="feedback-{{ $design->id }}"
                            class="form-label">{{ __('feedback.feedback') . ': ' }}</label>
                        <textarea class="form-control" id="feedback-{{ $design->id }}" name="feedback" rows="3"
                            placeholder="{{ __('feedback.optional_feedback') }}"></textarea>

                    </div>
                </div>

                <!-- Submit button -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('feedback.cancel')</button>
                    <button type="submit" class="btn btn-primary">@lang('feedback.send_feedback')</button>
                </div>
            </form>
        </div>
    </div>
</div>
