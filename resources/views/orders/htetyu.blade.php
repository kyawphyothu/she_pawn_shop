@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary bg-opacity-50">
                <div class="card-title h4 text-black">
                    ငွေထပ်ယူမည်
                    <small class=" text-bold">({{ $order->owner->name }})</small>
                </div>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">အမည်</label>
                        <input type="text" name="name" class=" form-control"
                            value="{{ old('name') ? old('name') : $order->name }}">
                        @if ($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">ထပ်ယူငွေ</label>
                        <input type="number" min="1000" class=" form-control" name="price">
                        @if ($errors->has('price'))
                            <div class="text-danger">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">ရက်စွဲ</label><br>
                        <input type="datetime-local" name="datetime_local" id="" class="form-control"
                            value="{{ old('datetime_local') ? old('datetime_local') : date('Y-m-d H:i:s') }}" step="1">
                        @if ($errors->has('datetime_local'))
                            <div class="text-danger">
                                {{ $errors->first('datetime_local') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group mb-3 float-end">
                        <input type="submit" name="" id="" class=" btn btn-success" value="အတည်ပြုမည်">
                        <a href="/orders/detail/{{ $order->id }}" class="btn btn-outline-info">Back</a>
                        <a href="/" class="btn btn-outline-secondary">Home</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
