@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/transaction/style.css') }}?v={{ time() }}">
@endsection

@section('container')
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
@endsection

@section('scripts')
    <script src="{{ secure_asset('js/transaction/script.js') }}?v={{ time() }}"></script>
@endsection
