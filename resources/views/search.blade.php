@extends('layouts.app')

@section('content')
<div class="container books">
    @if (count($books)>0)
    @foreach($books->chunk(6) as $chunk)
    <div class="row justify-content-center">
        @foreach ($chunk as $book)
        <div class="col-md-4 col-sm-4 col-xs-6 col-lg-2 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="row ">
                        <!--Book cover, sale banner, Title, Author, Rating, Stock-->
                        <div class="col-md-12 d-flex justify-content-center">
                            <a class="s-14" href="{{ route('info', ['isbn' => $book->ISBN]) }}">
                                <img class="cover" src="/images/books/{{$book->ISBN}}.jpg">
                            </a>
                        </div>
                        @if ($book->Sale>0)
                        <div class="box">
                            <span class="wdp-ribbon wdp-ribbon-six"><span class="wdp-ribbon-inner-wrap "><span class="wdp-ribbon-border"></span><span class="wdp-ribbon-text">{{$book->Sale}}% OFF</span></span>
                        </div>
                        @endif
                        <div class="col-md-12 h-100 mt-3">
                            <a class="s-14" href="{{ route('info', ['isbn' => $book->ISBN]) }}">
                                {{ $book->Title }}<br>
                            </a>
                            {{ $book->Author }}<br>
                            @php $rating = ($book->Rating/5)*100; @endphp
                            <div class="rating">
                                <div class="rating-upper" style="width: {{ $rating }}%">
                                    @for ($i=0; $i<5; $i++) <span>★</span>
                                        @endfor
                                </div>
                                <div class="rating-lower">
                                    @for ($i=0; $i<5; $i++) <span>★</span>
                                        @endfor
                                </div>
                            </div>
                            <br><br>
                            @if ($book->Sale>0)
                            <del>Tk. {{ $book->Price }}</del>
                            Tk. {{ round($book->Price-($book->Price*($book->Sale/100))) }}
                            @else
                            Tk. {{ $book->Price }}
                            @endif
                            <br>
                            @if ($book->Stock>0)
                            <span class="stock_1" style="color: var(--green)">In Stock</span>
                            @else
                            <span class="stock_0" style="color: var(--red)">Out Of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
    @else
    @if ($query=="")
    @php $query = "Null"; @endphp
    @endif
    <div class="card">
        <div class="card-body" style="font-size:16px">
            <div class="row text-center">
                <div class="col">
                    <i class="fa-solid fa-face-frown" style="font-size:24px; color:grey;"></i><br>
                    No records found matching<br>
                    @for ($i=0; $i<count($type); $i++)
                    {{$type[$i]}} = {{$query[$i]}}<br>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection