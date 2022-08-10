@extends('layouts.app')

@section('content')
    <div class="container w-100">
        <div class="row">
            {{-- @if (session('info'))
                <div class=" alert alert-info">
                    {{ session('info') }}
                </div>
            @endif --}}
            @include('layouts.alert')
            <div class=" @role('admin|Super-Admin') col-9 @else col-12 @endrole">
                @role('admin|Super-Admin')
                    {{-- SEARCH --}}
                    <form action="/orders/search" method="GET" class="mb-3">
                        {{-- @csrf --}}
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="အမည်ဖြင့်ရှာရန်" name="q"
                                style="border-right: 0;" required id="input"
                                @if (isset($name)) value="{{ $name }}" @endif />
                            {{-- <i class="fa-solid fa-xmark text-danger"></i> --}}
                            <b id="clear" class="fa-solid fa-xmark text-danger input-group-text bg-light"
                                style="border-left: 0; padding-top:10px; cursor: pointer;"></b>
                            <input class="input-group-text" type="submit" value="Search">
                        </div>
                    </form>
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
                <div class="row mt-5">
                    @foreach ($orders as $order)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mb-4">
                            <div class="card d-flex flex-fill"
                                @if ($order->pawn_id == 2) style="background-color: #d5d4d4bd;" @endif>
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
                                        ကျပ်သား
                                        <b>{{ floor(($order->weight % 128) / 8) }}</b>
                                        ပဲ
                                        <b>{{ ($order->weight % 128) % 8 }}</b>
                                        မူး
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
                                            <span class=" text-muted"> {{ $result }} @if(strlen($note) > 50) . . .  @endif</span>
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
                                                    echo $order->created_at->diffForHumans(); //date
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
                    {{ $orders->withQueryString()->links() }}
                </div>
            </div>
            @role('admin|Super-Admin')
                {{-- right --}}
                <div class="col-3">
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
                            <form action="/orders/filter" method="GET">
                                {{-- @csrf --}}
                                @if (isset($name))
                                    <input type="hidden" name="name" value="{{ $name }}">
                                @endif
                                <div class=" form-group mb-3">
                                    <label for="location">နေရပ် <span class=" text-danger">*</span></label>
                                    <select class="form-select form-control" name="location">
                                        <option value="0">နေရပ်ရွေးရန်</option>
                                        @foreach ($villages as $village)
                                            <option value="{{ $village->id }}"
                                                @if (isset($location)) @if ($location == $village->id)
                                                    selected @endif
                                                @endif>{{ $village->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class=" text-muted">--မဖြစ်မနေရွေးပေးရန်--</small>
                                </div>
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
                            </form>
                        </div>
                    </div>
                </div>
            @endrole
        </div>


    </div>
@endsection
