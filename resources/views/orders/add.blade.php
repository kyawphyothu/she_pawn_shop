@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('info'))
            <div class=" alert alert-success user-select-none">
                {{ session('info') }}
                <i class="fa-solid fa-xmark float-end text-danger close-btn" onclick="this.parentElement.style.display = 'none';"></i>
            </div>
        @endif
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
                        <input type="text" placeholder="အမည်ထည့်ပါ" name="name" class=" form-control"
                            value="{{ request()->old('name') }}">
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
                                <option value="{{ $village['id'] }}" @if (old('village_id') == $village['id']) selected @endif>
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
                        <div class="mb-3">
                            <div class=" d-flex flex-wrap justify-content-between">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="{{ $i }}"
                                            name="category_id[]" value="{{ $category->id }}"
                                            @if (old('category_id')) @if (in_array($category->id, old('category_id'))) checked @endif @endif>
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
                    </div>
                    <div class="form-group mb-3">
                        <div class="row d-flex flex-wrap">
                            <label for="">အလေးချိန်</label>
                            <div class="col-12 mb-1 col-lg-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightKyat"
                                        value="{{ old('weightKyat') ? old('weightKyat') : 0 }}">
                                    <span class=" input-group-text">ကျပ်သား</span>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightPae"
                                        value="{{ old('weightPae') ? old('weightPae') : 0 }}">
                                    <span class=" input-group-text">ပဲ</span>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="weightYwe"
                                        value="{{ old('weightYwe') ? old('weightYwe') : 0 }}">
                                    <span class=" input-group-text">ရွေး</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" form-group mb-3">
                        <label for="">ယူငွေ</label>
                        <div class="input-group">
                            <input type="number" name="price" class=" form-control" min="1000"
                                value="{{ old('price') }}">
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
                                <option value="{{ $owner->id }}" @if (old('owner_id') == $owner->id) selected @endif>
                                    {{ $owner->name }}
                                </option>
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
                            value="{{ date('Y-m-d H:i:s') }}" step="1">
                        @if ($errors->has('datetime_local'))
                            <div class="text-danger">
                                {{ $errors->first('datetime_local') }}
                            </div>
                        @endif
                    </div>
                    <div class=" form-group mb-3">
                        <label for="">မှတ်ချက်</label>
                        <textarea name="note" id="" cols="30" rows="5" class=" form-control"
                            placeholder="မှတ်ချက်ရေးရန်..."></textarea>
                    </div>

                    <div class="form-group float-end">
                        <input type="submit" name="action" value="ဆက်တိုက်အပေါင်လက်ခံမည်" class="btn btn-primary mb-2">
                        <input type="submit" name="action" value="အပေါင်လက်ခံမည်" class="btn btn-success mb-2">
                        <a href="/" class="btn btn-outline-secondary">မလုပ်တော့ပါ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
