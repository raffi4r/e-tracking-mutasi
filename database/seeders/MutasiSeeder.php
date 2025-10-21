<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $jenisMutasi = [
            'Mutasi Masuk',
            'Mutasi Keluar',
            'Mutasi Antar OPD'
        ];

        $pangkatList = ['Ia', 'Ib', 'Ic', 'Id', 'IIa', 'IIb', 'IIc', 'IId', 'IIIa', 'IIIb', 'IIIc', 'IIId', 'IVa', 'IVb', 'IVc', 'IVd', 'IVe'];

        $opdList = [
            'Dinas Pendidikan',
            'Dinas Kesehatan',
            'Dinas Kominfo',
            'Dinas PU',
            'Dinas Perhubungan',
            'Dinas Sosial',
            'Bappeda',
            'Inspektorat',
            'BKPSDM',
            'Sekretariat Daerah'
        ];

        $rows = [];

        for ($i = 0; $i < 50; $i++) {
            // Tanggal lahir acak (1970-2005)
            $birthYear  = rand(1970, 2005);
            $birthMonth = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $birthDay   = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);

            // TMT / tahun pengangkatan dan bulan
            $tmtYear  = rand(2000, 2015);
            $tmtMonth = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);

            // Jenis kelamin 1 digit (1 laki-laki, 2 perempuan)
            $gender = (string) rand(1, 2);

            // Nomor urut 3 digit
            $seq = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);

            // Gabungkan jadi NIP (18 digit)
            $nip = "{$birthYear}{$birthMonth}{$birthDay}{$tmtYear}{$tmtMonth}{$gender}{$seq}";

            // Safety check: pastikan 18 digit (seharusnya selalu 18)
            if (strlen($nip) !== 18) {
                $nip = substr(str_pad($nip, 18, '0', STR_PAD_LEFT), 0, 18);
            }

            // Data lain
            $kodeTiket = 'MTX' . strtoupper(Str::random(6));
            $nama = $faker->name();
            // no_hp: mulai dengan 08 + 9 digit => total 11 digit (masuk batas 10-15)
            $no_hp = '08' . str_pad(rand(100000000, 999999999), 9, '0', STR_PAD_LEFT);
            $pangkat = $pangkatList[array_rand($pangkatList)];
            $jabatan = $faker->jobTitle();
            $opd_asal = $opdList[array_rand($opdList)];
            // pastikan opd_tujuan tidak selalu sama
            do {
                $opd_tujuan = $opdList[array_rand($opdList)];
            } while ($opd_tujuan === $opd_asal);
            $jenis = $jenisMutasi[array_rand($jenisMutasi)];
            $status = rand(1, 4); // 1..4 sesuai mapping status
            $tanggal_diterima = Carbon::now()->subDays(rand(1, 90));
            $tanggal_selesai = in_array($status, [3, 4]) ? $tanggal_diterima->copy()->addDays(rand(3, 30)) : null;
            $keterangan = $faker->sentence(rand(6, 12));

            $rows[] = [
                'kode_tiket'      => $kodeTiket,
                'nip'             => $nip,
                'nama'            => $nama,
                'no_hp'           => $no_hp,
                'pangkat'         => $pangkat,
                'jabatan'         => $jabatan,
                'opd_asal'        => $opd_asal,
                'opd_tujuan'      => $opd_tujuan,
                'jenis_mutasi'    => $jenis,
                'status'          => $status,
                'tanggal_diterima' => $tanggal_diterima,
                'tanggal_selesai' => $tanggal_selesai,
                'keterangan'      => $keterangan,
                'created_at'      => $tanggal_diterima,
                'updated_at'      => $tanggal_diterima,
            ];
        }

        DB::table('mutasis')->insert($rows);
    }
}
