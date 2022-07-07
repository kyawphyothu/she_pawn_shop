@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($histories as $history)
            <div class="card mb-3 @if ($history->cancled == 1) bg-secondary bg-opacity-25 @endif">
                <div class="card-body ">
                    @if ($history->status == 1)
                        <div>
                            <i class="fa-solid fa-circle-check text-primary"></i>
                            အပေါင်လက်ခံ
                        </div>
                    @elseif ($history->status == 2)
                        <div>
                            <i class="fa-solid fa-circle-plus text-success"></i>
                            ထပ်ယူ
                        </div>
                    @elseif ($history->status == 3)
                        <div>
                            <i class="fa-solid fa-file-invoice text-warning"></i>
                            အတိုးဆပ်
                        </div>
                    @elseif ($history->status == 4)
                        <div>
                            <i class="fa-solid fa-check-double text-danger"></i>
                            ရွေးယူ
                        </div>
                    @endif
                    <div>
                        {{ $history->name }}
                        ({{ $history->village->name }})
                    </div>
                    <div class=" d-flex justify-content-between">
                        <span
                            class="@if ($history->status == 1 || $history->status == 2) text-danger
                            @elseif ($history->status == 3 || $history->status == 4)
                            text-success @endif">
                            {{ number_format($history->price) }}
                            ({{ $history->owner->name }})
                        </span>
                        <span>{{ $history->created_at }}</span>
                        <a href="/orders/detail/{{ $history->order_id }}" class=" text-primary"><i
                                class="fa-solid fa-angles-right"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
