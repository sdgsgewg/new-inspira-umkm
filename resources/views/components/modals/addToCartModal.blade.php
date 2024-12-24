@if (session('success'))
    <script>
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                keyboard: false
            });
            myModal.show();
        };
    </script>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">@lang('cart.add_to_cart_status')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column justify-content-center align-items-center">
                    <div class="overflow-hidden" style="width: 100px; height: 100px;">
                        <img src="{{ secure_asset('img/tick-2.png') }}" alt="">
                    </div>
                    <div class="fs-5 fw-bold mt-4">
                        {{ session('success') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endif
