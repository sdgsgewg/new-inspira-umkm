@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Design Option Values</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-8" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Design Accordion --}}
    <div class="table-responsive small col-lg-8">
        <a href="{{ route('admin.option-values.create') }}" class="btn btn-primary mb-3">Create New Option Value</a>

        <div class="accordion" id="accordionExample">
            @foreach ($options as $option)
                <?php $idx = 0; ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ $selectedOptionId == $option->id ? '' : 'collapsed' }}"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}"
                            aria-expanded="{{ $selectedOptionId == $option->id ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $loop->iteration }}">
                            {{ $option->name }}
                        </button>
                    </h2>
                    <div id="collapse{{ $loop->iteration }}"
                        class="accordion-collapse collapse {{ $selectedOptionId == $option->id ? 'show' : '' }}"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Option Value</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($optionValues as $ov)
                                        @if ($ov->option_id == $option->id)
                                            <?php $idx++; ?>
                                            <tr>
                                                <td>{{ $idx }}</td>
                                                <td>{{ $ov->value }}</td>
                                                <td>{{ !isset($ov->category->name) ? '-' : $ov->category->name }}</td>
                                                <td>

                                                    <a href="{{ route('admin.option-values.edit', ['option_value' => $ov->slug]) }}"
                                                        class="badge bg-warning">
                                                        <i class="bi bi-pencil-square icon"></i>
                                                    </a>

                                                    <button type="button" class="badge bg-danger border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal-{{ $ov->id }}">
                                                        <i class="bi bi-x-circle icon"></i>
                                                    </button>

                                                    @include('components.modals.dashboard.delete-modal', [
                                                        'item' => $ov,
                                                        'resourceType' => 'option_value',
                                                        'resourceUrl' => 'option-values',
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
