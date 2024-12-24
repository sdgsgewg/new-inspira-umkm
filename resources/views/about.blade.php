@extends('layouts.main')

@section('container')
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    .header {
        position: relative;
        background: url('/img/aboutHeader.jpg') no-repeat center center/cover;
        height: 400px;
        width: 100vw;
        display: flex;
        align-items: center;
        padding-left: 5%;
        color: white;
    }

    .header h1 {
        font-size: 4em;
        font-weight: bold;
    }

    .content {
        padding: 40px 5%;
        width: 100vw;
        max-width: 100%;
    }

    .content p {
        margin-bottom: 20px;
        text-align: justify;
        font-size: 1.5em;
    }

    .image-row {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 40px;
    }

    .image-row img {
        width: 45%;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="header">
    <h1>@lang('aboutus.title') InspiraUMKM</h1>
</div>

<div class="content">
    <p>@lang('aboutus.par1')</p>

    <p>@lang('aboutus.par2')</p>

    <div class="image-row d-flex flex-wrap justify-content-evenly gap-3">
        <img src="/img/umkm1.jpg" alt="UMKM 1">
        <img src="/img/umkm2.jpeg" alt="UMKM 2">
    </div>
</div>
@endsection