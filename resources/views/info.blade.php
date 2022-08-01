@extends('layouts.app')

@section('content')
<div class="container books">
    @if(session()->has('message'))
    @if (session()->get('message')=="Added to cart")
    <div class="alert alert-success text-center">
        {{ session()->get('message') }}
    </div>
    @else
    <div class="alert alert-danger text-center">
        {{ session()->get('message') }}
    </div>
    @endif
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
</div>


@endsection