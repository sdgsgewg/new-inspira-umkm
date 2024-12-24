@extends('layouts.main')

@section('container')
    <div class="row justify-content-center mt-5">
        <div class="col-10 col-sm-8 col-lg-5">
            <div class="form-registration">
                <h1 class="mb-5 fw-bold text-center">@lang('register.title')</h1>
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="form-floating">
                        <input type="text" name="name"
                            class="form-control rounded-top @error('name') is-invalid @enderror" id="name"
                            placeholder="Name" required value="{{ old('name') }}">
                        <label for="name">@lang('register.name')</label>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                            id="username" placeholder="Username" required value="{{ old('username') }}">
                        <label for="username">@lang('register.username')</label>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" placeholder="Email" required value="{{ old('email') }}">
                        <label for="email">@lang('register.email')</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Password" required>
                        <label for="password">@lang('register.password')</label>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" placeholder="Password_confirmation" required>
                        <label for="password_confirmation">@lang('register.confirm_password')</label>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                            id="dob" placeholder="dob" required value="{{ old('dob') }}">
                        <label for="dob">@lang('register.dob')</label>
                        @error('dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <select id="gender" class="form-select rounded-0 @error('gender') is-invalid @enderror"
                            name="gender" required>
                            <option value="">@lang('register.select_gender')</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                @lang('register.male')
                            </option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                @lang('register.female')
                            </option>
                        </select>
                        <label for="gender">@lang('register.gender')</label>
                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                            id="address" placeholder="Address" required value="{{ old('address') }}">
                        <label for="address">@lang('register.address')</label>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="text" name="phoneNumber"
                            class="form-control rounded-bottom @error('phoneNumber') is-invalid @enderror" id="phoneNumber"
                            placeholder="Phone Number" required value="{{ old('phoneNumber') }}">
                        <label for="phoneNumber">@lang('register.phone')</label>
                        @error('phoneNumber')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button class="btn btn-primary w-100 py-2 mt-4" type="submit">@lang('register.register')</button>
                </form>
                <small class="d-block text-center mt-4">
                    @lang('register.have_account')
                    <a href="{{ route('login') }}">
                        @lang('register.login')
                    </a>
                </small>
            </div>
        </div>
    </div>
@endsection
