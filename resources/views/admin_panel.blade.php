<!--Template-->
@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row justify-content-center">
                <div class="row justify-content-center">
                    <div class="col">
                        <a href="{{ route('adminBooks')}}">
                            <div class="card">
                                <div class="card-header text-center">Edit Books</div>
                                <div class="card-body text-center">

                                    <img width="70px;" height="116px;" src="{{ url('storage/books/9791280035356.jpg') }}">
                                    <img width="70px;" height="116px;" src="{{ url('storage/books/9781655254314.jpg') }}">

                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="">
                            <div class="card h-100">
                                <div class="card-header text-center">View Requests</div>
                                <div class="card-body text-center">

                                   Hi

                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection