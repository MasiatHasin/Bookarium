@extends('layouts.app')

@section('content')
<div class="container books">
    @if(session()->has('add-success'))
    <div class="alert alert-success text-center">
        {{ session()->get('add-success') }}
    </div>
    @endif
    @if(session()->has('no-location'))
    <div class="alert alert-danger text-center">
        {{ session()->get('no-location') }}
    </div>
    @endif
    @if(session()->has('insufficient-stock'))
    <div class="alert alert-danger text-center">
        {{ session()->get('insufficient-stock') }}
    </div>
    @endif
    @if(session()->has('no-stock'))
    <div class="alert alert-success text-center">
        {{ session()->get('no-stock') }}
    </div>
    @endif
    @if(session()->has('review-success'))
    <div class="alert alert-success text-center">
        {{ session()->get('review-success') }}
    </div>
    @endif
    @if(session()->has('review-failure'))
    <div class="alert alert-danger text-center">
        {{ session()->get('review-failure') }}
    </div>
    @endif
    @if(session()->has('review-deleted'))
    <div class="alert alert-success text-center">
        {{ session()->get('review-deleted') }}
    </div>
    @endif
    @foreach ($books as $book)
    <div class="card">
        <div class="card-header">
            Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card ">
                        <div class="card-body">
                            <div class="row-md">
                                <div class="col-md text-center center-block">
                                    <img class="cover2" src="/images/books/{{$book->ISBN}}.jpg"><br>
                                </div>
                                @if ($book->Sale>0)
                                <div class="box">
                                    <span class="wdp-ribbon wdp-ribbon-six"><span class="wdp-ribbon-inner-wrap"><span class="wdp-ribbon-border"></span><span class="wdp-ribbon-text">{{$book->Sale}}% OFF</span></span>
                                </div>

                                @endif
                                <div class="col-md mt-3 info">

                                    <div class="row ">
                                        <div class="col text-center">

                                            @if ($book->Sale>0)
                                            <!--<span style="font-color:tomato; color:red;">{{$book->Sale}}% OFF</span><br>-->
                                            <div style="font-size: 16px;"><del class="text-secondary">Tk. {{ $book->Price }}</del>
                                                @php $newval = round($book->Price-($book->Price*($book->Sale/100))); @endphp
                                                <span style="color:tomato;">Tk. {{ $newval  }}</span>
                                            </div>
                                            You save Tk. {{$book->Price-$newval}}
                                            @else
                                            <div style="font-size: 16px;">Tk. {{ $book->Price }}</div>

                                            @endif

                                            <div style="font-size: 14px;">
                                                <form action="{{ route('add2cart')}}" method="post">
                                                    @csrf
                                                    <input style="display:none;" type="text" name="isbn" value="{{$book->ISBN}}">
                                                    <input style="display:none;" type="text" name="title" value="{{$book->Title}}">
                                                    <input style="display:none;" type="text" name="price" value="{{$book->Price}}">
                                                    Amount: <input style="width:50px !important" type="number" id="rating" name="amount" min="1" value="1"><br>
                                                    <button type="submit" class="btn btn-secondary  mt-1 purchase" name="button" value="cart">Cart
                                                        <svg width="14px" height="14px" style="fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                            <path d="M96 0C107.5 0 117.4 8.19 119.6 19.51L121.1 32H541.8C562.1 32 578.3 52.25 572.6 72.66L518.6 264.7C514.7 278.5 502.1 288 487.8 288H170.7L179.9 336H488C501.3 336 512 346.7 512 360C512 373.3 501.3 384 488 384H159.1C148.5 384 138.6 375.8 136.4 364.5L76.14 48H24C10.75 48 0 37.25 0 24C0 10.75 10.75 0 24 0H96zM128 464C128 437.5 149.5 416 176 416C202.5 416 224 437.5 224 464C224 490.5 202.5 512 176 512C149.5 512 128 490.5 128 464zM512 464C512 490.5 490.5 512 464 512C437.5 512 416 490.5 416 464C416 437.5 437.5 416 464 416C490.5 416 512 437.5 512 464z" />
                                                        </svg></button>
                                                    <br>
                                                    <button type="submit" class="btn btn-secondary  mt-1 purchase" name="button" value="wishlist">Wishlist
                                                        <svg width="14px" height="14px" style="fill: white;" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                            <path d="M0 190.9V185.1C0 115.2 50.52 55.58 119.4 44.1C164.1 36.51 211.4 51.37 244 84.02L256 96L267.1 84.02C300.6 51.37 347 36.51 392.6 44.1C461.5 55.58 512 115.2 512 185.1V190.9C512 232.4 494.8 272.1 464.4 300.4L283.7 469.1C276.2 476.1 266.3 480 256 480C245.7 480 235.8 476.1 228.3 469.1L47.59 300.4C17.23 272.1 .0003 232.4 .0003 190.9L0 190.9z" />
                                                        </svg></button>
                                                </form>
                                            </div>

                                            @if ($book->Stock>0)
                                            <div class="mt-1" style="color: green">{{$book->Stock}} copies in Stock</div>
                                            @else
                                            <div class="mt-1" style="color: red">Out Of Stock</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md justify-content-center align-center" style="text-align: left; font-size: 14px">
                    <span href="" style="font-size: 18px">
                        {{ $book->Title }}<br>
                    </span>
                    <span href="" style="font-size: 14px">
                        {{ $book->Author }}<br>
                    </span>
                    <br>
                    @php $rating = ($book->Rating/5)*100; @endphp
                    <div class="rating" style="font-size:18px;">
                        <div class="rating-upper" style="width: {{ $rating }}%">
                            @for ($i=0; $i<5; $i++) <span>★</span>
                                @endfor
                        </div>
                        <div class="rating-lower">
                            @for ($i=0; $i<5; $i++) <span>★</span>
                                @endfor
                        </div>
                    </div> {{ $book->Rating }} | {{ $book->Popularity }} Purchases<br><br>
                    {{ $book->Synopsis }}
                    <hr>
                    Additional Information<br>
                    <div style="font-size: 12px;">ISBN: {{$book->ISBN}}<br>
                        Year: {{$book->Year}}<br>
                        Language: {{$book->Language}}<br>
                        Genre: {{$book->Genre}}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="card mt-3">
        <div class="card-header">
            Similar
        </div>
        <div class="card-body">
            <div class="row">
                <div class="md">
                    @if (count($similar)>1)
                    @foreach ($similar as $s)
                    <a href="{{ route('info', ['isbn' => $s]) }}">
                        <img width="70px;" height="116px;" src="/images/books/{{$s}}.jpg">
                    </a>
                    @endforeach
                    @else
                    No similar books found in Database
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">
            Reviews
        </div>
        <div class="card-body">
            @php
            $reviewers = $review->pluck('Email')->toArray();
            @endphp
            @if (Auth::check() && in_array(Auth::user()->email, $reviewers)==False && $delivered == 1)
            <form action="{{ route('postReview', ['isbn' => $book->ISBN])}}" method="post">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card text-center">
                            <div class="card-body">
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
                                <div class="row">

                                    <div class="col">
                                        <textarea style="resize:none;" rows="2" name="review" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col text-center">
                                        <button class="btn btn-primary btn-sm" type="submit">Post Review</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @endif
            @if ($review != null)
            <div class="row mt-3">
                @if (count($review) > 0)
                @php $halved = $review->chunk(ceil(count($review)/2)); @endphp
                @for ($k=0; $k<count($halved); $k++) <div class="col-md-6">
                    @foreach ($halved[$k] as $r)
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row h-100">
                                <div class="col" style="font-size: 16px;">
                                    {{$r->Name}}
                                        @php $rating = ($r->Rating/5)*100; @endphp
                                        <div class="rating" style="font-size:18px;" id="ratingorg{{$r->ISBN}}{{$r->Email}}">
                                            <div class="rating-upper" style="width: {{ $rating }}%">
                                                ★★★★★


                                            </div>
                                            <div class="rating-lower">
                                                ★★★★★
                                            </div>
                                        </div>
                                        @if (Auth::check() && $r->Email == Auth::user()->email)
                                        <span width="200px !important;">
                                            <button id="edit" class="btn btn-sm btn-primary" style="width:30px;" onclick="editReview('{{$r->ISBN}}{{$r->Email}}');">
                                                <!--Edit-->
                                                <svg width="10px" height="10px" style="fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                    <path d="M490.3 40.4C512.2 62.27 512.2 97.73 490.3 119.6L460.3 149.7L362.3 51.72L392.4 21.66C414.3-.2135 449.7-.2135 471.6 21.66L490.3 40.4zM172.4 241.7L339.7 74.34L437.7 172.3L270.3 339.6C264.2 345.8 256.7 350.4 248.4 353.2L159.6 382.8C150.1 385.6 141.5 383.4 135 376.1C128.6 370.5 126.4 361 129.2 352.4L158.8 263.6C161.6 255.3 166.2 247.8 172.4 241.7V241.7zM192 63.1C209.7 63.1 224 78.33 224 95.1C224 113.7 209.7 127.1 192 127.1H96C78.33 127.1 64 142.3 64 159.1V416C64 433.7 78.33 448 96 448H352C369.7 448 384 433.7 384 416V319.1C384 302.3 398.3 287.1 416 287.1C433.7 287.1 448 302.3 448 319.1V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V159.1C0 106.1 42.98 63.1 96 63.1H192z" />
                                                </svg>
                                            </button>
                                            <form class="form1" action="{{ route('deleteReview', ['isbn' => $r->ISBN]) }}" method="post">
                                                @csrf
                                                <button id="edit" class="btn btn-sm btn-primary" style="width:30px;" type="submit">
                                                    <!--Delete-->
                                                    <svg width="10px" height="10px" style="fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path d="M490.3 40.4C512.2 62.27 512.2 97.73 490.3 119.6L460.3 149.7L362.3 51.72L392.4 21.66C414.3-.2135 449.7-.2135 471.6 21.66L490.3 40.4zM172.4 241.7L339.7 74.34L437.7 172.3L270.3 339.6C264.2 345.8 256.7 350.4 248.4 353.2L159.6 382.8C150.1 385.6 141.5 383.4 135 376.1C128.6 370.5 126.4 361 129.2 352.4L158.8 263.6C161.6 255.3 166.2 247.8 172.4 241.7V241.7zM192 63.1C209.7 63.1 224 78.33 224 95.1C224 113.7 209.7 127.1 192 127.1H96C78.33 127.1 64 142.3 64 159.1V416C64 433.7 78.33 448 96 448H352C369.7 448 384 433.7 384 416V319.1C384 302.3 398.3 287.1 416 287.1C433.7 287.1 448 302.3 448 319.1V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V159.1C0 106.1 42.98 63.1 96 63.1H192z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </span>
                                        @endif
                                    

                                    <hr>
                                    <form id="theForm{{$r->ISBN}}{{$r->Email}}" action="{{ route('editReview', ['isbn' => $book->ISBN])}}" method="post">
                                        @csrf
                                        <div id="review{{$r->ISBN}}{{$r->Email}}" style="font-size: 14px;">
                                            {{$r->Review}}
                                        </div>
                                        <input id="rating{{$r->ISBN}}{{$r->Email}}" style="display:none;" type="text" name="rating{{$r->ISBN}}{{$r->Email}}" />
                                        <input id="input{{$r->ISBN}}{{$r->Email}}" style="display:none;" type="text" name="input{{$r->ISBN}}{{$r->Email}}" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </div>
            @endfor
            @endif

        </div>
        @else
        No reviews have been posted yet
        @endif
    </div>

    @endsection