<div class="modal fade" id="maxQtyModal-{{ $design->id }}" tabindex="-1"
    aria-labelledby="maxQtyModalLabel-{{ $design->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="maxQtyModalLabel-{{ $design->id }}">
                    @lang('quantity.qty_limit_reached')
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('quantity.qty_limit_msg') . ' "' . $design->title . '"' }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
