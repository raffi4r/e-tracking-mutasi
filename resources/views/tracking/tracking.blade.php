@extends('adminlte::page')

@section('layout_topnav', false)
@section('layout_sidebar', false)
@section('layout_footer', false)

@section('title', 'Tracking Mutasi ASN')

@section('body')
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            /* Hilangkan scroll */
            background-image: url('{{ asset('images/bg-pattern.jpg') }}');
            background-repeat: repeat;
            background-size: 25%;
            background-attachment: fixed;
            background-position: top left;
        }

        /* Header biru di atas */
        .header-section {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            width: 100%;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
            height: 100px;
        }

        .header-section img {
            height: 70px;
            width: auto;
        }

        .header-text h4 {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .header-text h5 {
            margin: 0;
            font-weight: normal;
        }

        /* Bagian konten utama */
        .overlay {
            height: calc(100vh - 100px);
            /* sisakan ruang untuk header */
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.4);
            padding: 0 15px;
        }

        .card {
            border: none;
            max-width: 460px;
            width: 100%;
        }

        .card-header {
            background: linear-gradient(90deg, #007bff, #0056b3);
        }

        .card-footer {
            font-size: 0.85rem;
        }
    </style>

    {{-- HEADER BIRU --}}
    <div class="header-section">
        <img src="{{ asset('images/logo-rohul.png') }}" alt="Logo Rokan Hulu">
        <img src="{{ asset('images/logo-bkpp-rohul.png') }}" alt="Logo BKPP Rokan Hulu">
        <div class="header-text">
            <h4>Pemerintah Kabupaten Rokan Hulu</h4>
            <h5>Badan Kepegawaian, Pendidikan dan Pelatihan</h5>
        </div>
    </div>

    {{-- FORM DI TENGAH --}}
    <div class="overlay">
        <div class="card shadow-sm">
            <div class="card-header text-white text-center py-3">
                <h4 class="mb-0">E-Tracking Mutasi ASN</h4>
            </div>
            <div class="card-body p-4">
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('tracking.result') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_tiket" class="form-label">Kode Tiket</label>
                        <input type="text" name="kode_tiket" id="kode_tiket"
                            class="form-control @error('kode_tiket') is-invalid @enderror" value="{{ old('kode_tiket') }}"
                            required autofocus>
                        @error('kode_tiket')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" id="nip"
                            class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" required>
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                </form>
            </div>
            <div class="card-footer text-center text-muted py-2">
                <small>&copy; {{ date('Y') }} BKPP Kabupaten Rokan Hulu</small>
            </div>
        </div>
    </div>
@stop
