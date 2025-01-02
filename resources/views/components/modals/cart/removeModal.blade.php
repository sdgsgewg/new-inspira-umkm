<div class="modal fade" id="removeModal-{{ $design->id }}" tabindex="-1"
    aria-labelledby="removeModalLabel-{{ $design->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="removeModalLabel-{{ $design->id }}">
                    @lang('quantity.confirm_removal')
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('quantity.are_you_sure') . ' "' . $design->title . '" ' . __('quantity.from_the_cart') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('quantity.cancel')</button>
                <form action="{{ route('carts.destroy', ['cart' => $cart->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="design_id" value="{{ $design->id }}">
                    <button type="submit" class="btn btn-primary">@lang('quantity.remove')</button>
                </form>
            </div>
        </div>
    </div>
</div>
