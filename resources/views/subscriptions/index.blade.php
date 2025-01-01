@extends('layouts.main')

@section('container')
    <div class="row justify-content-center mt-5">
        <div class="col-11 col-md-8">
            <h1>@lang('subscriptions.my_subs')</h1>
            <hr class="mb-4">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session()->has('failed'))
                <div class="alert alert-danger alert-dismissible fade show col-md-12" role="alert">
                    {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @foreach ($subscriptions as $subs)
                <div class="card d-flex flex-column px-4 py-3" style="height: 10rem;">
                    <div class="d-flex justify-content-between">
                        {{-- Plan Name --}}
                        <div>
                            <h5 class="card-title">
                                {{ $subs->plan->name }}
                            </h5>
                        </div>
                        {{-- Subscription Status --}}
                        <div class="text-uppercase">
                            @if ($subs->status === 'pending')
                                <span class="badge bg-warning text-black px-3 py-2">
                                    {{ $subs->status }}
                                </span>
                            @elseif (in_array($subs->status, ['inactive', 'canceled', 'expired']))
                                <span class="badge bg-danger px-3 py-2">
                                    {{ $subs->status }}
                                </span>
                            @elseif ($subs->status === 'active')
                                <span class="badge bg-success px-3 py-2">
                                    {{ $subs->status }}
                                </span>
                            @endif
                        </div>
                    </div>
                    {{-- End Date --}}
                    <div>
                        @if ($subs->status === 'active')
                            <div class="d-flex gap-1">
                                <span>@lang('subscriptions.until')</span>
                                <span class="text-uppercase">
                                    {{ \Carbon\Carbon::parse($subs->end_date)->timezone('Asia/Jakarta')->format('d M Y') }}
                                </span>
                            </div>
                        @else
                            <div class="d-flex gap-1">
                                <span>@lang('subscriptions.payment_via')</span>
                                <span>
                                    {{ $subs->subscriptionPayment->paymentMethod->name }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="mt-auto d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            {{-- Plan Description --}}
                            <p class="m-0">
                                {{ $subs->plan->description }}
                            </p>
                            {{-- Payment Date --}}
                            @if (in_array($subs->status, ['inactive']))
                                <span class="me-1">@lang('subscriptions.payment_date')</span>
                                <span>
                                    {{ \Carbon\Carbon::parse($subs->subscriptionPayment->payment_time)->timezone('Asia/Jakarta')->format('d M Y') }}
                                </span>
                            @elseif (in_array($subs->status, ['canceled', 'expired']))
                                <span class="me-1">@lang('subscriptions.transaction_date')</span>
                                <span>
                                    {{ \Carbon\Carbon::parse($subs->created_at)->timezone('Asia/Jakarta')->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                        <div>
                            {{-- Action Button --}}
                            @if ($subs->status === 'pending')
                                <a href="{{ route('subscriptions.snap', $subs->id) }}"
                                    class="btn btn-primary text-decoration-none px-4 py-1">
                                    @lang('subscriptions.pay_now')
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
