@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('user_info.update') }}" method="POST">
        @csrf
        <input type="text" name="id" value="{{ Auth::user()->id }}" hidden>
        <div class=" form-group mb-3">
            <label for="name">User Name<span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class=" form-control" value="{{ old('name') ? old('name') : Auth::user()->name }}">
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class=" form-group mb-3">
            <label for="email">Email<span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class=" form-control" value="{{ old('email') ? old('email') : Auth::user()->email }}">
            @if ($errors->has('eamil'))
                <span class="text-danger">{{ $errors->first('eamil') }}</span>
            @endif
        </div>
        <div class=" form-group mb-3">
            <label for="password">Password<span class="text-danger">*</span></label>
            <input type="password" name="password" id="password" class=" form-control" value="{{ old('password') }}">
            @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class=" form-group mb-3">
            <label for="confirmPassword">Confirm Password<span class="text-danger">*</span></label>
            <input type="password" name="confirmPassword" id="confirmPassword" class=" form-control" value="{{ old('confirmPassword') }}">
            @if ($errors->has('confirmPassword'))
                <span class="text-danger">{{ $errors->first('confirmPassword') }}</span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class=" btn btn-primary">Update Profile</button>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
</div>
@endsection
