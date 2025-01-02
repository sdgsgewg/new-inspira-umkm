<div class="modal fade" id="quantityModal" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="quantityModalLabel">
                    @lang('quantity.input_qty_form')
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form for input quantity -->
            <form id="quantityForm" action="" method="POST">
                @csrf

                <div class="modal-body">
                    {{-- Design Display --}}
                    <div class="row d-flex flex-row flex-nowrap">
                        {{-- Image --}}
                        <div class="col-3">
                            @if ($design->image)
                                <img src="{{ $design->image }}" alt="...">
                            @else
                                <img src="{{ secure_asset('img/' . $design->product->name) . '.jpg' }}" alt="...">
                            @endif
                        </div>
                        <div class="card-info col-9 d-flex flex-column justify-content-between ps-3">
                            {{-- Title --}}
                            <div>
                                <p class="fw-bold fs-6">{{ $design->title }}</p>
                            </div>
                            <div>
                                {{-- Price --}}
                                <p class="fw-bold fs-6 m-0">{{ 'Rp' . number_format($design->price, '2', ',', '.') }}

                                    {{-- Stock --}}
                                </p>
                                <small class="text-muted m-0">{{ __('quantity.stock') . ' ' . $design->stock }}</small>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="designId" value="{{ $design->id }}">

                </div>

                {{-- Control Quantity --}}
                <div class="modal-footer d-flex flex-row justify-content-between align-items-center">
                    <div>
                        <label for="quantity">@lang('quantity.quantity')</label>
                    </div>
                    {{-- Add or Minus Button --}}
                    <div class="d-flex gap-2">
                        {{-- Minus Button --}}
                        <button type="button"
                            class="btn btn-primary btn-decrement d-flex justify-content-center align-items-center">
                            -
                        </button>

                        {{-- Quantity Amount --}}
                        <p class="qty d-flex flex-column justify-content-center m-0">
                            1
                        </p>
                        <input type="hidden" name="quantity" id="quantity" value="1">

                        {{-- Add Button --}}
                        <button type="button"
                            class="btn btn-primary btn-increment d-flex justify-content-center align-items-center">
                            +
                        </button>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="modal-footer justify-content-center align-items-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        @lang('quantity.cancel')
                    </button>
                    <button type="submit" class="btn btn-primary" id="quantitySubmitButton">
                        {{-- Tombol akan diperbarui menggunakan JS --}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const design = @json($design);
</script>

<script src="{{ secure_asset('js/designs/inputQtyModal.js') }}?v={{ time() }}"></script>
