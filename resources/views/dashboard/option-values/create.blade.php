@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex flex-column justify-content-between align-items-start gap-2 pt-3 pb-3 mb-3 border-bottom">
        <h1 class="h2">Create New Option Value</h1>

        <a href="{{ route('admin.option-values.index') }}" class="btn btn-success d-inline-flex"><i
                class="bi bi-arrow-left me-2"></i> Cancel</a>
    </div>

    <div class="col-lg-8">
        <form method="post" action="{{ route('admin.option-values.index') }}" class="mb-5">
            @csrf
            <div class="mb-3">
                <label for="value" class="form-label">Option Value</label>
                <input type="text" class="form-control @error('value') is-invalid @enderror" id="value"
                    name="value" required value="{{ old('value') }}" autofocus>
                @error('value')
                    <div class="invalid-feedback">{{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    required value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="option" class="form-label">Option</label>
                <select class="form-select @error('option_id') is-invalid @enderror" name="option_id" required>
                    <option value="">Select an option</option>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}" {{ old('option_id') == $option->id ? 'selected' : '' }}>
                            {{ $option->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category_id">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            @if ($category->product->name === 'Packaging')
                                {{ $category->name . ' Packaging' }}
                            @elseif ($category->product->name === 'Packaging')
                                {{ $category->name . ' Sticker' }}
                            @else
                                {{ $category->name }}
                            @endif
                        </option>
                    @endforeach
                </select>
                <small class="fst-italic  text-secondary">*optional: select 'Select a category' if you don't want to assign
                    this option
                    value to any category'</small>
            </div>

            <button type="submit" class="btn btn-primary">Create Option Value</button>
        </form>
    </div>

    @include('components.dashboard.option-value-script')
@endsection
