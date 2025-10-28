<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mutasi;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mutasi.index');
    }

    public function data()
    {
        $mutasi = Mutasi::select('id', 'kode_tiket', 'no_hp', 'nip', 'nama', 'jenis_mutasi', 'status', 'created_at');

        return DataTables::of($mutasi)
            ->addIndexColumn()
            ->editColumn('kode_tiket', function ($row) {
                return '
                <div class="d-flex align-items-center">
                    <span class="mr-2">' . $row->kode_tiket . '</span>
                    <button class="btn btn-sm btn-outline-primary copy-btn" data-code="' . $row->kode_tiket . '">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            ';
            })
            ->editColumn('no_hp', function ($row) {
                // ubah nomor 0852... jadi 62852...
                $no_hp = preg_replace('/^0/', '62', $row->no_hp);
                $no_hp = preg_replace('/^62{2,}/', '62', $no_hp);

                return '
                <div class="d-flex align-items-center justify-content-center">
                    <span class="mr-2">' . $row->no_hp . '</span>
                    <button class="btn btn-sm btn-outline-primary copy-btn" data-code="' . $row->no_hp . '">
                        <i class="fas fa-copy"></i>
                    </button>
                    <a href="https://wa.me/' . $no_hp . '" target="_blank" class="btn btn-sm btn-success ml-2">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            ';
            })
            ->addColumn('status', function ($row) {
                $statusSteps = [];

                switch ($row->jenis_mutasi) {
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
                            5 => 'Selesai'
                        ];
                        break;
                    case 'Mutasi Antar OPD':
                        $statusSteps = [
                            1 => 'Berkas Diterima',
                            2 => 'Verifikasi & Disposisi Pimpinan',
                            3 => 'SK Mutasi Terbit',
                            4 => 'Selesai'
                        ];
                        break;
                }

                $currentIndex = $row->status; // status disimpan sebagai angka (1,2,3,...)
                $currentLabel = $statusSteps[$currentIndex] ?? 'Belum Ditetapkan';

                $percentage = 0;
                if ($currentIndex && count($statusSteps) > 1) {
                    $percentage = round(($currentIndex / count($statusSteps)) * 100);
                }

                $badgeClass = 'secondary';
                if ($percentage < 40) $badgeClass = 'warning';
                elseif ($percentage < 100) $badgeClass = 'info';
                elseif ($percentage >= 100) $badgeClass = 'success';

                return "
                    <div class='text-center'>
                        <span class='badge bg-{$badgeClass} d-block'>$currentLabel</span>
                        <small class='badge bg-{$badgeClass}'>{$percentage}%</small>
                    </div>
                    ";
            })
            ->addColumn('aksi', function ($row) {
                return '
                <div class="btn-group">
                    <button class="btn btn-sm btn-info detail-btn" data-id="' . $row->id . '" title="Detail">
                        <i class="fas fa-eye"></i>
                    </button>
                    <a href="' . route('mutasi.edit', $row->id) . '" class="btn btn-sm btn-warning" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            ';
            })
            ->rawColumns(['kode_tiket', 'no_hp', 'nip', 'status', 'aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mutasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'pangkat' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'opd_asal' => 'required|string|max:100',
            'opd_tujuan' => 'required|string|max:100',
            'jenis_mutasi' => 'required|in:Mutasi Masuk,Mutasi Keluar,Mutasi Antar OPD',
        ]);

        $kodeTiket = 'MTX' . strtoupper(substr(uniqid(), -6));

        Mutasi::create([
            'kode_tiket' => $kodeTiket,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'pangkat' => $request->pangkat,
            'jabatan' => $request->jabatan,
            'opd_asal' => $request->opd_asal,
            'opd_tujuan' => $request->opd_tujuan,
            'jenis_mutasi' => $request->jenis_mutasi,
            'status' => 1,
            'tanggal_1' => now()
        ]);

        return redirect()->route('mutasi.index')->with('success', 'Data mutasi berhasil disimpan.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mutasi = Mutasi::findOrFail($id);
        return response()->json($mutasi);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mutasi = Mutasi::findOrFail($id);
        return view('mutasi.edit', compact('mutasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mutasi = Mutasi::findOrFail($id);

        // validasi
        $request->validate([
            'nip' => 'required',
            'nama' => 'required',
            'no_hp' => 'required',
            'pangkat' => 'required',
            'jabatan' => 'required',
            'opd_asal' => 'required',
            'opd_tujuan' => 'required',
            'jenis_mutasi' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        // update hanya kolom tertentu (kode_tiket tidak termasuk)
        $mutasi->update($request->only([
            'nip',
            'nama',
            'no_hp',
            'pangkat',
            'jabatan',
            'opd_asal',
            'opd_tujuan',
            'jenis_mutasi',
            'keterangan'
        ]));

        return redirect()->route('mutasi.index')->with('success', 'Data mutasi berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Mutasi::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, $id)
    {
        // mapping maksimal step per jenis mutasi (sesuaikan jika berubah)
        $statusMap = [
            'Mutasi Masuk'    => 7, // 1..7
            'Mutasi Keluar'   => 5, // 1..5
            'Mutasi Antar OPD' => 4, // 1..4
        ];

        $request->validate([
            'status' => 'required|integer|min:1|max:7',
        ]);

        $newStatus = (int) $request->status;

        $mutasi = Mutasi::findOrFail($id);

        // tentukan batas maksimal step untuk jenis mutasi ini
        $jenis = $mutasi->jenis_mutasi;
        $maxAllowed = $statusMap[$jenis] ?? 7; // fallback 7

        if ($newStatus < 1 || $newStatus > $maxAllowed) {
            return response()->json([
                'success' => false,
                'message' => "Status harus antara 1 dan {$maxAllowed} untuk jenis mutasi '{$jenis}'."
            ], 422);
        }

        $oldStatus = (int) ($mutasi->status ?? 1);

        DB::transaction(function () use ($mutasi, $oldStatus, $newStatus, $maxAllowed) {
            // set status baru
            $mutasi->status = $newStatus;

            // jika naik (new > old): isi tanggal untuk step yang baru dicapai (jika belum ada)
            if ($newStatus > $oldStatus) {
                for ($s = $oldStatus + 1; $s <= $newStatus; $s++) {
                    $field = 'tanggal_' . $s;
                    if (Schema::hasColumn('mutasis', $field) && is_null($mutasi->$field)) {
                        $mutasi->$field = now();
                    }
                }
            }

            // jika turun (new < old): hapus/clear tanggal langkah yang lebih besar dari newStatus
            if ($newStatus < $oldStatus) {
                for ($s = $newStatus + 1; $s <= $maxAllowed; $s++) {
                    $field = 'tanggal_' . $s;
                    if (Schema::hasColumn('mutasis', $field) && !is_null($mutasi->$field)) {
                        $mutasi->$field = null;
                    }
                }
            }

            // jika sama, tidak melakukan perubahan tanggal
            $mutasi->save();
        });

        return response()->json([
            'success' => true,
            'message' => 'Status dan tanggal step berhasil diperbarui'
        ]);
    }

    public function tracking()
    {
        return view('tracking.tracking');
    }

    public function trackingResult(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required',
            'nip' => 'required',
        ]);

        $mutasi = Mutasi::where('kode_tiket', $request->kode_tiket)
            ->where('nip', $request->nip)
            ->first();

        return view('tracking.tracking_result', compact('mutasi'));
    }
}
