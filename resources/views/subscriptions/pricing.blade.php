@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/subscriptions/pricing.css') }}">
@endsection

@section('container')
    <div class="container py-3">
        <header>
            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-4 fw-normal text-body-emphasis">@lang('subscriptions.pricing')</h1>
                <p class="fs-5 text-body-secondary">
                    @lang('subscriptions.subs_desc')
                </p>
            </div>
        </header>

        <main>
            <div class="row row-cols-1 row-cols-md-{{ count($plans) }} mb-3 text-center">
                @foreach ($plans as $plan)
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm {{ $loop->last ? 'border-primary' : '' }}">
                            {{-- Plan Name --}}
                            <div class="card-header py-3 {{ $loop->last ? 'text-bg-primary border-primary' : '' }}">
                                <h4 class="my-0 fw-normal">
                                    {{ $plan->name }}
                                </h4>
                            </div>
                            <div class="card-body">
                                {{-- Plan Price --}}
                                <h1 class="card-title pricing-card-title">
                                    Rp{{ number_format($plan->price, 2, ',', '.') }}
                                    {{-- Plan Billing Cycle --}}
                                    <small class="text-body-secondary fw-light">/{{ $plan->billing_cycle }}</small>
                                </h1>
                                {{-- Plan Description --}}
                                <h5 class="mt-4">
                                    {{ $plan->description }}
                                </h5>
                                {{-- Plan Features --}}
                                <ul class="list-unstyled mt-3 mb-4">
                                    <h5>@lang('subscriptions.features')</h5>
                                    @foreach (json_decode($plan->features, true) as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                                {{-- Get Started Button --}}
                                <a href="{{ $plan->button_url }}" class="w-100 btn btn-lg {{ $plan->button_class }}">
                                    @lang('subscriptions.get_started')
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- <h2 class="display-6 text-center mb-4">Compare plans</h2>

            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th style="width: 34%"></th>
                            <th style="width: 22%">Free</th>
                            <th style="width: 22%">Pro</th>
                            <th style="width: 22%">Enterprise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="text-start">Public</th>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Private</th>
                            <td></td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                        </tr>
                    </tbody>

                    <tbody>
                        <tr>
                            <th scope="row" class="text-start">Permissions</th>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Sharing</th>
                            <td></td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Unlimited members</th>
                            <td></td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="text-start">Extra security</th>
                            <td></td>
                            <td></td>
                            <td>
                                <svg class="bi" width="24" height="24">
                                    <use xlink:href="#check" />
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> --}}
        </main>

    </div>
@endsection
