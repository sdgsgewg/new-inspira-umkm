@extends('layouts.main')

@section('container')
    <link rel="stylesheet" href="{{ asset('css/transaction/style.css') }}?v={{ time() }}">

    <div class="row justify-content-center mt-5">
        <div class="col-11 col-md-10 d-flex flex-column">
            @include('components.transaction.transaction-header')

            <div class="content-section mt-2" id="haveOrder">
                @foreach ($transactions as $transaction)
                    <div class="transaction-card" data-status="{{ $transaction->transaction_status }}"
                        data-created-at="{{ $transaction->created_at->timestamp }}">
                        @include('components.transaction.orderReqCard', ['transaction' => $transaction])
                    </div>
                @endforeach
            </div>

            @include('components.transaction.noOrderReq')
        </div>
    </div>

    <script src="{{ asset('js/transaction/script.js') }}?v={{ time() }}"></script>
@endsection
