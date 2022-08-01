@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
            @if(session()->has('settings-success'))
            <div class="alert alert-success text-center w-50 justify-content-center">
            {{ session()->get('settings-success') }}
            </div>
            @else 
            @if(session()->has('settings-error'))
            <div class="alert alert-danger text-center w-50 justify-content-center">
            {{ session()->get('settings-error') }}
            </div>
        @endif
        @endif
        
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header shadow-sm border-0 aqua-gradient">Settings</div>
                <div class="card-body">
                    <!--Set or edit Username, Email, Password, Address (House & road, Area) and Phone-->
                    <form action="{{ route('change_settings') }}" method="get">
                        <div class="row mb-3">
                            <div class="col-md-4 my-auto">
                                Username
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="uname" class="form-control" aria-describedby="basic-addon2" value="{{Auth::user()->name}}" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4  my-auto">
                                Email
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="mail" class="form-control" aria-describedby="basic-addon2" value="{{Auth::user()->email}}" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4  my-auto">
                                New Password
                            </div>
                            <div class="col-md-6">
                                <input type="password" name="newpass" class="form-control" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4  my-auto">
                                House and Street
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="house" class="form-control" autocomplete="off" value="{{Auth::user()->house}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4  my-auto">
                                Area
                            </div>
                            <div class="col-md-6">
                                <div class="wrapper">
                                    <!--creating list of area from array-->
                                    <select class="form-select" name="area">
                                        @php
                                        $areas = ['Uttara', 'Mirpur', 'Pallabi', 'Kazipara', 'Kafrul', 'Agargaon', 'Sher-e-Bangla Nagar', 'Cantonment area', 'Banani', 'Gulshan', 'Mohakhali', 'Bashundhara', 'Banasree', 'Baridhara', 'Uttarkhan', 'Dakshinkhan', 'Bawnia', 'Khilkhet', 'Tejgaon', 'Farmgate', 'Mohammadpur', 'Rampura', 'Badda', 'Satarkul', 'Beraid', 'Khilgaon', 'Vatara', 'Gabtali', 'Sadarghat', 'Hazaribagh', 'Dhanmondi', 'Ramna', 'Motijheel', 'Sabujbagh', 'Lalbagh', 'Kamalapur', 'Kamrangirchar', 'Islampur', 'Wari', 'Kotwali', 'Sutrapur', 'Jurain', 'Dania', 'Demra', 'Shyampur', 'Nimtoli', 'Matuail', 'Shahbagh', 'Paltan'];
                                        sort($areas);
                                        @endphp
                                        @foreach ($areas as $a)
                                        <option @if (Auth::user()->thana == $a) selected @endif value="{{$a}}">{{$a}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row mb-3">
                            <div class="col-md-4">
                                City
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="city" class="form-control" autocomplete="off" value="{{Auth::user()->city}}">
                            </div>
                        </div>-->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                Phone
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="phone" class="form-control" autocomplete="off" value="{{Auth::user()->phone}}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-8">
                                Enter your existing password to save changes
                                <div class="input-group input-group-sm">
                                    <input type="password" name="oldpass" class="form-control" required autofocus autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                                    <div class="input-group-append">
                                        <button class="btn btn-light" type="submit" style="width:80px !important;">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection