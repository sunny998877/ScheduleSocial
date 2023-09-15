@extends('layouts.app')

@section('content')

    @php
        $title = "Scheduler";
        $breadcrumbs = [
            'First' => ['url' => '/first'],
            'Second' => ['url' => '/second'],
            'Third' => ['url' => '/third']
        ];
    @endphp

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <Scheduler></Scheduler>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
