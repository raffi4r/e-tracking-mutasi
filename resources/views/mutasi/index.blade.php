@extends('adminlte::page')

@section('classes_body', 'sidebar-collapse')

@section('title', 'Data Mutasi')

@section('content_header')
    <h1 class="mb-3">List Mutasi</h1>
@stop

@section('content')
    <a href="{{ route('mutasi.create') }}" class="btn btn-primary mb-3">+ Input Mutasi</a>
    <div class="card">
        <div class="card-body">
            <table id="mutasiTable" class="table table-bordered table-striped table-hover w-100">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Kode Tiket</th>
                        <th>No HP</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')

    <!-- DataTables CSS (Bootstrap 5 compatible) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- JS dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS (Bootstrap 5 compatible) -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            const table = $('#mutasiTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('mutasi.data') }}",
                responsive: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '5%'
                    },
                    {
                        data: 'kode_tiket',
                        name: 'kode_tiket',
                        className: 'text-center'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                        className: 'text-center'
                    },
                    {
                        data: 'nip',
                        name: 'nip',
                        className: 'text-center'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jenis_mutasi',
                        name: 'jenis_mutasi',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]

            });

            // 📋 Tombol Copy (untuk kode tiket, NIP dan no hp)
            $(document).on('click', '.detail-btn', function() {
                const id = $(this).data('id');

                $.get(`/mutasi/${id}`, function(res) {

                    // Mapping status berdasarkan jenis mutasi
                    const statusOptionsMap = {
                        'Mutasi Masuk': [{
                                value: 1,
                                text: 'Berkas Diterima'
                            },
                            {
                                value: 2,
                                text: 'Verifikasi & Disposisi Pimpinan'
                            },
                            {
                                value: 3,
                                text: 'Proses Telaah Staff'
                            },
                            {
                                value: 4,
                                text: 'Rekomendasi Menerima Terbit'
                            },
                            {
                                value: 5,
                                text: 'Nota Usul'
                            },
                            {
                                value: 6,
                                text: 'SK Penempatan Terbit'
                            },
                            {
                                value: 7,
                                text: 'Selesai'
                            }

                        ],
                        'Mutasi Keluar': [{
                                value: 1,
                                text: 'Berkas Diterima'
                            },
                            {
                                value: 2,
                                text: 'Verifikasi & Disposisi Pimpinan'
                            },
                            {
                                value: 3,
                                text: 'Proses Telaah Staff'
                            },
                            {
                                value: 4,
                                text: 'Rekomendasi Melepas Terbit'
                            },
                            {
                                value: 5,
                                text: 'Selesai'
                            }
                        ],
                        'Mutasi Antar OPD': [{
                                value: 1,
                                text: 'Berkas Diterima'
                            },
                            {
                                value: 2,
                                text: 'Verifikasi & Disposisi Pimpinan'
                            },
                            {
                                value: 3,
                                text: 'SK Mutasi Terbit'
                            },
                            {
                                value: 4,
                                text: 'Selesai'
                            }
                        ]
                    };

                    const jenis = res.jenis_mutasi || 'default';
                    const statusList = statusOptionsMap[jenis] || statusOptionsMap['default'];

                    // buat dropdown status (value = angka, text = label)
                    const statusDropdown = `
            <select id="statusSelect" class="form-control form-control-sm mt-1">
                ${statusList.map(opt => `
                                                    <option value="${opt.value}" ${opt.value == res.status ? 'selected' : ''}>
                                                        ${opt.text}
                                                    </option>
                                                `).join('')}
            </select>
        `;

                    // ubah pangkat dari singkatan ke format lengkap
                    const pangkatMap = {
                        'Ia': 'Juru Muda (I/a)',
                        'Ib': 'Juru Muda Tingkat I (I/b)',
                        'Ic': 'Juru (I/c)',
                        'Id': 'Juru Tingkat I (I/d)',
                        'IIa': 'Pengatur Muda (II/a)',
                        'IIb': 'Pengatur Muda Tingkat I (II/b)',
                        'IIc': 'Pengatur (II/c)',
                        'IId': 'Pengatur Tingkat I (II/d)',
                        'IIIa': 'Penata Muda (III/a)',
                        'IIIb': 'Penata Muda Tingkat I (III/b)',
                        'IIIc': 'Penata (III/c)',
                        'IIId': 'Penata Tingkat I (III/d)',
                        'IVa': 'Pembina (IV/a)',
                        'IVb': 'Pembina Tingkat I (IV/b)',
                        'IVc': 'Pembina Utama Muda (IV/c)',
                        'IVd': 'Pembina Utama Madya (IV/d)',
                        'IVe': 'Pembina Utama (IV/e)',
                    };

                    const modalContent = `
            <div class="detail-container text-left">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Kode Tiket:</strong><br>${res.kode_tiket}</p>
                        <p><strong>Nama:</strong><br>${res.nama}</p>
                        <p><strong>NIP:</strong><br>${res.nip}</p>
                        <p><strong>No HP:</strong><br>${res.no_hp}</p>
                        <p><strong>Pangkat:</strong><br>${pangkatMap[res.pangkat] || res.pangkat}</p>
                        <p><strong>Jabatan:</strong><br>${res.jabatan}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>OPD Asal:</strong><br>${res.opd_asal}</p>
                        <p><strong>OPD Tujuan:</strong><br>${res.opd_tujuan}</p>
                        <p><strong>Jenis Mutasi:</strong><br>${res.jenis_mutasi}</p>
                        <p><strong>Status:</strong><br>${statusDropdown}</p>
                        <p><strong>Keterangan:</strong><br>${res.keterangan ?? '-'}</p>
                    </div>
                </div>
            </div>
        `;

                    Swal.fire({
                        title: 'Detail Mutasi',
                        html: modalContent,
                        width: '70%',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan Status',
                        cancelButtonText: 'Tutup',
                        customClass: {
                            htmlContainer: 'text-left'
                        },
                        didOpen: () => {
                            $('.swal2-html-container').css({
                                'max-height': '420px',
                                'overflow-y': 'auto',
                                'text-align': 'left',
                                'padding': '5px 15px'
                            });
                        },
                        preConfirm: () => {
                            const newStatus = $('#statusSelect').val(); // nilai angka
                            return $.ajax({
                                url: `/mutasi/${id}/status`,
                                type: 'PUT',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    status: newStatus
                                },
                                success: function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: 'Status berhasil diperbarui',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    $('#mutasiTable').DataTable().ajax
                                        .reload();
                                },
                                error: function() {
                                    Swal.fire('Gagal',
                                        'Tidak dapat memperbarui status',
                                        'error');
                                }
                            });
                        }
                    });
                });
            });

            // 📋 Tombol Copy (untuk kode tiket dan no hp)
            $(document).on('click', '.copy-btn', function() {
                const text = $(this).data('code');
                navigator.clipboard.writeText(text);
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    title: 'Disalin ke clipboard!',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
            });

            // ❌ Tombol Delete
            $(document).on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data ini tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/mutasi/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                Swal.fire('Terhapus!', 'Data berhasil dihapus.',
                                    'success');
                                table.ajax.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop
