@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex flex-column justify-content-between align-items-start gap-2 pt-3 pb-3 mb-3 border-bottom">
        <h1 class="h2">@lang('dashboard.create_new_option_value')</h1>

        <a href="{{ route('admin.option-values.index') }}" class="btn btn-success d-inline-flex"><i
                class="bi bi-arrow-left me-2"></i>@lang('dashboard.cancel')</a>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{ route('admin.option-values.index') }}" class="mb-5">
            @csrf
            <div class="mb-3">
                <label for="value" class="form-label">@lang('dashboard.option_value')</label>
                <input type="text" class="form-control @error('value') is-invalid @enderror" id="value"
                    name="value" required value="{{ old('value') }}" autofocus>
                @error('value')
                    <div class="invalid-feedback">{{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">@lang('dashboard.slug')</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    required value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="option" class="form-label">@lang('dashboard.option')</label>
                <select class="form-select @error('option_id') is-invalid @enderror" name="option_id" required>
                    <option value="">@lang('dashboard.select_option')</option>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}" {{ old('option_id') == $option->id ? 'selected' : '' }}>
                            @php
                                $optionName = Lang::has('options.options.' . $option->name)
                                    ? __('options.options.' . $option->name)
                                    : $option->name;
                            @endphp

                            {{ $optionName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">@lang('dashboard.category')</label>
                <select class="form-select" name="category_id">
                    <option value="">@lang('dashboard.select_category')</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            @php
                                $productName = Lang::has('designs.products.' . $category->product->name)
                                    ? __('designs.products.' . $category->product->name)
                                    : $category->product->name;

                                $categoryName = Lang::has('designs.categories.' . $category->name)
                                    ? __('designs.categories.' . $category->name)
                                    : $category->name;
                            @endphp

                            @if ($category->product->name === 'Banners')
                                {{ $categoryName }}
                            @else
                                @if (app()->getLocale() === 'en')
                                    {{ $categoryName . ' ' . $productName }}
                                @else
                                    {{ $productName . ' ' . $categoryName }}
                                @endif
                            @endif
                        </option>
                    @endforeach
                </select>
                <small class="fst-italic  text-secondary">
                    @lang('dashboard.optional_category')
                </small>
            </div>

            <button type="submit" class="btn btn-primary">
                @lang('dashboard.create_option_value')
            </button>
        </form>
    </div>
@endsection

@section('scripts')
    @include('components.dashboard.option-value-script')
@endsection
