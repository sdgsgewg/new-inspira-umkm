<div class="card order-card col-12 rounded p-3 mb-4 d-flex flex-column"
    onclick="window.location.href='{{ route('transactions.show', ['transaction' => $transaction->order_number]) }}'">

    <div class="col-12 mb-2 d-flex justify-content-between">
        <h6 class="fw-bold">
            @lang('order.from') {{ $transaction->buyer->name }}
        </h6>
        <h6 class="text-success-emphasis">
            @lang('order.status.' . $transaction->transaction_status)
        </h6>
    </div>

    @include('components.transaction.cardContent')

    @php
        $statusLabels = [
            'Not Paid' => 'Awaiting Payment',
            'Pending' => 'Review',
            'Accepted' => 'Process Order',
            'Delivered' => 'Confirm Delivery',
            'Returned' => 'Handle Return',
            'Completed' => 'Finalize',
            'Cancelled' => $transaction->transaction_status === 'Pending' ? 'Decline' : 'Cancel',
        ];
    @endphp

    <div class="col-12 mt-2 d-flex flex-row justify-content-end gap-3">

        {{-- View detail Onluy --}}
        @if (in_array($transaction->transaction_status, ['Not Paid', 'Returned', 'Completed', 'Cancelled']))
            <div class="col-12 mt-2 d-flex flex-row justify-content-end">
                <a href="{{ route('transactions.show', ['transaction' => $transaction->order_number]) }}"
                    class="btn btn-primary">@lang('order.view_detail')
                </a>
            </div>
            {{-- Delivered --}}
        @elseif ($transaction->transaction_status === 'Delivered')
            @if ($transaction->isReceived)
                @foreach ($transaction->nextStatuses as $status)
                    @if ($status === 'Completed')
                        <form
                            action="{{ route('transactions.updateStatus', ['transaction' => $transaction->order_number]) }}"
                            method="POST">
                            @csrf
                            <input name="choice" type="hidden" value="{{ $status }}">
                            <button type="submit"
                                class="btn {{ in_array($status, ['Cancelled', 'Returned']) ? 'btn-danger' : 'btn-primary' }}">
                                @lang('order.statusLabels.' . $statusLabels[$status] ?? $status)
                            </button>
                        </form>
                    @endif
                @endforeach
            @else
                <a href="{{ route('transactions.show', ['transaction' => $transaction->order_number]) }}"
                    class="btn btn-primary">@lang('order.view_detail')
                </a>
            @endif
        @else
            @foreach ($transaction->nextStatuses as $status)
                <form action="{{ route('transactions.updateStatus', ['transaction' => $transaction->order_number]) }}"
                    method="POST">
                    @csrf
                    <input name="choice" type="hidden" value="{{ $status }}">
                    <button type="submit"
                        class="btn {{ in_array($status, ['Cancelled', 'Returned']) ? 'btn-danger' : 'btn-primary' }}">
                        @lang('order.statusLabels.' . $statusLabels[$status] ?? $status)
                    </button>
                </form>
            @endforeach
        @endif

    </div>
</div>
