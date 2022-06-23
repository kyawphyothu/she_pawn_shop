@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- detail card --}}
        <div class=" row">
            <div class="col-12 col-sm-12 col-md-12 d-flex align-items-stretch flex-column mb-4">
                <div class="card d-flex flex-fill mb-3">
                    <div class="card-body">
                        <div class=" card-title h5">
                            <span class=" text-primary">{{ $order->name }}</span>
                            (<sapn class=" text-muted">
                                {{ $order->village->name }}
                            </sapn>)
                        </div>
                        <div class=" card-subtitle text-muted">
                            @foreach ($order->orderCategories as $orderCategory)
                                {{ $orderCategory->category->name }}|
                            @endforeach
                        </div>
                        <div class=" text-muted">
                            <b>{{ floor($order->weight / 128) }}</b>
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
                                    echo number_format($totalPrice);
                                @endphp
                            </b>ကျပ်
                        </div>
                        <small class=" text-muted">
                            @php
                                $time = $order->updated_at;
                                $timeOut = $time->modify('+6 days')->format('Y-m-d H:i:s');
                                $now = date('Y-m-d H:i:s');
                                if ($now >= $timeOut) {
                                    echo $order->updated_at;
                                } else {
                                    echo $order->updated_at->diffForHumans();
                                }
                            @endphp
                        </small>
                        <a href="/orders/edit/{{ $order->id }}" class="btn btn-outline-primary float-end">Edit</a>
                    </div>
                    <div class="card-footer">
                        @if ($order->note)
                            @php
                                $note = $order->note;
                                $result = Str::substr($note, 0, 50);
                            @endphp
                            <span class=" text-muted"> {{ $result }} . . .</span>
                        @else
                            <span class=" text-muted">No Note</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- htet_yus and pay interest --}}
        <div class="row">
            {{-- HTET YUS --}}
            <div class="col-12 col-sm-4 col-md-4 d-flex align-items-stretch flex-column mb-4">
                <h4 class="">ငွေယူသော မှတ်တမ်းများ</h4>
                <div class="card d-flex flex-fill mb-3">
                    <div class="card-body">
                        @foreach ($order->htetYus as $key => $htetyu)
                            <div class="card mb-3">
                                <div class="card-body">
                                    @if ($key > 0)
                                        @if ($htetyu->pawn_id == 1)
                                            <a href="/htetyus/delete/{{ $htetyu->id }}"
                                                onclick="return confirm('ထိုအချက်အလက်ကို အပြီးတိုင်ဖျက်ပစ်မည်ဖြစ်သည်။ သေချာပါသလား?')">
                                                <i class="fa-solid fa-xmark text-danger float-end"></i>
                                            </a>
                                        @endif
                                    @endif
                                    <div class=" card-title text-primary">{{ $htetyu->name }}</div>
                                    <div class=" text-bold text-success">{{ number_format($htetyu->price) }}</div>
                                    <div
                                        class=" card-text @if ($htetyu->pawn_id == 1) {{ 'text-danger' }} @endif ">
                                        @php
                                            $time = $htetyu->created_at;
                                            $timeOut = $time->modify('+1 days')->format('Y-m-d H:i:s');
                                            $now = date('Y-m-d H:i:s');
                                            if ($now >= $timeOut) {
                                                echo $htetyu->created_at;
                                            } else {
                                                echo $htetyu->created_at->diffForHumans();
                                            }
                                        @endphp
                                        @if ($htetyu->pawn_id == 2)
                                            ->
                                            <span class=" card-text text-danger">
                                                @php
                                                    $time = $htetyu->updated_at;
                                                    $timeOut = $time->modify('+1 days')->format('Y-m-d H:i:s');
                                                    $now = date('Y-m-d H:i:s');
                                                    if ($now >= $timeOut) {
                                                        echo $htetyu->updated_at;
                                                    } else {
                                                        echo $htetyu->updated_at->diffForHumans();
                                                    }
                                                @endphp
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- PAY INTEREST --}}
            <div class="col-12 col-sm-8 col-md-8 d-flex align-items-stretch flex-column mb-4">
                <h4>အတိုးဆပ် လပြောင်း ထားသော မှတ်တမ်းများ</h4>
                <div class="card d-flex flex-fill mb-3">
                    <div class="card-body">
                        @foreach ($order->payInterests as $key => $interest)
                            <div class="card mb-2">
                                <div class=" card-body">
                                    @if ($key == count($order->payInterests) - 1)
                                        <a href="/interests/delete/{{ $interest->id }}"
                                            onclick="return confirm('ထိုအချက်အလက်ကို အပြီးတိုင်ဖျက်ပစ်မည်ဖြစ်သည်။ သေချာပါသလား?')">
                                            <i class="fa-solid fa-xmark text-danger float-end"></i>
                                        </a>
                                    @endif
                                    <div class="card-title text-primary">{{ $interest->name }}
                                        ({{ $interest->updated_at }})
                                    </div>
                                    {{-- အရင်း
                                    <span class="text-success">{{ number_format($interest->total_price) }}</span>| --}}
                                    <div class="text-success">{{ $interest->price_month }}</div>
                                    အတိုးစုစုပေါင်း
                                    <span
                                        class="text-success">{{ number_format($interest->total_interest_price) }}</span>
                                    ထဲမှ
                                    <span class="text-success">{{ number_format($interest->paid_interest_price) }}</span>
                                    ဆပ်၍
                                    <span class="text-danger">{{ $interest->created_at }}</span> သို့
                                    ပြောင်းရွှေ့ခဲ့သည်။
                                </div>
                            </div>
                        @endforeach
                        @if ($order->pawn_id == 2)
                            <div class="card mb-2 bg-danger bg-opacity-25">
                                <div class=" card-body">
                                    <div class="card-title text-primary">{{ $eduction->name }}
                                        ({{ $eduction->created_at }})
                                    </div>
                                    <div>
                                        အရင်း <span class=" text-primary">{{ number_format($eduction->price) }}</span> +
                                        အတိုး <span class=" text-primary">{{ number_format($eduction->interest) }}</span>
                                        = <span class=" text-success">{{ number_format($eduction->total) }}</span>
                                    </div>
                                    <div>
                                        ရွေးယူသည့်ငွေ = <span
                                            class="text-success">{{ number_format($eduction->paid) }}</span>
                                    </div>
                                </div>
                                <div class=" card-footer">
                                    <span class="text-muted">{{ $eduction->note }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- buttons --}}
        <div class=" float-end mb-5">
            <a href="/orders/htetyu/{{ $order->id }}"
                class="btn btn-primary @if ($order->pawn_id == 2) disabled @endif">ထပ်ယူ</a>
            <a href="/orders/payinterest/{{ $order->id }}"
                class="btn btn-primary @if ($order->pawn_id == 2) disabled @endif">အတိုးဆပ်</a>
            <a href="/orders/eduction/{{ $order->id }}"
                class="btn btn-danger @if ($order->pawn_id == 2) disabled @endif">
                @if ($order->pawn_id == 1)
                    ရွေးမည်
                @else
                    ရွေးပြီးပါပြီ
                @endif
            </a>
            <a href="/" class="btn btn-outline-secondary">Home</a>
        </div>
    </div>
@endsection
