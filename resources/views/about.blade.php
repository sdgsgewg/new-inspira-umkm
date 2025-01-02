@extends('layouts.main')

@section('css')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .header {
            background: url('img/aboutHeader.jpg') no-repeat center center/cover;
            height: 400px;
            width: 100vw;
        }

        .header h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        .content {
            width: 100vw;
            max-width: 100%;
        }

        .content p {
            margin-bottom: 20px;
            text-align: justify;
            font-size: 1.4rem;
        }

        .image-row img {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* md (768px - 991px), lg (992px - 1199px), and xl  (>= 1200px) */
        @media screen and (min-width: 768px) {
            .image-row img {
                width: 45%;
            }
        }

        /* sm (< 768px) */
        @media screen and (min-width: 576px) and (max-width: 767px) {
            .image-row img {
                width: 75%;
            }
        }
    </style>
@endsection

@section('container')
    <div class="row header position-relative d-flex justify-content-center align-items-center text-white">
        <div class="col-11">
            <h1>@lang('aboutus.title') InspiraUMKM</h1>
        </div>
    </div>

    <div class="row content justify-content-center py-5">
        <div class="col-11">
            <p>@lang('aboutus.par1')</p>

            <p>@lang('aboutus.par2')</p>

            <div
                class="image-row d-flex flex-column flex-md-row justify-content-center justify-content-md-evenly align-items-center gap-5 mt-5">
                <img src="{{ secure_asset('img/umkm1.jpg') }}" alt="UMKM 1">
                <img src="{{ secure_asset('img/umkm2.jpeg') }}" alt="UMKM 2">
            </div>
        </div>
    </div>
@endsection
