@extends('adminlte::page')

@section('classes_body', 'sidebar-collapse')

@section('title', 'Edit Mutasi')

@section('content_header')
    <h1 class="mb-3">Edit Data Mutasi ASN</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('mutasi.update', $mutasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="kode_tiket">Kode Tiket</label>
                            <input type="text" name="kode_tiket" id="kode_tiket" class="form-control"
                                value="{{ $mutasi->kode_tiket }}" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nip">NIP</label>
                            <input type="number" name="nip" id="nip"
                                class="form-control @error('nip') is-invalid @enderror"
                                value="{{ old('nip', $mutasi->nip) }}" placeholder="Masukkan NIP">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $mutasi->nama) }}" placeholder="Masukkan nama lengkap">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" name="no_hp" id="no_hp"
                                class="form-control @error('no_hp') is-invalid @enderror"
                                value="{{ old('no_hp', $mutasi->no_hp) }}" placeholder="Masukkan nomor HP aktif">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ✅ Dropdown Pangkat/Golongan --}}
                        <div class="form-group mb-3">
                            <label for="pangkat">Pangkat / Golongan</label>
                            <select name="pangkat" id="pangkat"
                                class="form-control @error('pangkat') is-invalid @enderror">
                                <option value="">-- Pilih Pangkat / Golongan --</option>
                                @php
                                    $pangkats = [
                                        'Ia' => 'I/a (Juru Muda)',
                                        'Ib' => 'I/b (Juru Muda Tingkat I)',
                                        'Ic' => 'I/c (Juru)',
                                        'Id' => 'I/d (Juru Tingkat I)',
                                        'IIa' => 'II/a (Pengatur Muda)',
                                        'IIb' => 'II/b (Pengatur Muda Tingkat I)',
                                        'IIc' => 'II/c (Pengatur)',
                                        'IId' => 'II/d (Pengatur Tingkat I)',
                                        'IIIa' => 'III/a (Penata Muda)',
                                        'IIIb' => 'III/b (Penata Muda Tingkat I)',
                                        'IIIc' => 'III/c (Penata)',
                                        'IIId' => 'III/d (Penata Tingkat I)',
                                        'IVa' => 'IV/a (Pembina)',
                                        'IVb' => 'IV/b (Pembina Tingkat I)',
                                        'IVc' => 'IV/c (Pembina Utama Muda)',
                                        'IVd' => 'IV/d (Pembina Utama Madya)',
                                        'IVe' => 'IV/e (Pembina Utama)',
                                    ];
                                @endphp
                                @foreach ($pangkats as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('pangkat', $mutasi->pangkat) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan"
                                class="form-control @error('jabatan') is-invalid @enderror"
                                value="{{ old('jabatan', $mutasi->jabatan) }}" placeholder="Masukkan jabatan terakhir">
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom kanan -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="opd_asal">OPD Asal</label>
                            <input type="text" name="opd_asal" id="opd_asal"
                                class="form-control @error('opd_asal') is-invalid @enderror"
                                value="{{ old('opd_asal', $mutasi->opd_asal) }}" placeholder="Masukkan nama OPD asal">
                            @error('opd_asal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="opd_tujuan">OPD Tujuan</label>
                            <input type="text" name="opd_tujuan" id="opd_tujuan"
                                class="form-control @error('opd_tujuan') is-invalid @enderror"
                                value="{{ old('opd_tujuan', $mutasi->opd_tujuan) }}"
                                placeholder="Masukkan nama OPD tujuan">
                            @error('opd_tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Mutasi --}}
                        <div class="form-group mb-3">
                            <label for="jenis_mutasi">Jenis Mutasi</label>
                            <select name="jenis_mutasi" id="jenis_mutasi"
                                class="form-control @error('jenis_mutasi') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Mutasi --</option>
                                <option value="Mutasi Masuk"
                                    {{ old('jenis_mutasi', $mutasi->jenis_mutasi) == 'Mutasi Masuk' ? 'selected' : '' }}>
                                    Mutasi Masuk
                                </option>
                                <option value="Mutasi Keluar"
                                    {{ old('jenis_mutasi', $mutasi->jenis_mutasi) == 'Mutasi Keluar' ? 'selected' : '' }}>
                                    Mutasi Keluar
                                </option>
                                <option value="Mutasi Antar OPD"
                                    {{ old('jenis_mutasi', $mutasi->jenis_mutasi) == 'Mutasi Antar OPD' ? 'selected' : '' }}>
                                    Mutasi Antar OPD
                                </option>
                            </select>
                            @error('jenis_mutasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="keterangan">Keterangan (Opsional)</label>
                            <textarea name="keterangan" id="keterangan" rows="5"
                                class="form-control @error('keterangan') is-invalid @enderror" placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan', $mutasi->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('mutasi.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    &nbsp;&nbsp;
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        select.form-control {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.375rem;
            background-color: #fff;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            const rules = {
                nip: {
                    required: true,
                    numeric: true,
                    minlength: 18,
                    maxlength: 18
                },
                nama: {
                    required: true,
                    minlength: 3
                },
                no_hp: {
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
                pangkat: {
                    required: true
                },
                jabatan: {
                    required: true,
                    minlength: 3
                },
                opd_asal: {
                    required: true
                },
                opd_tujuan: {
                    required: true
                },
                jenis_mutasi: {
                    required: true
                }
            };

            const messages = {
                required: 'Field ini wajib diisi.',
                numeric: 'Harus berupa angka.',
                minlength: min => `Minimal ${min} karakter.`,
                maxlength: max => `Maksimal ${max} karakter.`
            };

            function validateField(el) {
                const name = el.attr('name');
                const val = el.val().trim();
                const rule = rules[name];
                if (!rule) return;

                let error = '';
                if (rule.required && !val) error = messages.required;
                else if (rule.numeric && val && !/^[0-9]+$/.test(val)) error = messages.numeric;
                else if (rule.minlength && val.length < rule.minlength) error = messages.minlength(rule.minlength);
                else if (rule.maxlength && val.length > rule.maxlength) error = messages.maxlength(rule.maxlength);

                el.removeClass('is-valid is-invalid');
                el.next('.invalid-feedback').remove();

                if (error) {
                    el.addClass('is-invalid');
                    el.after(`<div class="invalid-feedback">${error}</div>`);
                } else {
                    el.addClass('is-valid');
                }
            }

            $('input, select, textarea').on('keyup change blur', function() {
                validateField($(this));
            });

            $('form').on('submit', function(e) {
                let isValid = true;
                $('input, select, textarea').each(function() {
                    validateField($(this));
                    if ($(this).hasClass('is-invalid')) isValid = false;
                });

                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Masih ada field yang belum valid. Coba periksa kembali.',
                    });
                }
            });
        });
    </script>
@stop
