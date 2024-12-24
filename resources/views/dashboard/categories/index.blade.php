@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Design Categories</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-6" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- Design Tabel Biasa --}}
    {{-- <div class="table-responsive small col-lg-8">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>

        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>

                            <a href="{{ route('admin.categories.edit', ['category' => $category->slug]) }}"
                                class="badge bg-warning">
                                <i class="bi bi-pencil-square icon"></i>
                            </a>

                            <form action="{{ route('admin.categories.destroy', ['category' => $category->slug]) }}"
                                method="POST" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-x-circle icon"></i>
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}

    {{-- Design Accordion --}}
    <div class="table-responsive small col-lg-8">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>

        <div class="accordion" id="accordionExample">
            @foreach ($products as $product)
                <?php $idx = 0; ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ session('product_id') == $product->id ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}"
                            aria-expanded="{{ session('product_id') == $product->id ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $loop->iteration }}">
                            {{ $product->name }}
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
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        @if ($category->product_id == $product->id)
                                            <?php $idx++; ?>
                                            <tr>
                                                <td>{{ $idx }}</td>
                                                <td>{{ $category->name }}</td>
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
