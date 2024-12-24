@extends('layouts.main')

@section('css')
    <style>
        .img-wrapper {
            width: 240px;
            height: 240px;
        }

        /* Tablet */
        @media screen and (max-width: 767px) {
            .img-wrapper {
                width: 180px;
                height: 180px;
            }
        }
    </style>
@endsection

@section('container')
    <div class="row justify-content-center">
        <div class="col-11 col-md-8 col-lg-7 pb-2 mt-5 mb-4 border-bottom">
            <h1 class="h2">{{ $title }}</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <form method="POST" action="{{ route('users.update', ['user' => $user->username]) }}" class="w-100"
            enctype="multipart/form-data">
            @method('put')
            @csrf

            <div class="col-12 d-flex flex-column align-items-center justify-content-center">

                <div class="col-11 col-sm-8 col-md-8 col-lg-6 d-flex flex-column align-items-center mb-3">
                    <label for="image" class="form-label fs-3 mb-2">Profile Picture</label>
                    <input type="hidden" name="oldImage" value="{{ $user->image }}">
                    <div class="img-wrapper img-thumbnail rounded-circle overflow-hidden mb-3 col-5 col-sm-6 col-md-5">
                        @if ($user->image)
                            <img src="{{ secure_asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                class="img-preview rounded-circle">
                        @else
                            <img src="{{ secure_asset('img/' . $user->gender . ' icon.png') }}" alt="{{ $user->name }}"
                                class="img-preview rounded-circle">
                        @endif
                    </div>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                        name="image" onchange="previewImage()">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-11 col-sm-8 col-md-8 col-lg-6 mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" required autofocus value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-11 col-sm-8 col-md-8 col-lg-6 mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" required autofocus value="{{ old('username', $user->username) }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-11 col-sm-8 col-md-8 col-lg-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" required autofocus value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-11 col-sm-8 col-md-8 col-lg-6 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                        name="address" required autofocus value="{{ old('address', $user->address) }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-11 col-sm-8 col-md-8 col-lg-6 mb-3">
                    <label for="phoneNumber" class="form-label">Phone Number</label>
                    <input type="text" class="form-control @error('phoneNumber') is-invalid @enderror" id="phoneNumber"
                        name="phoneNumber" required autofocus value="{{ old('phoneNumber', $user->phoneNumber) }}">
                    @error('phoneNumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="{{ route('users.index') }}" class="btn btn-success text-decoration-none">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ secure_asset('js/users/script.js') }}?v={{ time() }}"></script>
@endsection
