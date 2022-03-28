<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('settings')->insert([
            'jam_buka' => '08:00:00',
            'jam_tutup' => '09:00:00'
        ]);
        DB::table('kelas')->insert([
            'id_kelas' => 'XIIB',
            'nama' => 'XIIB'
        ]);
        DB::table('siswa')->insert([
            'nis' => 123456,
            'nama' => 'Shabrina Ayyunani Hasibuan',
            'id_kelas' => 'XIIB',
            'password' => 'habib18102002',
            'ip' => '::1',
            'wajah' => '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'
        ]);
    }
}
