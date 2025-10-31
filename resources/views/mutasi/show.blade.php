@extends('adminlte::page')

@section('classes_body', 'sidebar-collapse')

@section('title', 'Detail Mutasi')

@section('content_header')
    <h1>Detail Mutasi</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Kode Tiket</th>
                    <td>{{ $mutasi->kode_tiket }}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>{{ $mutasi->nip }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $mutasi->nama }}</td>
                </tr>
                <tr>
                    <th>Jenis Mutasi</th>
                    <td>{{ $mutasi->jenis_mutasi }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $mutasi->status }}</td>
                </tr>
                <tr>
                    <th>Dibuat</th>
                    <td>{{ $mutasi->created_at }}</td>
                </tr>
            </table>
            <a href="{{ route('mutasi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@stop
