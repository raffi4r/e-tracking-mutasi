@extends('adminlte::page')

@section('classes_body', 'sidebar-collapse')

@section('layout_topnav', false)
@section('layout_sidebar', false)
@section('layout_footer', false)

@section('title', 'Hasil Pencarian Mutasi ASN')

@section('body')
    <style>
        html,
        body {
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
            max-width: 1000px;
            margin: 50px auto;
            border: none;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            font-weight: bold;
            border-radius: 12px 12px 0 0;
        }

        .info-section {
            padding: 25px 40px;
        }

        .info-section .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .info-box {
            flex: 1;
            min-width: 300px;
        }

        .info-box h5 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info-box p {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .steps-wrapper {
            position: relative;
            display: flex;
            justify-content: space-between;
            padding: 40px 60px 60px;
            flex-wrap: wrap;
        }

        .steps-wrapper::before {
            content: "";
            position: absolute;
            top: 32px;
            left: 8%;
            width: 84%;
            height: 4px;
            background: #e5e7eb;
            border-radius: 3px;
            z-index: 0;
        }

        .progress-line {
            position: absolute;
            top: 32px;
            left: 8%;
            height: 4px;
            background: #007bff;
            border-radius: 3px;
            z-index: 1;
            transition: width 0.5s ease;
        }

        .step {
            position: relative;
            text-align: center;
            flex: 1;
            z-index: 2;
        }

        .circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #6c757d;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .step.completed .circle {
            background: #28a745;
            color: #fff;
        }

        .step.completed.final .circle {
            background: #28a745;
            color: #fff;
            box-shadow: 0 0 12px rgba(40, 167, 69, 0.6);
        }

        .step.active .circle {
            background: #007bff;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
        }

        .label {
            margin-top: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            line-height: 1.3em;
        }

        .date-text {
            font-size: 12px;
            color: #666;
            margin-top: 3px;
        }

        @media (max-width: 768px) {
            .steps-wrapper {
                flex-direction: column;
                align-items: center;
                padding: 20px 0;
            }

            .steps-wrapper::before,
            .progress-line {
                display: none;
            }

            .step {
                margin-bottom: 20px;
            }

            .info-section {
                padding: 20px;
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
                switch ($mutasi->jenis_mutasi) {
                    case 'Mutasi Masuk':
                        $steps = [
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
                        $steps = [
                            1 => 'Berkas Diterima',
                            2 => 'Verifikasi & Disposisi Pimpinan',
                            3 => 'Proses Telaah Staff',
                            4 => 'Rekomendasi Melepas Terbit',
                            5 => 'Selesai',
                        ];
                        break;
                    case 'Mutasi Antar OPD':
                        $steps = [
                            1 => 'Berkas Diterima',
                            2 => 'Verifikasi & Disposisi Pimpinan',
                            3 => 'SK Mutasi Terbit',
                            4 => 'Selesai',
                        ];
                        break;
                    default:
                        $steps = [1 => 'Berkas Diterima'];
                }

                $currentStep = (int) ($mutasi->status ?? 1);
                $stepCount = count($steps);
                $progressWidth = $currentStep >= $stepCount ? 84 : (($currentStep - 1) / max($stepCount - 1, 1)) * 84;

            @endphp

            <div class="card card-custom">
                <div class="card-header">Status Mutasi ASN</div>
                <div class="info-section">
                    <div class="row">
                        <div class="info-box">
                            <div class="col">
                                <h5>Informasi Pegawai</h5>
                                <p><strong>Nama Pegawai:</strong> {{ $mutasi->nama }}</p>
                                <p><strong>NIP:</strong> {{ $mutasi->nip }}</p>
                                <p><strong>Pangkat / Golongan:</strong> {{ $mutasi->pangkat }}</p>
                                <p><strong>Jabatan:</strong> {{ $mutasi->jabatan }}</p>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="col">
                                <h5>Informasi Mutasi</h5>
                                <p><strong>Kode Tiket:</strong> {{ $mutasi->kode_tiket }}</p>
                                <p><strong>Jenis Mutasi:</strong> {{ $mutasi->jenis_mutasi }}</p>
                                <p><strong>OPD Asal:</strong> {{ $mutasi->opd_asal }}</p>
                                <p><strong>OPD Tujuan:</strong> {{ $mutasi->opd_tujuan }}</p>
                                <p><strong>Status Saat Ini:</strong> <span class="badge bg-primary">
                                        {{ is_numeric($mutasi->status) ? $steps[$mutasi->status] : ucfirst($mutasi->status) }}
                                    </span> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="steps-wrapper">
                    <div class="progress-line" style="width: {{ $progressWidth }}%;"></div>
                    @foreach ($steps as $i => $label)
                        @php
                            $cls = '';
                            if ($i < $currentStep) {
                                $cls = 'completed';
                            } elseif ($i == $currentStep) {
                                $cls = 'active';
                            }

                            if ($i == $stepCount && $currentStep == $stepCount) {
                                $cls = 'completed final';
                            }

                            $tanggalField = 'tanggal_' . $i;
                            $tanggal = $mutasi->$tanggalField ? $mutasi->$tanggalField->format('d M Y H:i') : null;
                        @endphp

                        <div class="step {{ $cls }}">
                            <div class="circle">{{ $i }}</div>
                            <div class="label">{{ $label }}</div>
                            @if ($tanggal)
                                <div class="date-text">{{ $tanggal }}</div>
                            @endif
                        </div>
                    @endforeach

                </div>

                <div class="card-footer text-center bg-light">
                    <a href="{{ url('/tracking') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        @else
            {{-- Jika tidak ada data --}}
            <div class="card card-custom">
                <div class="card-header text-center">Hasil Pencarian</div>
                <div class="text-center p-5">
                    <i class="fas fa-search fa-3x text-primary mb-3"></i>
                    <h5>Data tidak ditemukan</h5>
                    <p class="text-muted">Pastikan kode tiket dan NIP yang Anda masukkan benar.</p>
                    <a href="{{ url('/tracking') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        @endif
    </div>
@stop
