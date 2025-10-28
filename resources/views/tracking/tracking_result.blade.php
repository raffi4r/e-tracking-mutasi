@extends('adminlte::page')

@section('layout_topnav', false)
@section('layout_sidebar', false)
@section('layout_footer', false)

@section('title', 'Hasil Pencarian Mutasi ASN')

@section('body')
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background: #f7f9fc;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-section {
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
        }

        .header-section img {
            height: 70px;
        }

        .header-text h4 {
            font-weight: bold;
            margin-bottom: 4px;
        }

        .card-custom {
            max-width: 950px;
            margin: 50px auto;
            border: none;
            border-radius: 10px;
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

        /* =============================
                               PROGRESS STEPS STYLING
                            ============================= */
        .steps-wrapper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 50px;
            padding: 0 20px;
        }

        .steps-wrapper::before {
            content: "";
            position: absolute;
            top: 24px;
            left: 10%;
            right: 10%;
            height: 4px;
            background: #dee2e6;
            border-radius: 2px;
            z-index: 0;
        }

        .progress-bar-line {
            position: absolute;
            top: 24px;
            left: 10%;
            height: 4px;
            background: #007bff;
            border-radius: 2px;
            z-index: 1;
            transition: width 0.5s ease;
        }

        .step {
            position: relative;
            text-align: center;
            z-index: 2;
            flex: 1;
        }

        .circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #dee2e6;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #6c757d;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .step.completed .circle {
            background: #28a745;
            color: #fff;
        }

        .step.completed.final .circle {
            background: #28a745 !important;
            color: #fff;
            box-shadow: 0 0 12px rgba(40, 167, 69, 0.6);
        }

        .step.active .circle {
            background: #007bff;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
        }

        .label {
            margin-top: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            line-height: 1.3em;
            max-width: 140px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 768px) {
            .info-progress-container {
                flex-direction: column;
                text-align: center;
            }

            .steps-wrapper {
                flex-direction: column;
                align-items: center;
                padding: 0;
            }

            .steps-wrapper::before,
            .progress-bar-line {
                display: none;
            }

            .step {
                margin-bottom: 20px;
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
                // Tentukan steps sesuai jenis mutasi
                switch ($mutasi->jenis_mutasi) {
                    case 'Mutasi Masuk':
                        $statusSteps = [
                            1 => 'Berkas Diterima',
                            2 => 'Verifikasi & Disposisi Pimpinan',
                            3 => 'Proses Telaah Staff',
                            4 => 'Rekomendasi Menerima Terbit',
                            5 => 'Nota Usul',
                            6 => 'SK Penempatan Terbit',
                            7 => 'Selesai',
                        ];
                        break;
                    case 'Mutasi Keluar':
                        $statusSteps = [
                            1 => 'Berkas Diterima',
                            2 => 'Verifikasi & Disposisi Pimpinan',
                            3 => 'Proses Telaah Staff',
                            4 => 'Rekomendasi Melepas Terbit',
                            5 => 'Selesai',
                        ];
                        break;
                    case 'Mutasi Antar OPD':
                        $statusSteps = [
                            1 => 'Berkas Diterima',
                            2 => 'Verifikasi & Disposisi Pimpinan',
                            3 => 'SK Mutasi Terbit',
                            4 => 'Selesai',
                        ];
                        break;
                    default:
                        $statusSteps = [1 => 'Berkas Diterima'];
                }

                $currentStep = (int) ($mutasi->status ?? 1);
                $stepCount = count($statusSteps);
                $progressWidth = (($currentStep - 1) / ($stepCount - 1)) * 80 + 10; // biar garis tak mentok kiri-kanan
            @endphp

            <div class="card card-custom">
                <div class="card-header text-center">
                    <h4 class="mb-0">Status Mutasi ASN</h4>
                </div>

                <div class="info-progress-container">
                    <div class="info-section">
                        <h5 class="text-primary fw-bold mb-3">Informasi Mutasi</h5>
                        <p><strong>Kode Tiket:</strong> {{ $mutasi->kode_tiket }}</p>
                        <p><strong>Nama Pegawai:</strong> {{ $mutasi->nama }}</p>
                        <p><strong>OPD Asal:</strong> {{ $mutasi->opd_asal }}</p>
                        <p><strong>OPD Tujuan:</strong> {{ $mutasi->opd_tujuan }}</p>
                        <p><strong>Jenis Mutasi:</strong> {{ $mutasi->jenis_mutasi }}</p>
                        <p><strong>Tanggal Pengajuan:</strong> {{ $mutasi->created_at->format('d M Y') }}</p>
                        <p><strong>Status Saat Ini:</strong>
                            <span class="badge bg-primary">
                                {{ $statusSteps[$currentStep] ?? 'Berkas Diterima' }}
                            </span>
                        </p>
                    </div>

                    <div class="progress-section">
                        <h5 class="text-primary fw-bold mb-3">Progress Status</h5>
                        <div class="steps-wrapper">
                            <div class="progress-bar-line" style="width: {{ $progressWidth }}%;"></div>
                            @foreach ($statusSteps as $i => $label)
                                @php
                                    $cls = '';
                                    if ($i < $currentStep) {
                                        $cls = 'completed';
                                    } elseif ($i == $currentStep) {
                                        $cls = 'active';
                                    }

                                    // Jika sudah selesai (step terakhir)
                                    if ($i == $stepCount && $currentStep == $stepCount) {
                                        $cls = 'completed final';
                                    }

                                    // Ambil tanggal step ke-i
                                    $tanggalField = 'tanggal_' . $i;
                                    $tanggal = $mutasi->$tanggalField
                                        ? $mutasi->$tanggalField->format('d M Y H:i')
                                        : null;
                                @endphp

                                <div class="step {{ $cls }}">
                                    <div class="circle">{{ $i }}</div>
                                    <div class="label">
                                        {{ $label }}
                                        @if ($tanggal)
                                            <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                                {{ $tanggal }}
                                            </div>
                                        @endif
                                    </div>
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
                <div class="not-found text-center p-5">
                    <i class="fas fa-search fa-3x text-primary mb-3"></i>
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
