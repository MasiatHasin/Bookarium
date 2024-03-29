@extends('layouts.admin')

@section('content')
<div class="container">
    @if(session()->has('cred-update'))
    <div class="alert alert-danger text-center">
        {{ session()->get('cred-update') }}
    </div>
    @endif
    <form action="{{ route('search') }}" method="post" class="s-14">
        Search
        @csrf
        <div class="input-group input-group-sm">
            <input type="text" name="search" class="form-control" placeholder="Title or Author or ISBN" aria-describedby="basic-addon2" />
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit" style="width:80px !important;"><svg width="16px" height="16px" style="fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                        <path d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z" />
                    </svg></button>
            </div>
        </div>
    </form>


    <!--Advanced Search-->
    <form action="{{ route('discover') }}" method="post"><br>
        @csrf
        <details class="s-14">
            <summary style="cursor: pointer;">Advanced Search <svg width="16px" height="16px" style="margin-top: -10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                    <path d="M311.9 335.1l-132.4 136.8C174.1 477.3 167.1 480 160 480c-7.055 0-14.12-2.702-19.47-8.109l-132.4-136.8C-9.229 317.8 3.055 288 27.66 288h264.7C316.9 288 329.2 317.8 311.9 335.1z" />
                </svg></summary>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            Genre
                        </div>
                    </div>
                    <div class="row genre" style="padding-left: 10px;">
                        @foreach ($genre as $g)
                        <div onclick='checkbox("{{$g}}");' class="col-md-2 col-4 p-1" style="font-size: 14px;">
                            <span id="{{$g}}box" style="width: 16px !important; height: 16px !important; position: relative; top: 2px;  padding-left: 1px; padding-top: 1px; border:solid grey 1px; display: inline-block;">
                                <svg style="display: none;" id="{{$g}}plus" width="12px" height="12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z" />
                                </svg>
                                <svg style="display: none;" id="{{$g}}minus" width="12px" height="12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path d="M400 288h-352c-17.69 0-32-14.32-32-32.01s14.31-31.99 32-31.99h352c17.69 0 32 14.3 32 31.99S417.7 288 400 288z" />
                                </svg>
                            </span>
                            <input class="checkbox" id="{{$g}}" type="checkbox[]" value="" name="{{$g}}" style="display:none" />
                            <label>@php $G = ucfirst($g) @endphp {{$G}}</label>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-5">
                            Language<br>
                            @foreach ($lan as $l)
                            <span onclick='checkbox2("{{$l}}");' style="font-size: 14px;" width="50px !important;">
                                <span id="{{$l}}box" style="width: 16px !important; height: 16px !important; position: relative; top: 2px;  padding-left: 1px; padding-top: 1px; border:solid grey 1px; display: inline-block;">
                                    <svg style="display: none;" id="{{$l}}plus" width="12px" height="12px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M432 256c0 17.69-14.33 32.01-32 32.01H256v144c0 17.69-14.33 31.99-32 31.99s-32-14.3-32-31.99v-144H48c-17.67 0-32-14.32-32-32.01s14.33-31.99 32-31.99H192v-144c0-17.69 14.33-32.01 32-32.01s32 14.32 32 32.01v144h144C417.7 224 432 238.3 432 256z" />
                                    </svg>
                                </span>
                                <input class="checkbox" id="{{$l}}" type="checkbox[]" value="" name="{{$l}}" style="display:none" />
                                <label>@php $L = ucfirst($l) @endphp {{$L}}</label>
                            </span>
                            @endforeach

                        </div>

                        <div class="col-md-2 col-3">
                            Rating<br>
                            <div class="rating2">
                                <div id="rating-advanced" class="rating-upper" style="width: 0%; font-size: 20px;">
                                    @for ($i=1; $i<6; $i++) <input onclick="rate('{{$i}}');" style="display:none;" class="checkbox" id="star{{$i}}" type="radio" name="rating" value="{{$i}}">
                                        <label for="star{{$i}}">★</label>
                                        @endfor
                                </div>
                                <div class="rating-lower" style="font-size: 20px;">
                                    @for ($i=1; $i<6; $i++) <input style="display:none;" class="checkbox" id="star{{$i}}" type="radio" name="rating" value="{{$i}}">
                                        <label for="star{{$i}}">★</label>
                                        @endfor
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-3">
                            Year
                            <ul class="list-group list-group-horizontal position-relative overflow-auto w-75" style="cursor: pointer;">
                                @for ($i=1800; $i<=2022; $i+=10) <li class="list-group-item" onclick='selectYear("{{$i}}");' id="year{{$i}}">{{$i}}s</li>
                                    @endfor
                                    <input style="display:none;" id="year" type="button" value="" name="year" style="display:none" />
                            </ul>
                        </div>

                        <div class="col-md-4 col-12">
                            Sort
                            <div class="p-1">
                                <input class="checkbox" id="rating" type="radio" name="sort" value="Rating" />
                                <label for="rating">Rating</label>

                                <input class="checkbox" id="popularity" type="radio" name="sort" value="Popularity" />
                                <label for="popularity">Popularity</label>
                            </div>
                        </div>

                        <div class="col-md-12 col-12 mt-3">
                            <div class="p-1 ">
                                <button class="btn btn-primary btn-sm " type="submit" style="width:100% !important; height: 100% !important;">
                                    <svg width="16px" height="16px" style="fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.1.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path d="M500.3 443.7l-119.7-119.7c27.22-40.41 40.65-90.9 33.46-144.7C401.8 87.79 326.8 13.32 235.2 1.723C99.01-15.51-15.51 99.01 1.724 235.2c11.6 91.64 86.08 166.7 177.6 178.9c53.8 7.189 104.3-6.236 144.7-33.46l119.7 119.7c15.62 15.62 40.95 15.62 56.57 0C515.9 484.7 515.9 459.3 500.3 443.7zM79.1 208c0-70.58 57.42-128 128-128s128 57.42 128 128c0 70.58-57.42 128-128 128S79.1 278.6 79.1 208z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        </details>
    </form>



    <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
            <div class="row p-2">
                @foreach ($books as $book)
                <!--Book cover, sale banner, Title, Author, Rating, Stock-->
                <span class="col-md-6 col-sm-12 col-xs-12 col-lg-6 mb-4">
                    <a class="s-14" href="{{ route('adminBookInfo', ['isbn' => $book->ISBN]) }}">
                        <img class="cover3" src="{{ url('storage/books/'.$book->ISBN.'.jpg') }}">


                        @if ($book->Sale>0)
                        @endif
                        {{ $book->Title }}
                        -


                        {{ $book->Author }}
                    </a>
                </span>

                @endforeach
            </div>
        </div>
    </div>


</div>
@endsection