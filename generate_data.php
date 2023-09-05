<?php
require 'vendor/autoload.php'; // Sesuaikan dengan lokasi autoload.php Anda
require 'helper.php';


// Loop untuk mengisi tabel dengan data acak
for ($i = 1; $i <= 100; $i++) {
    $data = [
        'nama_sekolah' => "Sekolah Negeri " . $i,
        'alamat' => "Jl. Raya " . $i,
    ];

    $db->insert('tbl_sekolah', $data);
}

echo 'Data berhasil di-generate.';
