<?php
require 'vendor/autoload.php'; // Sesuaikan dengan lokasi autoload.php Anda
require 'helper.php';


// Inisialisasi Faker
$faker = Faker\Factory::create('id_ID');

// Loop untuk mengisi tabel dengan data anggota menggunakan Faker
for ($i = 1; $i <= 1000; $i++) {
    $nama = $faker->name;
    $email = $faker->email;

    // Menghasilkan id_sekolah secara acak
    $id_sekolah = mt_rand(1, 100); // Sesuaikan dengan jumlah sekolah yang tersedia

    $data = [
        'id_sekolah' => $id_sekolah,
        'nama' => $nama,
        'email' => $email,
    ];

    $db->insert('tbl_member', $data);
}

echo 'Data anggota berhasil di-generate dengan Faker.';