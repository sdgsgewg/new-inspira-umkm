@extends('layouts.main')

@section('container')
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-10 col-sm-8 col-lg-5">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="form-signin">
                <h1 class="mb-5 fw-bold text-center">@lang('login.title')</h1>
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-floating">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                        <label for="email">@lang('login.email')</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password"
                            required>
                        <label for="password">@lang('login.password')</label>
                    </div>

                    <button class="btn btn-primary w-100 py-2" type="submit">@lang('login.login')</button>
                </form>

                <small class="d-block text-center mt-3">
                    @lang('login.dont_have_account')
                    <a href="/register">
                        @lang('login.register')
                    </a>
                </small>
            </div>
        </div>
    </div>
@endsection
