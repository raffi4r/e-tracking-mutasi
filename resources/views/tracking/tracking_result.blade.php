@extends('adminlte::page')

@section('layout_topnav', false)
@section('layout_sidebar', false)
@section('layout_footer', false)

@section('title', 'Hasil Pencarian Mutasi ASN')

@section('body')
    <style>
        /* ============================
       BODY & BACKGROUND
    ============================ */
        html,
        body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
            background-image: url('{{ asset('images/bg-pattern.jpg') }}');
            background-repeat: repeat;
            background-size: 25%;
            background-attachment: fixed;
            background-position: top left;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ============================
       HEADER SECTION
    ============================ */
        .header-section {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            width: 100%;
            padding: 15px 40px;
            display: flex;
            flex-wrap: wrap;
            /* wrap anak saat sempit */
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
            height: auto;
        }

        .header-section img {
            height: 70px;
            width: auto;
        }

        .header-text {
            min-width: 0;
            /* agar teks bisa wrap */
        }

        .header-text h4 {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .header-text h5 {
            margin: 0;
            font-weight: normal;
        }

        /* ============================
       CARD & CONTENT
    ============================ */
        .card-custom {
            max-width: 900px;
            margin: 50px auto;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-header {
            background-color: #007bff !important;
            color: #fff;
        }

        .info-progress-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 30px 40px;
            gap: 40px;
        }

        .info-section {
            flex: 1;
        }

        .progress-section {
            flex: 1;
            text-align: center;
        }

        /* ============================
       STEPS PROGRESS BAR
    ============================ */
        .steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            position: relative;
        }

        .steps::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 4px;
            background: #dee2e6;
            transform: translateY(-50%);
            z-index: 0;
        }

        .step-item {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .step-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #dee2e6;
            color: #6c757d;
            font-weight: bold;
            font-size: 16px;
            transition: 0.3s;
        }

        .step-item.active .step-circle {
            background: #007bff;
            color: white;
        }

        .step-label {
            margin-top: 8px;
            font-size: 14px;
            font-weight: 500;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            height: 4px;
            background: #007bff;
            transform: translateY(-50%);
            z-index: 0;
            border-radius: 2px;
            transition: width 0.4s ease;
        }

        /* ============================
       NOT FOUND SECTION
    ============================ */
        .not-found {
            text-align: center;
            padding: 60px 30px;
        }

        .not-found i {
            font-size: 60px;
            color: #007bff;
            margin-bottom: 15px;
        }

        /* ============================
       RESPONSIVE MOBILE
    ============================ */
        @media (max-width: 992px) {
            .header-section img {
                height: 60px;
            }
        }

        @media (max-width: 768px) {
            .info-progress-container {
                flex-direction: column;
                text-align: center;
            }

            .steps {
                flex-direction: column;
                gap: 20px;
            }

            .steps::before,
            .progress-line {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .header-section {
                flex-direction: column;
                justify-content: center;
                text-align: center;
                padding: 10px 15px;
            }

            .header-text {
                width: 100%;
                margin-top: 10px;
            }

            .header-text h4 {
                font-size: 1.1rem;
            }

            .header-text h5 {
                font-size: 0.9rem;
            }

            .header-section img {
                height: 50px;
                margin: 0 auto;
            }

            .card-custom {
                margin: 30px 10px;
                max-width: 100%;
            }
        }
    </style>


    <div class="header-section">
        <img src="{{ asset('images/logo-rohul.png') }}" alt="Logo Rokan Hulu">
        <img src="{{ asset('images/logo-bkpp-rohul.png') }}" alt="Logo BKPP Rokan Hulu">
        <div class="header-text">
            <h4>Pemerintah Kabupaten Rokan Hulu</h4>
            <h5>Badan Kepegawaian, Pendidikan dan Pelatihan</h5>
        </div>
    </div>

    <div class="container">
        @if ($mutasi)
            @php
                $steps = ['Diajukan', 'Diproses', 'Disetujui', 'Selesai'];
                if (is_numeric($mutasi->status)) {
                    $currentStep = (int) $mutasi->status;
                } else {
                    $map = ['diajukan' => 0, 'diproses' => 1, 'disetujui' => 2, 'selesai' => 3];
                    $currentStep = $map[strtolower($mutasi->status)] ?? 0;
                }
                $progressWidth = ($currentStep / (count($steps) - 1)) * 100;
            @endphp

            <div class="card card-custom">
                <div class="card-header text-center">
                    <h4 class="mb-0">Status Mutasi ASN</h4>
                </div>
                <div class="info-progress-container">
                    <div class="info-section text-start">
                        <h5 class="text-primary fw-bold mb-3">Informasi Mutasi</h5>
                        <p><strong>Kode Tiket:</strong> {{ $mutasi->kode_tiket }}</p>
                        <p><strong>Nama Pegawai:</strong> {{ $mutasi->nama }}</p>
                        <p><strong>OPD Asal:</strong> {{ $mutasi->opd_asal }}</p>
                        <p><strong>OPD Tujuan:</strong> {{ $mutasi->opd_tujuan }}</p>
                        <p><strong>Tanggal Pengajuan:</strong> {{ $mutasi->created_at->format('d M Y') }}</p>
                        <p><strong>Status Saat Ini:</strong>
                            <span class="badge bg-primary">
                                {{ is_numeric($mutasi->status) ? $steps[$mutasi->status] : ucfirst($mutasi->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="progress-section">
                        <h5 class="text-primary fw-bold mb-3">Progress Status</h5>
                        <div class="steps">
                            <div class="progress-line" style="width: {{ $progressWidth }}%;"></div>
                            @foreach ($steps as $i => $s)
                                <div class="step-item @if ($i <= $currentStep) active @endif">
                                    <div class="step-circle">{{ $i + 1 }}</div>
                                    <div class="step-label">{{ $s }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card-footer text-center bg-light">
                    <a href="{{ url('/tracking') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        @else
            <div class="card card-custom">
                <div class="card-header text-center">
                    <h4 class="mb-0">Hasil Pencarian</h4>
                </div>
                <div class="not-found">
                    <i class="fas fa-search"></i>
                    <h5>Data tidak ditemukan</h5>
                    <p class="text-muted">Pastikan kode tiket dan NIP yang Anda masukkan benar.</p>
                </div>
                <div class="card-footer text-center bg-light">
                    <a href="{{ url('/tracking') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        @endif
    </div>
@stop
