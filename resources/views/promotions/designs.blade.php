@extends('layouts.main')

@section('container')
    <form method="POST" action="{{ route('checkouts.checkoutFromPromo') }}">
        @csrf

        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                {{-- Choose Product Design --}}
                @foreach ($products as $product)
                    <div class="mb-3">
                        <label for="product_{{ $product->id }}" class="form-label">
                            {{ $product->name }}
                        </label>
                        <select name="product_{{ $product->id }}" id="product_{{ $product->id }}"
                            class="form-select @error('product_' . $product->id) is-invalid @enderror" required>
                            <option value="">Select a design</option>
                            @foreach ($product->designs as $design)
                                <option value="{{ $design->id }}"
                                    {{ old('product_' . $product->id) == $design->id ? 'selected' : '' }}
                                    {{ $design->stock == 0 ? 'disabled' : '' }}>
                                    {{ $design->title . ' (Rp' . number_format($design->price, 2, ',', '.') . ')' }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_' . $product->id)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                {{-- Get Promotion Data --}}
                <input type="hidden" name="promotion_id" value="{{ $promo->id }}">

                {{-- Checkout Button --}}
                <div class="d-flex justify-content-center mt-5">
                    <button type="submit" class="btn btn-primary">Checkout</button>
                </div>
            </div>
        </div>
    </form>
@endsection
