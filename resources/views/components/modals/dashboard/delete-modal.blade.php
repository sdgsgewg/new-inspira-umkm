<div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel-{{ $item->id }}">
                    @lang('dashboard.confirm_deletion')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $resourceName = $resourceType == 'design' ? $item->title : $item->name;
                @endphp
                {{ __('dashboard.delete_confirmation') . ' ' . $resourceType . ' "' . $resourceName . '" ?' }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('dashboard.cancel')</button>
                <form action="{{ route('admin.' . $resourceUrl . '.destroy', [$resourceType => $item->slug]) }}"
                    method="POST" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-primary">@lang('dashboard.delete')</button>
                </form>
            </div>
        </div>
    </div>
</div>
