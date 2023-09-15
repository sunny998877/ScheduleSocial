@extends('layouts.app')

@section('content')

@php
    $title = "Credential";
    $breadcrumbs = [
        'First' => ['url' => '/first'],
    ];
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <Credentials></Credentials>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
