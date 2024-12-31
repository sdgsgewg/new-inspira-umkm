@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex flex-column justify-content-between align-items-start gap-2 pt-3 pb-3 mb-3 border-bottom">
        <h1 class="h2">@lang('dashboard.edit_design')</h1>

        <a href="{{ route('admin.designs.index') }}" class="btn btn-success d-inline-flex"><i
                class="bi bi-arrow-left me-2"></i>@lang('dashboard.cancel')</a>
    </div>

    <div class="col-lg-8">
        <form method="POST" action="{{ route('admin.designs.update', ['design' => $design->slug]) }}" class="mb-5"
            enctype="multipart/form-data">
            @method('put')
            @csrf

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">@lang('dashboard.title')</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" required autofocus value="{{ old('title', $design->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="mb-3">
                <label for="slug" class="form-label">@lang('dashboard.slug')</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    required value="{{ old('slug', $design->slug) }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Product --}}
            <div class="mb-3">
                <label for="product" class="form-label">@lang('dashboard.product')</label>
                <select id="product" class="form-select @error('product_id') is-invalid @enderror" name="product_id"
                    required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}"
                            {{ old('product_id', $design->product_id) == $product->id ? 'selected' : '' }}>
                            @php
                                $productName = Lang::has('designs.products.' . $product->name)
                                    ? __('designs.products.' . $product->name)
                                    : $product->name;
                            @endphp
                            {{ $productName }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label for="category" class="form-label">@lang('dashboard.category')</label>
                <select id="category" class="form-select @error('category_id') is-invalid @enderror" name="category_id">
                    <!-- Categories will be dynamically loaded here -->
                </select>
                @error('category_id')
                    <div class="invalid-feedback">@lang('dashboard.category_required')</div>
                @enderror
            </div>

            {{-- Price --}}
            <div class="mb-3">
                <label for="price" class="form-label">@lang('dashboard.price')</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                    name="price" required value="{{ old('price', $design->price) }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Stock --}}
            <div class="mb-3">
                <label for="stock" class="form-label">@lang('dashboard.stock')</label>
                <input type="text" class="form-control @error('stock') is-invalid @enderror" id="stock"
                    name="stock" required value="{{ old('stock', $design->stock) }}">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image --}}
            <div class="mb-3">
                <label for="image" class="form-label">@lang('dashboard.design_image')</label>
                <input type="hidden" name="oldImage" value="{{ $design->image }}">
                @if ($design->image)
                    <img src="{{ $design->image }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                @else
                    <img class="img-preview img-fluid mb-3 col-sm-5">
                @endif
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                    name="image" onchange="previewImage()">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label for="description" class="form-label">@lang('dashboard.description')</label>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="description" type="hidden" name="description"
                    value="{{ old('description', $design->description) }}">
                <trix-editor input="description"></trix-editor>
            </div>

            <button type="submit" class="btn btn-primary">@lang('dashboard.update_design')</button>
        </form>
    </div>
@endsection

@section('scripts')
    @include('components.dashboard.design-script')
@endsection
