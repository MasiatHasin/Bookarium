@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verification</div>

                <div class="card-body">
                    <form action="{{ route('verification') }}" method="post">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Code</label>

                            <div class="col-md-6">
                                <input id="code" type="code" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset') }}
                                </button>
                            </div>
                        </div>
                        <input id="email" type="email" name="email" value="{{$email1}}" style="display:none;"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection