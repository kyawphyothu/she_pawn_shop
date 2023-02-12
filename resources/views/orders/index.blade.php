@extends('layouts.app')

@section('content')
    <style>
        @import url(https://fonts.googleapis.com/css?family=Lato:700);

        /* body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #f0f0f0;
        } */
        .box {
            position: relative;
            /* max-width: 600px;
        width: 90%;
        height: 400px;
        background: #fff;
        box-shadow: 0 0 15px rgba(0,0,0,.1); */
        }

        /* common */
        .ribbon {
            width: 150px;
            height: 150px;
            overflow: hidden;
            position: absolute;
        }

        .ribbon::before,
        .ribbon::after {
            position: absolute;
            z-index: -1;
            content: '';
            display: block;
            border: 5px solid #b92929;
        }

        .ribbon span {
            position: absolute;
            display: block;
            width: 225px;
            padding: 15px 0;
            background-color: #db3434;
            box-shadow: 0 5px 10px rgba(0, 0, 0, .1);
            color: #fff;
            font: 700 18px/1 'Lato', sans-serif;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            text-transform: uppercase;
            text-align: center;
            opacity: 0.8;
        }

        /* top left*/
        .ribbon-top-left {
            top: -10px;
            left: -10px;
        }

        .ribbon-top-left::before,
        .ribbon-top-left::after {
            border-top-color: transparent;
            border-left-color: transparent;
        }

        .ribbon-top-left::before {
            top: 0;
            right: 0;
        }

        .ribbon-top-left::after {
            bottom: 0;
            left: 0;
        }

        .ribbon-top-left span {
            right: -25px;
            top: 30px;
            transform: rotate(-45deg);
        }

        /* top right*/
        .ribbon-top-right {
            top: -10px;
            right: -10px;
        }

        .ribbon-top-right::before,
        .ribbon-top-right::after {
            border-top-color: transparent;
            border-right-color: transparent;
        }

        .ribbon-top-right::before {
            top: 0;
            left: 0;
        }

        .ribbon-top-right::after {
            bottom: 0;
            right: 0;
        }

        .ribbon-top-right span {
            left: -25px;
            top: 30px;
            transform: rotate(45deg);
        }

        /* bottom left*/
        .ribbon-bottom-left {
            bottom: -10px;
            left: -10px;
        }

        .ribbon-bottom-left::before,
        .ribbon-bottom-left::after {
            border-bottom-color: transparent;
            border-left-color: transparent;
        }

        .ribbon-bottom-left::before {
            bottom: 0;
            right: 0;
        }

        .ribbon-bottom-left::after {
            top: 0;
            left: 0;
        }

        .ribbon-bottom-left span {
            right: -25px;
            bottom: 30px;
            transform: rotate(225deg);
        }

        /* bottom right*/
        .ribbon-bottom-right {
            bottom: -10px;
            right: -10px;
        }

        .ribbon-bottom-right::before,
        .ribbon-bottom-right::after {
            border-bottom-color: transparent;
            border-right-color: transparent;
        }

        .ribbon-bottom-right::before {
            bottom: 0;
            left: 0;
        }

        .ribbon-bottom-right::after {
            top: 0;
            right: 0;
        }

        .ribbon-bottom-right span {
            left: -25px;
            bottom: 30px;
            transform: rotate(-225deg);
        }
        .small-screen{
            display: none;
        }
        .mobile-view{
            display: none;
        }
        .add_order_mobile_view{
            display: none;
        }
        @media(max-width: 1000px) {
            .right {
                display: none;
            }

            .left {
                width: 100%;
            }
            .small-screen{
                display: flex;
            }
            .mobile-view{
                display: flex;
            }
            .add_order_mobile_view{
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                /* background: red; */
                position: fixed;
                bottom: 15px;
                right: 15px;
                box-shadow: 5px 3px 5px #888888;
            }
        }
    </style>
    <form action="/orders/filter" method="GET">
        <div class="container w-100">
            <div class="row" >
                {{-- @if (session('info'))
                    <div class=" alert alert-info">
                        {{ session('info') }}
                    </div>
                @endif --}}
                @if (session('info'))
                    <div class=" alert alert-success user-select-none">
                        {{ session('info') }}
                        <i class="fa-solid fa-xmark float-end text-danger close-btn"
                            onclick="this.parentElement.style.display = 'none';"></i>
                    </div>
                @endif
                {{-- @include('layouts.alert') --}}
                <div class=" @role('admin|Super-Admin') col-9 @else col-12 @endrole left">
                    @if (request()->is('orders/filter*'))
                        <small class=" text-muted" style="font-size: 11.5px">
                            --search mode မှထွက်၍ မူလစာမျက်နှာသို့ရောက်လိုလျှင် သျှီအပေါင်ဆိုင် ဆိုသည့်စာသားအားနှိပ်ပါ။--
                        </small>
                    @endif
                    @role('admin|Super-Admin')
                        {{-- SEARCH --}}
                        {{-- <form action="/orders/search" method="GET" class="mb-3"> --}}
                        {{-- @csrf --}}
                        <div class="input-group mt-2">
                            <input type="search" class="form-control" placeholder="အမည်ဖြင့်ရှာရန်" name="name"
                                style="border-right: 0;" id="input"
                                @if (isset($name)) value="{{ $name }}" @endif />
                            {{-- <i class="fa-solid fa-xmark text-danger"></i> --}}
                            <b id="clear" class="fa-solid fa-xmark text-danger input-group-text bg-light"
                                style="border-left: 0; padding-top:10px; cursor: pointer;"></b>
                            <input class="input-group-text" type="submit" value="Search">
                        </div>
                        <div class="card mt-1 mobile-view">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class=" form-group mb-3 mt-2">
                                            <label for="location" style="font-size: 12px;">နေရပ် ဖြင့်စစ်ထုတ်ရန်</label>
                                            <select class="form-select form-select-sm" id="mobile-view-location-filter" name="">
                                                <option value="0">All Villages</option>
                                                @foreach ($villages as $village)
                                                    <option value="{{ $village->id }}"
                                                        @if (isset($location)) @if ($location == $village->id)
                                                            selected @endif
                                                        @endif>{{ $village->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex justify-content-center align-items-center" >
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-info">Village Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- </form> --}}
                    @endrole
                    {{-- nav --}}
                    {{-- <ul class=" nav nav-pills justify-content-center mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">အားလုံး</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">မရွေးရသေးသော ပစ္စည်းများ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ရွေးပြီးသား ပစ္စည်းများ</a>
                    </li>
                    </ul> --}}
                    {{-- contents --}}
                    <div class=" d-flex justify-content-around mt-4">
                        {{-- <input type="text" value="@if (isset($SearchAllOrNot)) {{ $SearchAllOrNot }} @endif" hidden
                            name="allOrNot"> --}}
                        <input type="submit" value="အားလုံး" name="allOrNot"
                            class=" btn @if ((isset($SearchAllOrNot) && $SearchAllOrNot == 'အားလုံး') || !isset($SearchAllOrNot)) btn-primary @else btn-outline-primary @endif">
                        <input type="submit" value="မရွေးရသေး" name="allOrNot"
                            class=" btn @if (isset($SearchAllOrNot) && $SearchAllOrNot == 'မရွေးရသေး') btn-success @else btn-outline-success @endif">
                        <input type="submit" value="ရွေးပြီး" name="allOrNot"
                            class=" btn @if (isset($SearchAllOrNot) && $SearchAllOrNot == 'ရွေးပြီး') btn-danger @else btn-outline-danger @endif">
                        {{-- <button type="submit" class="link-dark">all</button> --}}
                        {{-- <div type="submit" class=" link-dark">all</div> --}}
                        {{-- <a href="#" class=" link-info">မရွေးရသေး</a>
                    <a href="#" class=" link-danger">ရွေးပြီး</a> --}}
                    </div>
                    <div class="row mt-3">
                        @if ($orders[0] == null)
                            <div class=" text-danger">
                                <h1>
                                    ရှာဖွေနေသော ရလဒ်မရှိပါ
                                </h1>
                            </div>
                        @endif
                        @foreach ($orders as $order)
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mb-4">
                                <div class="card d-flex flex-fill box"
                                    @if ($order->pawn_id == 2) style="background-color: #d5d4d4bd;" @endif>
                                    @if ($order->pawn_id == 2)
                                        <div class="ribbon ribbon-top-right"><span style="user-select: none">ရွေးပြီး</span>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <div class=" card-title h5">
                                            <span class=" text-primary">{{ $order->name }}</span> {{-- //name --}}
                                            (<sapn class=" text-muted">
                                                {{ $order->village->name }} {{-- //village_name --}}
                                            </sapn>)
                                        </div>
                                        <div class=" card-subtitle text-muted">
                                            @foreach ($order->orderCategories as $orderCategory)
                                                {{ $orderCategory->category->name }}| {{-- //category --}}
                                            @endforeach
                                        </div>
                                        <div class=" text-muted">
                                            <b>{{ floor($order->weight / 128) }}</b> {{-- အလေးချိန် --}}
                                            ကျပ်သား &nbsp;
                                            <b>{{ floor(($order->weight % 128) / 8) }}</b>
                                            ပဲ &nbsp;
                                            <b>{{ ($order->weight % 128) % 8 }}</b>
                                            မူး &nbsp;
                                        </div>
                                        <div class=" text-success">
                                            <b>
                                                @php
                                                    $totalPrice = 0;
                                                    foreach ($order->htetYus as $htetYu) {
                                                        $totalPrice += $htetYu->price;
                                                    }
                                                    echo number_format($totalPrice); //ယူငွေ
                                                @endphp
                                            </b>ကျပ်
                                        </div>
                                        <div class=" card-text">
                                            @if ($order->note && $order->note != 'မှတ်ချက်မရှိသေးပါ')
                                                @php
                                                    $note = $order->note;
                                                    $result = Str::substr($note, 0, 50);
                                                @endphp
                                                <span class=" text-muted"> {{ $result }} @if (strlen($note) > 50)
                                                        . . .
                                                    @endif
                                                </span>
                                            @else
                                                <span class=" text-muted">မှတ်ချက်မရှိသေးပါ</span> {{-- note --}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class=" d-flex justify-content-between">
                                            <small class=" text-muted mt-2">
                                                {{-- {{ $order->created_at->diffForHumans() }} --}}
                                                @php
                                                    $time = $order->created_at;
                                                    $timeOut = $time->modify('+6 days')->format('Y-m-d H:i:s');
                                                    $now = date('Y-m-d H:i:s');
                                                    if ($now >= $timeOut) {
                                                        echo $order->created_at;
                                                    } else {
                                                        $dayAndHour = date('D H:m', strtotime($order->created_at));
                                                        echo $order->created_at->diffForHumans(); //date
                                                        echo " ($dayAndHour)";
                                                    }
                                                @endphp
                                            </small>
                                            <small class=" mt-2 text-primary">{{ $order->owner->name }}</small>
                                            <a href="/orders/detail/{{ $order->id }}" class="btn btn-success">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $orders->withQueryString()->links('vendor.pagination.custom') }}
                    </div>
                    {{-- add new for mobile view --}}
                    <a href="/orders/add" class="add_order_mobile_view btn btn-primary">
                        {{-- <i class="fa-solid fa-file-circle-plus" style="font-size: 30px"></i> --}}
                        <i class="fa-solid fa-plus" style="font-size: 25px"></i>
                    </a>
                </div>
                @role('admin|Super-Admin')
                    {{-- right --}}
                    <div class="col-3 right">
                        {{-- add new --}}
                        <a href="/orders/add" class=" btn btn-success btn-lg mb-2 w-100">အပေါင်ခံမည်</a>
                        {{-- rate and change rate --}}
                        <div class="mb-2">
                            အောက်<span class="text-success"> {{ $rate4L }}</span>ကျပ်|
                            အထက်<span class="text-success"> {{ $rate4G }}</span>ကျပ်|
                            <span class="">
                                <a href="/rates/update" class=" float-right btn btn-primary">Change Rate</a>
                            </span>
                        </div>
                        {{-- filter --}}
                        <div class="card">
                            <div class="card-header">
                                <div class=" h4 text-primary">
                                    ရွေးထုတ်ရန်
                                </div>
                            </div>
                            <div class=" card-body">
                                {{-- @csrf --}}
                                {{-- @if (isset($name))
                                    <input type="hidden" name="name" value="{{ $name }}">
                                @endif --}}
                                <div class=" form-group mb-3">
                                    <label for="location">နေရပ် <span class=" text-danger">*</span></label>
                                    <select class="form-select form-control" name="location" id="location">
                                        <option value="0">All Villages</option>
                                        @foreach ($villages as $village)
                                            <option value="{{ $village->id }}"
                                                @if (isset($location)) @if ($location == $village->id)
                                                    selected @endif
                                                @endif>{{ $village->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="form-group mb-3">
                                    <label for="">ယူငွေ</label>
                                    <div class="row">
                                        <div class=" col-6">
                                            <input type="number" class=" form-control" placeholder="From">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" class="form-control" placeholder="To">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group mb-3">
                                    <label for="">ပစ္စည်း အမျိုးအစား</label>
                                    @foreach ($categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="{{ $category->id }}"
                                                name="category_id[]" value="{{ $category->id }}"
                                                @if (isset($category_id_arr)) @if (in_array($category->id, $category_id_arr))
                                                        checked @endif
                                                @endif>
                                            <label class="form-check-label"
                                                for="{{ $category->id }}">{{ $category->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- <div class=" form-group mb-3">
                                    <label for="">ယူငွေ</label>
                                    <div class="input-group">
                                        <input type="number" name="price" class=" form-control" min="1000">
                                        <span class=" input-group-text">ကျပ်</span>
                                    </div>
                                </div> --}}
                                <input type="submit" class=" btn btn-info" style="float: right;" value="Apply">
                            </div>
                        </div>
                    </div>
                @endrole
            </div>
            <div class="some_space" style="height: 30px"></div>
        </div>
    </form>

@endsection

@section('script')
    <script>
        let mvlf = document.querySelector('#mobile-view-location-filter');
        let locationId = document.querySelector('#location');
        mvlf.addEventListener('change', function(){
            locationId.value = mvlf.value;
        })
    </script>
@endsection
