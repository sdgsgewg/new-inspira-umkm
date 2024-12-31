@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex flex-column justify-content-between align-items-start gap-2 pt-3 pb-3 mb-3 border-bottom">
        <h1 class="h2">@lang('dashboard.edit_option')</h1>

        <a href="{{ route('admin.options.index') }}" class="btn btn-success d-inline-flex"><i
                class="bi bi-arrow-left me-2"></i>@lang('dashboard.cancel')</a>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{ route('admin.options.update', ['option' => $option->slug]) }}" class="mb-5">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">@lang('dashboard.option_name')</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    required autofocus value="{{ old('name', $option->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">@lang('dashboard.slug')</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    required value="{{ old('slug', $option->slug) }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">@lang('dashboard.update_option')</button>
        </form>
    </div>
@endsection

@section('scripts')
    @include('components.dashboard.option-script')
@endsection
