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
            'ip' => '::1'
        ]);
    }
}
