@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- create daily summary --}}
        <form action="" method="POST" class=" mb-4">
            @csrf
            <div class="row">
                <div class="col-6">
                    <input type="date" name="date" id="" class=" form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-6">
                    <input type="submit" value="Create Daily Summary" class=" form-control btn btn-primary">
                </div>
            </div>
        </form>

        {{-- daily summary  card --}}
        <div class="card">
            <div class=" card-header">
                <div class=" card-title text-center"><span class="text-primary h5">Daily</span>
                    Summary</div>
            </div>
            {{-- card body --}}
            <div class="card-body">
                <div class="row">
                    {{-- အိမ် အတွက် summary --}}
                    <div class=" col-3">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                <h5 class="list-group-item-heading text-center">အိမ်</h5>
                            </li>
                            {{-- looped data --}}
                            @foreach ($home as $home)
                                <li class="list-group-item">
                                    {{-- date time --}}
                                    <h6>
                                        @php
                                            echo date('Y-m-d', strtotime($home->created_at));
                                        @endphp
                                    </h6>
                                    <span class=" text-success">{{ $home->in_price }}</span> {{-- income --}}
                                    <span class=" text-danger">{{ $home->out_price }}</span> {{-- outcome --}}
                                    <h5
                                        class=" float-end @if ($home->profi_loss == 0) text-danger
                                        @elseif ($home->profi_loss == 1)
                                        text-default
                                        @elseif ($home->profi_loss == 2)
                                        text-success @endif">
                                        {{ $home->diff_price }}
                                    </h5> {{-- profit or loss --}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- အေးအေးခိုင် summary --}}
                    <div class=" col-3">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                <h5 class="list-group-item-heading text-center">အေးအေးခိုင်</h5>
                            </li>
                            {{-- looped data --}}
                            @foreach ($aye as $aye)
                                <li class="list-group-item">
                                    <h6>
                                        @php
                                            echo date('Y-m-d', strtotime($aye->created_at));
                                        @endphp
                                    </h6>
                                    <span class=" text-success">{{ $aye->in_price }}</span>
                                    <span class=" text-danger">{{ $aye->out_price }}</span>
                                    <h5
                                        class=" float-end @if ($aye->profi_loss == 0) text-danger
                                        @elseif ($aye->profi_loss == 1)
                                        text-default
                                        @elseif ($aye->profi_loss == 2)
                                        text-success @endif">
                                        {{ $aye->diff_price }}
                                    </h5>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- စန်းစန်းထွေး summary --}}
                    <div class=" col-3">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                <h5 class="list-group-item-heading text-center">စန်းစန်းထွေး</h5>
                            </li>
                            {{-- looped data --}}
                            @foreach ($san as $san)
                                <li class="list-group-item">
                                    <h6>
                                        @php
                                            echo date('Y-m-d', strtotime($san->created_at));
                                        @endphp
                                    </h6>
                                    <span class=" text-success">{{ $san->in_price }}</span>
                                    <span class=" text-danger">{{ $san->out_price }}</span>
                                    <h5
                                        class=" float-end @if ($san->profi_loss == 0) text-danger
                                        @elseif ($san->profi_loss == 1)
                                        text-default
                                        @elseif ($san->profi_loss == 2)
                                        text-success @endif">
                                        {{ $san->diff_price }}
                                    </h5>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- ဥမ္မာဝင်း summary --}}
                    <div class=" col-3">
                        <ul class="list-group">
                            <li class="list-group-item active">
                                <h5 class="list-group-item-heading text-center">ဥမ္မာဝင်း</h5>
                            </li>
                            {{-- looped data --}}
                            @foreach ($ohmar as $ohmar)
                                <li class="list-group-item">
                                    <h6>
                                        @php
                                            echo date('Y-m-d', strtotime($ohmar->created_at));
                                        @endphp
                                    </h6>
                                    <span class=" text-success">{{ $ohmar->in_price }}</span>
                                    <span class=" text-danger">{{ $ohmar->out_price }}</span>
                                    <h5
                                        class=" float-end @if ($ohmar->profi_loss == 0) text-danger
                                        @elseif ($ohmar->profi_loss == 1)
                                        text-default
                                        @elseif ($ohmar->profi_loss == 2)
                                        text-success @endif">
                                        {{ $ohmar->diff_price }}
                                    </h5>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
