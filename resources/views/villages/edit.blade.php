@extends('layouts.app')
@section('content')
    <div class=" container">
        <div class=" h-3 mb-3 text-primary">
            ရွာအမည်ပြောင်းရန်
        </div>
        <form action="/villages/update" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $village->id }}">
            <div class=" form-group mb-3">
                <label for="name">ရွာအမည်</label>
                <input type="text" name="name" id="name" value="{{ $village->name }}" class=" form-control">
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div>
                <button type="submit" class=" btn btn-success">အတည်ပြုမည်</button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">မလုပ်တော့ပါ</a>
            </div>
        </form>
    </div>
@endsection
