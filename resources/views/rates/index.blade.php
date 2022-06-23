@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-primary">
                အတိုးနှုန်း ပြောင်းလဲသတ်မှတ်မည်
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class=" form-group mb-3">
                        <label for="">ငါးသိန်း အောက်နည်းသော</label>
                        <div class="input-group">
                            <input type="number" min="0" name="rate4L" class=" form-control"
                                value="{{ $rate4L }}">
                            <div class="input-group-append">
                                <span class="input-group-text">ကျပ်တိုး</span>
                            </div>
                        </div>
                    </div>
                    <div class=" form-group mb-4">
                        <label for="">ငါးသိန်း ထက်များသော</label>
                        <div class="input-group">
                            <input type="number" min="0" name="rate4G" class=" form-control"
                                value="{{ $rate4G }}">
                            <div class="input-group-append">
                                <span class="input-group-text">ကျပ်တိုး</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2 float-end">
                        <input type="submit" name="" id="" class=" btn btn-success" value="Change Rate">
                        <a href="/" class="btn btn-outline-secondary">Home</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
