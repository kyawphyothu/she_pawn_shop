@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="h2 text-bold text-primary mb-3">ပြင်ဆင်မည်</div>
        <div class="card">
            <div class="card-body">
                {{-- @if (session('data'))
                    @foreach (session('data') as $item)
                        {{ $item }}
                    @endforeach
                @endif --}}
                <form action="" method="POST">
                    @csrf
                    <div class="my-3">
                        <label for="">နာမည်</label>
                        <input type="text" placeholder="အမည်ထည့်ပါ" name="name" class=" form-control"
                            value="{{ old('name') ? old('name') : $order->name }}">
                        @if ($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class=" form-group mb-3">
                        <label for="village">နေရပ်</label>
                        <select class="form-select" name="village_id">
                            @foreach ($villages as $village)
                                <option value="{{ $village['id'] }}" @if ($order->village_id == $village['id']) selected @endif>
                                    {{ $village['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('village_id'))
                            <div class="text-danger">
                                {{ $errors->first('village_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">ပစ္စည်း အမျိုးအစား</label>
                        <div class="mb-3 d-flex flex-wrap justify-content-between">
                            @php
                                $i = 1;
                                $orderCategoryArr = [];
                                foreach ($order->orderCategories as $orderCategory) {
                                    $orderCategoryArr[] += $orderCategory->category_id;
                                }
                            @endphp
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $i }}"
                                        name="category_id[]" value="{{ $category->id }}"
                                        @if (old('category_id')) @if (in_array($category->id, old('category_id')))
                                            checked @endif
                                    @elseif (in_array($category->id, $orderCategoryArr)) checked @endif>
                                    <label class="form-check-label" for="{{ $i }}">{{ $category->name }}</label>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                        @if ($errors->has('category_id'))
                            <div class="text-danger">
                                {{ $errors->first('category_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        @php
                            $total_weight = $order->weight;
                            $kyat_weight = floor($total_weight / 128);
                            $pae_weight = floor(($total_weight % 128) / 8);
                            $ywe_weight = ($total_weight % 128) % 8;
                        @endphp
                        <div class="row">
                            <label for="">အလေးချိန်</label>
                            <div class="col-12 col-lg-4 mb-1 mb-lg-0">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightKyat"
                                        value="{{ old('weightKyat') ? old('weightKyat') : $kyat_weight }}" min="0">
                                    <span class=" input-group-text">ကျပ်သား</span>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightPae"
                                        value="{{ old('weightPae') ? old('weightPae') : $pae_weight }}" max="15"
                                        min="0">
                                    <span class=" input-group-text">ပဲ</span>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightYwe"
                                        value="{{ old('weightYwe') ? old('weightYwe') : $ywe_weight }}" max="7"
                                        min="0">
                                    <span class=" input-group-text">ရွေး</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class=" form-group mb-3">
                        <label for="">ယူငွေ</label>
                        <div class="input-group">
                            <input type="number" name="price" class=" form-control" min="1000"
                                value="{{ old('price') ? old('price') : $order->htetYus[0]->price }}">
                            <span class=" input-group-text">ကျပ်</span>
                        </div>
                        @if ($errors->has('price'))
                            <div class="text-danger">
                                {{ $errors->first('price') }}
                            </div>
                        @endif
                    </div>
                    <div class=" form-group mb-3">
                        <label for="location">လက်ခံသူ</label>
                        <select class="form-select form-control" name="owner_id">
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}" @if ($order->owner_id == $owner->id) selected @endif>
                                    {{ $owner->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('owner_id'))
                            <div class="text-danger">
                                {{ $errors->first('owner_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">ရက်စွဲ</label><br>
                        <input type="datetime-local" name="datetime_local" id="" class="form-control"
                            value="{{ old('datetime_local') ? old('datetime_local') : $order->created_at }}" step="1">
                        @if ($errors->has('datetime_local'))
                            <div class="text-danger">
                                {{ $errors->first('datetime_local') }}
                            </div>
                        @endif
                    </div>
                    <div class=" form-group mb-3">
                        <label for="">မှတ်ချက်</label>
                        <textarea name="note" id="" cols="30" rows="5" class=" form-control"
                            placeholder="မှတ်ချက်ရေးရန်...">{{ old('note') ? old('note') : $order->note }}</textarea>
                    </div>

                    <div class="form-group float-end">
                        <input type="submit" value="ပြင်ဆင်မည်" class="btn btn-success">
                        <a href="/orders/detail/{{ $order->id }}" class="btn btn-outline-secondary">မလုပ်တော့ပါ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
