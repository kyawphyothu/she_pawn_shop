@extends('layouts.app')

@section('content')
    <div class="container w-100">
        <div class="row">
            <div class=" col-9">
                {{-- SEARCH --}}
                <form action="/orders/search" method="POST" class="mb-1">
                    @csrf
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="အမည်ဖြင့်ရှာရန်" name="name" required>
                        <input class="input-group-text" type="submit" value="Search">
                    </div>
                </form>
                {{-- nav --}}
                <ul class=" nav nav-pills justify-content-center mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">အားလုံး</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">မရွေးရသေးသော ပစ္စည်းများ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ရွေးပြီးသား ပစ္စည်းများ</a>
                    </li>
                </ul>
                {{-- contents --}}
                <div class="row ">
                    @foreach ($allOrders as $allOrder)
                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mb-4">
                            <div class="card d-flex flex-fill">
                                <div class="card-body">
                                    <div class=" card-title h5">
                                        <span class=" text-primary">{{ $allOrder->name }}</span>
                                        (<sapn class=" text-muted">
                                            {{ $allOrder->village->name }}
                                        </sapn>)
                                    </div>
                                    <div class=" card-subtitle text-muted">
                                        {{-- put category --}}
                                    </div>
                                    <div class=" text-muted">
                                        <b>{{ floor($allOrder->weight / 128) }}</b>
                                        ကျပ်သား
                                        <b>{{ floor(($allOrder->weight % 128) / 8) }}</b>
                                        ပဲ
                                        <b>{{ ($allOrder->weight % 128) % 8 }}</b>
                                        မူး
                                    </div>
                                    <div class=" text-success">
                                        <b>
                                            {{ number_format($allOrder->price) }}
                                        </b>ကျပ်
                                    </div>
                                    <div class=" card-text">
                                        @if ($allOrder->note)
                                            @php
                                                $note = $allOrder->note;
                                                $result = Str::substr($note, 0, 50);
                                            @endphp
                                            <span class=" text-muted"> {{ $result }} . . .</span>
                                        @else
                                            <span class=" text-muted">No Note</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class=" d-flex justify-content-between">
                                        <small class=" text-muted mt-2">20.5.2.22</small>
                                        <small class=" mt-2 text-primary">{{ $allOrder->owner->name }}</small>
                                        <a href="/orders/detail" class="btn btn-success">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $allOrders->links() }}
                </div>
            </div>
            {{-- right --}}
            <div class="col-3">
                {{-- add new --}}
                <a href="/orders/add" class=" btn btn-success btn-lg mb-2 w-100">အပေါင်ခံမည်</a>
                <div class="card">
                    <div class="card-header">
                        <div class=" h4 text-primary">
                            ရွေးထုတ်ရန်
                        </div>
                    </div>
                    <div class=" card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class=" form-group mb-3">
                                <label for="location">နေရပ်</label>
                                <select class="form-select form-control" name="location">
                                    <option value="1">1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">ပစ္စည်း အမျိုးအစား</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ring" name="category[]"
                                        value="ring">
                                    <label class="form-check-label" for="ring">Ring</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rope" name="category[]"
                                        value="Rope">
                                    <label class="form-check-label" for="rope">Rope</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="footer" name="category[]"
                                        value="footer">
                                    <label class="form-check-label" for="footer">Footer</label>
                                </div>
                            </div>
                            <div class=" form-group mb-3">
                                <label for="">ယူငွေ</label>
                                <div class="input-group">
                                    <input type="number" name="price" class=" form-control" min="1000">
                                    <span class=" input-group-text">ကျပ်</span>
                                </div>
                            </div>
                            <input type="submit" class=" btn btn-info" style="float: right;" value="Apply">
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
