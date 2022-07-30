@extends('layouts.app')
@section('content')
<div class="container">
    <div class=" content-wrapper">
        <div class=" content-header">
            @if (session('info'))
                <div class="alert alert-info">
                    {{-- <button type="button" class="close" data-dismiss="alert">×</button> --}}
                    <strong>{{ session('info') }}</strong>
                </div>
            @endif
            <div class=" container-fluid mb-3">
                <h1>Backups</h1>
                <form action="/backups" method="POST">
                    @csrf
                    <button class="btn btn-primary" type="submit">Create a new Backup</button>
                </form>
            </div>
            <div class="container-fluid d-flex justify-content-center">
                <table class=" table table-head-fixed table-striped ">
                    <tr class=" table-active">
                        <th>#</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Size</th>
                        <th style="width: 9%">Action</th>
                    </tr>
                    @php
                        $i = 0;
                    @endphp
                    @if (!empty($backup) && $backup->count())
                        @foreach ($backup as $backup)
                            @php
                                $i++;
                            @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $backup->name }}</td>
                                <td>{{ $backup->created_at }}</td>
                                <td>{{ $backup->size }} MB</td>
                                <td>
                                    <div class=" d-flex justify-content-between">
                                        <a href="{{ asset('storage/shepawnshop/' . $backup->name) }}" class="btn  btn-primary mr-3"><span class="fa fa-download"></span></a>
                                        <a href="{{ url('/backups/delete/' . $backup->id) }}" class="btn  btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        {{-- <form action="{{ url('admin/database_backup/' . $backup->id) }}" method="POST">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class=" btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </form> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class=" h3 text-primary">There are no Backup File.</td>
                        </tr>
                    @endif
                    {{-- {{ $backup->withQueryString()->links() }} --}}
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
