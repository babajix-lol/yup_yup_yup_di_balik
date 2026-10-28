<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['nis' => 'DEMO001', 'nama' => 'Ahmad Pratama', 'kelas' => 'XI RPL 1'],
            ['nis' => 'DEMO002', 'nama' => 'Siti Rahmawati', 'kelas' => 'XI RPL 1'],
            ['nis' => 'DEMO003', 'nama' => 'Budi Santoso', 'kelas' => 'XI RPL 2'],
            ['nis' => 'DEMO004', 'nama' => 'Dewi Lestari', 'kelas' => 'XI RPL 2'],
            ['nis' => 'DEMO005', 'nama' => 'Rizky Maulana', 'kelas' => 'XI RPL 1'],
            ['nis' => 'DEMO006', 'nama' => 'Putri Anggraini', 'kelas' => 'XI RPL 2'],
            ['nis' => 'DEMO007', 'nama' => 'Fajar Nugraha', 'kelas' => 'XI RPL 1'],
            ['nis' => 'DEMO008', 'nama' => 'Nadia Permata', 'kelas' => 'XI RPL 2'],
            ['nis' => 'DEMO009', 'nama' => 'Andi Setiawan', 'kelas' => 'XI RPL 1'],
            ['nis' => 'DEMO010', 'nama' => 'Rina Marlina', 'kelas' => 'XI RPL 2'],
            ['nis' => 'DEMO011', 'nama' => 'Dimas Saputra', 'kelas' => 'XI RPL 1'],
            ['nis' => 'DEMO012', 'nama' => 'Ayu Safitri', 'kelas' => 'XI RPL 2'],
            ['nis' => 'DEMO013', 'nama' => 'Galih Prakoso', 'kelas' => 'XI RPL 1'],
            ['nis' => 'DEMO014', 'nama' => 'Intan Puspita', 'kelas' => 'XI RPL 2'],
        ];

        $this->db->table('siswa')
            ->whereIn('nis', ['DEMO015', 'DEMO016', 'DEMO017', 'DEMO018', 'DEMO019', 'DEMO020'])
            ->delete();

        foreach ($students as $student) {
            $exists = $this->db->table('siswa')
                ->where('nis', $student['nis'])
                ->countAllResults() > 0;

            if (! $exists) {
                $this->db->table('siswa')->insert($student);
            }
        }
    }
}
