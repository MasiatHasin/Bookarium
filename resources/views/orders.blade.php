@extends('layouts.app')

@section('content')
<div class="container">
    <!--Show current orders: Covers, Price, Date of order, status, estimated date of delivery-->
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow-sm border-0">
                <div class="card-header shadow-sm border-0">Current Orders</div>
                <div class="card-body">
                    <table class="table mt-3">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Book</th>
                                <th scope="col">Price</th>
                                <th scope="col">Date Ordered</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">ETA Delivery Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($new_orders as $no)
                            <tr>
                                <td class="align-middle text-center" scope="row">
                                    @foreach ($new_books[0] as $nb)
                                    <a class="title" href="{{ route('info', ['isbn' => $nb]) }}">
                                        <img width="50px" height="74px" src="/images/books/{{$nb}}.jpg">
                                    </a>
                                    @endforeach
                                    @php array_shift($new_books) @endphp

                                </td>
                                <td class="align-middle text-center">Tk. {{$no->Price}}</td>
                                @php
                                $ndo = date("M jS, Y", strtotime($no->Date_Ordered));
                                $ndd = date("M jS, Y", strtotime($no->Probable_Date_Delivery));
                                @endphp
                                <td class="align-middle text-center">{{$ndo}}</td>
                                <td class="align-middle text-center">{{$no->Status}}</td>
                                <td class="align-middle text-center">{{$ndd}}</td>
                            </tr>

                        </tbody>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--Show past orders: Covers, Price, Date of order and delivery -->
    <div class="row justify-content-center">
        <div class="col">
            <div class="card mt-5 shadow-sm mb-4 border-0">
                <div class="card-header shadow-sm mb-4 border-0">Past orders</div>
                <div class="card-body">
                    <table class="table mt-3">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Book</th>
                                <th scope="col">Price</th>
                                <th scope="col">Date Ordered</th>
                                <th scope="col">Date Delivered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($past_orders as $po)
                            <tr>
                                <td class="align-middle text-center" scope="row">
                                    @foreach ($past_books[0] as $pb)
                                    <a class="title" href="{{ route('info', ['isbn' => $pb]) }}">
                                        <img width="50px" height="74px" src="/images/books/{{$pb}}.jpg">
                                    </a>
                                    @endforeach
                                    @php array_shift($past_books) @endphp

                                </td>
                                <td class="align-middle text-center">Tk. {{$po->Price}}</td>
                                @php
                                $pdo = date("M jS, Y", strtotime($po->Date_Ordered));
                                $pdd = date("M jS, Y", strtotime($po->Probable_Date_Delivery));
                                @endphp
                                <td class="align-middle text-center">{{$pdo}}</td>
                                <td class="align-middle text-center">{{$pdd}}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection