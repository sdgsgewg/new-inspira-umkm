@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('dashboard.design_categories')</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-6" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Design Accordion --}}
    <div class="table-responsive small col-lg-8">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">@lang('dashboard.create_new_category')</a>

        <div class="accordion" id="accordionExample">
            @foreach ($products as $product)
                <?php $idx = 0; ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ session('product_id') == $product->id ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}"
                            aria-expanded="{{ session('product_id') == $product->id ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $loop->iteration }}">
                            @php
                                $productName = Lang::has('designs.products.' . $product->name)
                                    ? __('designs.products.' . $product->name)
                                    : $product->name;
                            @endphp
                            {{ $productName }}
                        </button>
                    </h2>
                    <div id="collapse{{ $loop->iteration }}"
                        class="accordion-collapse collapse {{ session('product_id') == $product->id ? 'show' : '' }}"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">@lang('dashboard.category_name')</th>
                                        <th scope="col">@lang('dashboard.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        @if ($category->product_id == $product->id)
                                            <?php $idx++; ?>
                                            <tr>
                                                <td>{{ $idx }}</td>
                                                <td>
                                                    @php
                                                        $categoryName = Lang::has(
                                                            'designs.categories.' . $category->name,
                                                        )
                                                            ? __('designs.categories.' . $category->name)
                                                            : $category->name;
                                                    @endphp
                                                    {{ $categoryName }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.categories.edit', ['category' => $category->slug]) }}"
                                                        class="badge bg-warning">
                                                        <i class="bi bi-pencil-square icon"></i>
                                                    </a>

                                                    <button type="button" class="badge bg-danger border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal-{{ $category->id }}">
                                                        <i class="bi bi-x-circle icon"></i>
                                                    </button>

                                                    @include('components.modals.dashboard.delete-modal', [
                                                        'item' => $category,
                                                        'resourceType' => 'category',
                                                        'resourceUrl' => 'categories',
                                                    ])

                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
