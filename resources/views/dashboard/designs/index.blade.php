@extends('dashboard.layouts.main')

@section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('dashboard.my_designs')</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-10" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive small col-lg-10">
        <a href="{{ route('admin.designs.create') }}" class="btn btn-primary mb-3">@lang('dashboard.create_new_design')</a>

        @if ($designs->count())
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">@lang('dashboard.title')</th>
                        <th scope="col">@lang('dashboard.product')</th>
                        <th scope="col">@lang('dashboard.category')</th>
                        <th scope="col">@lang('dashboard.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($designs as $design)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $design->title }}</td>
                            <td>
                                @php
                                    $productName = Lang::has('designs.products.' . $design->product->name)
                                        ? __('designs.products.' . $design->product->name)
                                        : $design->product->name;
                                @endphp
                                {{ $productName }}
                            </td>
                            <td>
                                @php
                                    $categoryName = Lang::has('designs.categories.' . $design->category->name)
                                        ? __('designs.categories.' . $design->category->name)
                                        : $design->category->name;
                                @endphp
                                {{ $categoryName }}
                            </td>
                            <td>
                                <a href="{{ route('admin.designs.show', ['design' => $design->slug]) }}"
                                    class="badge bg-info">
                                    <i class="bi bi-eye icon"></i>
                                </a>

                                <a href="{{ route('admin.designs.edit', ['design' => $design->slug]) }}"
                                    class="badge bg-warning">
                                    <i class="bi bi-pencil-square icon"></i>
                                </a>

                                <button type="button" class="badge bg-danger border-0" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $design->id }}">
                                    <i class="bi bi-x-circle icon"></i>
                                </button>

                                @include('components.modals.dashboard.delete-modal', [
                                    'item' => $design,
                                    'resourceType' => 'design',
                                    'resourceUrl' => 'designs',
                                ])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <tbody>
                <tr>
                    <td class="col-lg-8">
                        <p class="text-center">@lang('dashboard.no_design')</p>
                    </td>
                </tr>
            </tbody>
        @endif
    </div>
@endsection
