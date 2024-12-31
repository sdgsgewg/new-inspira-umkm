@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex flex-column justify-content-between align-items-start gap-2 pt-3 pb-3 mb-3 border-bottom">
        <h1 class="h2">@lang('dashboard.edit_category')</h1>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-success d-inline-flex"><i
                class="bi bi-arrow-left me-2"></i>@lang('dashboard.cancel')</a>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{ route('admin.categories.update', ['category' => $category->slug]) }}" class="mb-5"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">@lang('dashboard.category_name')</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    required autofocus value="{{ old('name', $category->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">@lang('dashboard.slug')</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    required value="{{ old('slug', $category->slug) }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="product" class="form-label">@lang('dashboard.product')</label>
                <select class="form-select @error('product_id') is-invalid @enderror" name="product_id" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id', $category->product_id) == $product->id ? 'selected' : '' }}>
                            @php
                                $productName = Lang::has('designs.products.' . $product->name)
                                    ? __('designs.products.' . $product->name)
                                    : $product->name;
                            @endphp
                            {{ $productName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">@lang('dashboard.update_category')</button>
        </form>
    </div>
@endsection

@section('scripts')
    @include('components.dashboard.category-script')
@endsection
