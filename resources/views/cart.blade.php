@extends('layouts.app')

@section('content')
<div class="container">
    @if(session()->has('message2'))
    <div class="alert alert-success text-center">
        {{ session()->get('message2') }}
    </div>
    @else
    @endif
    @if (count($books))

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">Cart</div>
                <div class="card-body">
                    <table class="table mt-3" style="font-size: 15px">
                        <thead>
                            <tr class="text-center">
                                <th scope="col"></th>
                                <th scope="col">Title</th>
                                <th scope="col">Cover</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $b)
                            <tr>
                                <form action="{{ route('remove4cart') }}" method="get">
                                    <input style="display:none;" type="text" name="isbn" value="{{$b->ISBN}}">
                                    <input style="display:none;" type="text" name="id" value="{{$b->ID}}">
                                    <td class="align-middle text-center">
                                        <button type="submit" class="btn btn-secondary btn-sm" style="width: 100px;">Delete 
                                            <svg width="14px" height="14px" style="fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">

                                                <path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z" />
                                            </svg>
                                        </button>
                                    </td>
                                </form>
                                @if ($b->Stock>0)
                                <td class="align-middle text-center" scope="row">
                                    <a href="{{ route('info', ['isbn' => $b->ISBN]) }}">{{$b->Title}}</a>
                                </td>
                                <td class="align-middle text-center"><a href="{{ route('info', ['isbn' => $b->ISBN]) }}"><img width="60" height="84" src="/images/books/{{$b->ISBN}}.jpg"></td></a>
                                <td class="align-middle text-center">Tk. {{$b->Price}}</td>
                                @else
                                <td class="align-middle text-center text-secondary" scope="row">
                                    <a href="{{ route('info', ['isbn' => $b->ISBN]) }}">{{$b->Title}}</a><br>
                                    <div style="color:red; font-size: 12px;">Out of stock</div>
                                </td>
                                <td class="align-middle text-center" style="opacity: 0.5"><a href="{{ route('info', ['isbn' => $b->ISBN]) }}"><img width="60" height="84" src="/images/books/{{$b->ISBN}}.jpg"></td></a>
                                <td class="align-middle text-center text-secondary"><del>Tk. {{$b->Price}}</del></td>
                                @endif
                            </tr>
                            @endforeach
                            <tr>
                                <td class="align-middle text-center"></td>
                                <td class="align-middle text-center">Charge</td>
                                <td class="align-middle text-center"></td>
                                <td class="align-middle text-center">Tk. {{$charge}}</td>
                            </tr>
                            <tr>
                                <td class="align-middle text-center"></td>
                                <td class="align-middle text-center">Delivery Charge</td>
                                <td class="align-middle text-center"></td>
                                <td class="align-middle text-center">Tk. {{$delivery}}</td>
                            </tr>
                            <tr>
                                <td class="align-middle text-center"></td>
                                <td class="align-middle text-center">Total Charge</td>
                                <td class="align-middle text-center"></td>
                                <td class="align-middle text-center">Tk. {{$total}}</td>
                            </tr>

                        </tbody>
                    </table>
                    <form class="text-center" action="{{ route('payment') }}" method="post">
                        @csrf
                        <input style="display:none;" type="text" name="charge" value="{{$charge}}">
                        <button type="submit" class="btn btn-sm" style="width: 200px; background-color: tomato; color: white;">Proceed to Payment</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-header">Cart</div>
        <div class="card-body" style="font-size:16px">
            <div class="row text-center">
                <div class="col">
                    <i class="fa-solid fa-face-surprise" style="font-size:24px; color:grey;"></i><br>
                    Cart is empty <br><br>
                    <button class="btn btn-secondary btn-sm" onclick="window.location='{{ url("bookarium") }}'">Browse more books</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <script>
        loadAgain('/user/cart')
    </script>
</div>
@endsection