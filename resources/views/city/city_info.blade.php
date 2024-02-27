@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">City Information</div>

                    <div class="card-body">
                        <p>City Name: {{ $cityInfo['name'] }}</p>
                        <p>Population: {{ $cityInfo['population'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
