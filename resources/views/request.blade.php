@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    @if(session()->has('request-success'))
            <div class="alert alert-success text-center w-50 justify-content-center">
            {{ session()->get('request-success') }}
            </div>
        @endif

        <div class="col-md-8">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header shadow-sm border-0">Request Book</div>
                <div class="card-body">
                    <form action="{{ route('sendrequest') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-2">
                                Book Title
                            </div>
                            <div class="col">
                                <input required type="text" name="title" @if ($access=="no") readonly @endif class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                Language
                            </div>
                            <div class="col">
                                <input required type="text" name="language" @if ($access=="no") readonly @endif class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                Additional Information
                            </div>
                            <div class="col">
                                <textarea style="resize:none;"rows="4" name="extra" @if ($access=="no") readonly @endif class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                            @if ($access=="yes") 
                                Note: You can only post one request per week.
                            @else
                            @php $probDate = date("d.m.Y", strtotime($probDate)); @endphp
                                You're already posted a request this week. Please wait till <span style="color:red;"> {{$probDate}}</span> to make a new request.
                            @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col text-center">
                                <button class="btn btn-primary btn-sm" @if ($access=="no") disabled @endif type="submit">Post Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection