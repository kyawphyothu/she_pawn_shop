@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="h2 text-bold text-primary mb-3">အပေါင်ခံမည်</div>
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
                        <input type="text" placeholder="အမည်ထည့်ပါ" name="name" class=" form-control" required>
                    </div>
                    <div class=" form-group mb-3">
                        <label for="village">နေရပ်</label>
                        <select class="form-select" name="village_id">
                            @foreach ($villages as $village)
                                <option value="{{ $village['id'] }}">{{ $village['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">ပစ္စည်း အမျိုးအစား</label>
                        <div class="mb-3 d-flex flex-fill justify-content-between">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $i }}"
                                        name="category_id[]" value="{{ $category->id }}">
                                    <label class="form-check-label"
                                        for="{{ $i }}">{{ $category->name }}</label>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <label for="">အလေးချိန်</label>
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightKyat" value="0" min="0">
                                    <span class=" input-group-text">ကျပ်သား</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightPae" value="0" max="15" min="0">
                                    <span class=" input-group-text">ပဲ</span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightYwe" value="0" max="7" min="0">
                                    <span class=" input-group-text">ရွေး</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class=" form-group mb-3">
                        <label for="">ယူငွေ</label>
                        <div class="input-group">
                            <input type="number" name="price" class=" form-control" min="1000">
                            <span class=" input-group-text">ကျပ်</span>
                        </div>
                    </div>
                    <div class=" form-group mb-3">
                        <label for="location">လက်ခံသူ</label>
                        <select class="form-select form-control" name="owner_id">
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">ရက်စွဲ</label><br>
                        <input type="datetime-local" name="datetime_local" id="">
                    </div>
                    <div class=" form-group mb-3">
                        <label for="">မှတ်ချက်</label>
                        <textarea name="note" id="" cols="30" rows="5" class=" form-control" placeholder="မှတ်ချက်ရေးရန်..."></textarea>
                    </div>

                    <div class="form-group float-end">
                        <input type="submit" value="အပေါင်လက်ခံမည်" class="btn btn-success">
                        <a href="/" class="btn btn-outline-secondary">မလုပ်တော့ပါ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
