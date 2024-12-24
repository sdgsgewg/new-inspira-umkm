<link rel="stylesheet" href="{{ secure_asset('css/designs/style.css') }}?v={{ time() }}">

<div class="row justify-content-center my-5">
    <div class="col-11 col-md-6 d-flex flex-column ">
        <h1 class="text-center mb-5">{{ $title }}</h1>
        <div class="d-flex flex-row gap-3">
            <div class="col-11">
                @include('components.search', ['id' => 2])
            </div>
            <div class="col-1">
                @include('components.filter')
            </div>
        </div>
    </div>
</div>
