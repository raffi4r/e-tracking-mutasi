@extends('adminlte::page')

@section('classes_body', 'sidebar-collapse')

@section('title', 'Tambah Mutasi')

@section('content_header')
    <h1 class="mb-3">Tambah Data Mutasi ASN</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('mutasi.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Kolom kiri -->
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="nip">NIP</label>
                            <input type="number" name="nip" id="nip"
                                class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}"
                                placeholder="Masukkan NIP">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" name="no_hp" id="no_hp"
                                class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}"
                                placeholder="Masukkan nomor HP aktif">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ✅ Dropdown Pangkat/Golongan --}}
                        <div class="form-group mb-3">
                            <label for="pangkat">Pangkat / Golongan</label>
                            <div class="position-relative">
                                <select name="pangkat" id="pangkat"
                                    class="form-control @error('pangkat') is-invalid @enderror"
                                    style="appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                                    <option value="">-- Pilih Pangkat / Golongan --</option>
                                    <option value="Ia" {{ old('pangkat') == 'Ia' ? 'selected' : '' }}>I/a (Juru Muda)
                                    </option>
                                    <option value="Ib" {{ old('pangkat') == 'Ib' ? 'selected' : '' }}>I/b (Juru Muda
                                        Tingkat I)
                                    </option>
                                    <option value="Ic" {{ old('pangkat') == 'Ic' ? 'selected' : '' }}>I/c (Juru)
                                    </option>
                                    <option value="Id" {{ old('pangkat') == 'Id' ? 'selected' : '' }}>I/d (Juru Tingkat
                                        I)
                                    </option>
                                    <option value="IIa" {{ old('pangkat') == 'IIa' ? 'selected' : '' }}>II/a (Pengatur
                                        Muda)
                                    </option>
                                    <option value="IIb" {{ old('pangkat') == 'IIb' ? 'selected' : '' }}>II/b (Pengatur
                                        Muda Tingkat I)
                                    </option>
                                    <option value="IIc" {{ old('pangkat') == 'IIc' ? 'selected' : '' }}>II/c (Pengatur)
                                    </option>
                                    <option value="IId" {{ old('pangkat') == 'IId' ? 'selected' : '' }}>II/d (Pengatur
                                        Tingkat I)
                                    </option>
                                    <option value="IIIa" {{ old('pangkat') == 'IIIa' ? 'selected' : '' }}>III/a (Penata
                                        Muda)
                                    </option>
                                    <option value="IIIb" {{ old('pangkat') == 'IIIb' ? 'selected' : '' }}>III/b (Penata
                                        Muda Tingkat I)
                                    </option>
                                    <option value="IIIc" {{ old('pangkat') == 'IIIc' ? 'selected' : '' }}>III/c (Penata)
                                    </option>
                                    <option value="IIId" {{ old('pangkat') == 'IIId' ? 'selected' : '' }}>III/d (Penata
                                        Tingkat I)
                                    </option>
                                    <option value="IVa" {{ old('pangkat') == 'IVa' ? 'selected' : '' }}>IV/a (Pembina)
                                    </option>
                                    <option value="IVb" {{ old('pangkat') == 'IVb' ? 'selected' : '' }}>IV/b (Pembina
                                        Tingkat I)
                                    </option>
                                    <option value="IVc" {{ old('pangkat') == 'IVc' ? 'selected' : '' }}>IV/c (Pembina
                                        Utama Muda)
                                    </option>
                                    <option value="IVd" {{ old('pangkat') == 'IVd' ? 'selected' : '' }}>IV/d (Pembina
                                        Utama Madya)
                                    </option>
                                    <option value="IVe" {{ old('pangkat') == 'IVe' ? 'selected' : '' }}>IV/e (Pembina
                                        Utama)
                                    </option>
                                </select>
                            </div>
                            @error('pangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan"
                                class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}"
                                placeholder="Masukkan jabatan terakhir">
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
                                class="form-control @error('opd_asal') is-invalid @enderror" value="{{ old('opd_asal') }}"
                                placeholder="Masukkan nama OPD asal">
                            @error('opd_asal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="opd_tujuan">OPD Tujuan</label>
                            <input type="text" name="opd_tujuan" id="opd_tujuan"
                                class="form-control @error('opd_tujuan') is-invalid @enderror"
                                value="{{ old('opd_tujuan') }}" placeholder="Masukkan nama OPD tujuan">
                            @error('opd_tujuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Mutasi --}}
                        <div class="form-group mb-3">
                            <label for="jenis_mutasi">Jenis Mutasi</label>
                            <div class="position-relative">
                                <select name="jenis_mutasi" id="jenis_mutasi"
                                    class="form-control @error('jenis_mutasi') is-invalid @enderror"
                                    style="appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                                    <option value="">-- Pilih Jenis Mutasi --</option>
                                    <option value="Mutasi Masuk"
                                        {{ old('jenis_mutasi') == 'Mutasi Masuk' ? 'selected' : '' }}>Mutasi Masuk</option>
                                    <option value="Mutasi Keluar"
                                        {{ old('jenis_mutasi') == 'Mutasi Keluar' ? 'selected' : '' }}>Mutasi Keluar
                                    </option>
                                    <option value="Mutasi Antar OPD"
                                        {{ old('jenis_mutasi') == 'Mutasi Antar OPD' ? 'selected' : '' }}>Mutasi Antar OPD
                                    </option>
                                </select>
                            </div>
                            @error('jenis_mutasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="keterangan">Keterangan (Opsional)</label>
                            <textarea name="keterangan" id="keterangan" rows="5"
                                class="form-control @error('keterangan') is-invalid @enderror" placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan') }}</textarea>
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
                        <i class="fas fa-save"></i> Simpan
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
            // aturan validasi untuk setiap field
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
                minlength: function(min) {
                    return `Minimal ${min} karakter.`
                },
                maxlength: function(max) {
                    return `Maksimal ${max} karakter.`
                },
            };

            // fungsi cek validasi satu field
            function validateField(el) {
                const name = el.attr('name');
                const val = el.val().trim();
                const rule = rules[name];
                if (!rule) return; // skip field yang tidak punya aturan

                let error = '';

                if (rule.required && !val) {
                    error = messages.required;
                } else if (rule.numeric && val && !/^[0-9]+$/.test(val)) {
                    error = messages.numeric;
                } else if (rule.minlength && val.length < rule.minlength) {
                    error = messages.minlength(rule.minlength);
                } else if (rule.maxlength && val.length > rule.maxlength) {
                    error = messages.maxlength(rule.maxlength);
                }

                // tampilkan hasil validasi
                el.removeClass('is-valid is-invalid');
                el.next('.invalid-feedback').remove();

                if (error) {
                    el.addClass('is-invalid');
                    el.after(`<div class="invalid-feedback">${error}</div>`);
                } else {
                    el.addClass('is-valid');
                }
            }

            // event: ketik, pindah, ubah dropdown
            $('input, select, textarea').on('keyup change blur', function() {
                validateField($(this));
            });

            // event saat form disubmit
            $('form').on('submit', function(e) {
                let isValid = true;

                $('input, select, textarea').each(function() {
                    validateField($(this));
                    if ($(this).hasClass('is-invalid')) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Periksa kembali isian Anda. Masih ada field yang belum valid.',
                    });
                }
            });
        });
    </script>
@stop
