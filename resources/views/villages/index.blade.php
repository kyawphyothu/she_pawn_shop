@extends('layouts.app')
@section('content')
    <div class="container">
        @include('layouts.alert')
        <form action="/villages" method="POST" class=" mb-5">
            @csrf
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col-12 col-lg-6">
                    <div class=" form-group mb-3">
                        <label for="name">ရွာအမည်<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class=" form-control" placeholder="ရွာအမည်ထည့်ပါ">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <div>
                        <button type="submit" class=" btn btn-primary">ရွာအသစ်ထည့်သွင်းမည်</button>
                    </div>
                </div>
            </div>
        </form>
        <hr>

        <table class="table table-striped" id="village_table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ရွာအမည်</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($villages as $village)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $village->name }}</td>
                        <td>
                            <a href='{{ url("/villages/edit/$village->id") }}' class=" btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            {{ $villages->withQueryString()->links() }}
        </table>
        {{ $villages->withQueryString()->links() }}
    </div>
@endsection
