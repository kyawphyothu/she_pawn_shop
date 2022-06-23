@extends('layouts.app')

@section('content')
    <div class="container">


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
                                        <a href="/htetyus/delete/{{ $htetyu->id }}"
                                            onclick="return confirm('ထိုအချက်အလက်ကို အပြီးတိုင်ဖျက်ပစ်မည်ဖြစ်သည်။ သေချာပါသလား?')">
                                            <i class="fa-solid fa-xmark text-danger float-end"></i>
                                        </a>
                                    @endif
                                    <div class=" card-title text-primary">{{ $htetyu->name }}</div>
                                    <div class=" text-bold text-success">{{ number_format($htetyu->price) }}</div>
                                    <div class=" card-text @if ($htetyu->pawn_id == 1) {{ 'text-danger' }} @endif ">
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
                                    <a href="/interests/delete/{{ $interest->id }}"
                                        onclick="return confirm('ထိုအချက်အလက်ကို အပြီးတိုင်ဖျက်ပစ်မည်ဖြစ်သည်။ သေချာပါသလား?')">
                                        <i class="fa-solid fa-xmark text-danger float-end"></i>
                                    </a>
                                    <div class="card-title text-primary">{{ $interest->name }}
                                        ({{ $interest->created_at }})
                                    </div>
                                    အရင်း
                                    <span class="text-success">{{ number_format($interest->total_price) }}</span>|
                                    အတိုးစုစုပေါင်း
                                    <span class="text-success">{{ number_format($interest->total_interest_price) }}</span>
                                    ထဲမှ
                                    <span class="text-success">{{ number_format($interest->paid_interest_price) }}</span>
                                    ဆပ်၍
                                    <span class="text-danger">{{ $interest->updated_at }}</span> သိ့
                                    ပြောင်းရွှေ့ခဲ့သည်။
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-danger bg-opacity-70">
                <div class=" card-title h4 text-black">
                    ရွေးမည်
                </div>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="">နာမည်</label>
                        <input type="text" placeholder="အမည်ထည့်ပါ" name="name" class=" form-control"
                            value="{{ $order->name }}" required>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="" class="text-muted">အရင်း</label>
                            <input type="number" name="price" class=" form-control" value="{{ $totalPrice }}"
                                required>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="">အတိုး</label>
                            <input type="number" name="interest" class=" form-control" value="{{ $totalInterest }}"
                                required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">အတိုး + အရင်း</label>
                        <input type="number" name="total" class=" form-control"
                            value="{{ round($totalInterest + $totalPrice, -2) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class=" text-success">ပေးဆပ်သည့် တိုး+ရင်း</label>
                        <input type="number" name="paid" class=" form-control col-6" required>
                    </div>
                    <div class="mb-3">
                        <label for="">လာရွေးသည့်ရက်</label>
                        <input type="datetime-local" name="day" id="" class="form-control"
                            value="{{ date('Y-m-d H:i:s') }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="">မှတ်ချက်</label>
                        <textarea name="note" id="" cols="30" rows="10" class=" form-control"
                            placeholder="မှတ်ချက်ရေးရန်"></textarea>
                    </div>

                    <div class="form-group mb-3 float-end">
                        <input type="submit" name="" id="" class=" btn btn-danger" value="ရွေးမည်">
                        <a href="/orders/detail/{{ $order->id }}" class="btn btn-outline-info">Back</a>
                        <a href="/" class="btn btn-outline-secondary">Home</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
