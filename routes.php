<?php

$app->get('/siswa', function ($request, $response, $args) {
    $this->view->render($response, 'siswa.twig');
});

$app->get('/sekolah', function ($request, $response, $args) {
    $this->view->render($response, 'sekolah.twig');
});

$app->get('/data-sekolah', function ($request, $response) use ($db) {
    $data = $db->select('tbl_sekolah', '*');
    return $response->withJson($data);
});


//mengambil seluruh data member dengan filter sekolah
$app->get('/data-member-filter/{id}', function ($request, $response, $args) use ($db) {
    $id = $args['id'];
    $data = $db->select("tbl_member", [
        "[>]tbl_sekolah" => ["id_sekolah" => "id"]
    ], [
        "tbl_member.id",
        "tbl_sekolah.nama_sekolah(nama_sekolah)",
        "tbl_member.nama",
        "tbl_member.email"
    ], [
        "tbl_member.id_sekolah" => $id
    ]);
    if (!empty($data)) {
        return $response->withJson($data); // Mengembalikan data pertama (jika ada)
    } else {
        // Mengembalikan respons kosong atau pesan kesalahan jika data tidak ditemukan
        return $response->withJson(['message' => 'Data tidak ditemukan'], 404);
    }
});

//mengambil seluruh data member dengan nama sekolah sesuai dengan tbl_sekolah
$app->get('/data-member', function ($request, $response) use ($db) {
    $data = $db->select("tbl_member", [
        "[>]tbl_sekolah" => ["id_sekolah" => "id"]
    ], [
        "tbl_member.id",
        "tbl_sekolah.nama_sekolah(nama_sekolah)",
        "tbl_member.nama",
        "tbl_member.email",
        
    ]
);
    return $response->withJson($data);
});

//data form edit siswa
$app->get('/data-member-cek/{id}', function ($request, $response, $args) use ($db) {
    $id = $args['id'];
    $data = $db->select("tbl_member", [
        "[>]tbl_sekolah" => ["id_sekolah" => "id"]
    ], [
        "tbl_member.id",
        "tbl_sekolah.nama_sekolah(nama_sekolah)",
        "tbl_member.nama",
        "tbl_member.email"
    ], [
        "tbl_member.id" => $id // Filter data berdasarkan ID yang diberikan
    ]);

    if (!empty($data)) {
        return $response->withJson($data[0]); // Mengembalikan data pertama (jika ada)
    } else {
        // Mengembalikan respons kosong atau pesan kesalahan jika data tidak ditemukan
        return $response->withJson(['message' => 'Data tidak ditemukan'], 404);
    }
});


//DELETE MEMBER
$app->get('/data-member/{id}', function ($request, $response, $args) use ($db) {
    $id = $args['id'];
    $db->delete("tbl_member", ["id" => $id]);
    
});


// Rute untuk Create (Insert)
$app->post('/create', function ($request, $response) use ($db) {
    $data = $request->getParsedBody(); // Ambil data dari form atau JSON request
    
    $db->insert('tbl_member', $data);
    // return $response->withJson(['message' => 'Data berhasil ditambahkan']);
    return $response->withJson(['message' => 'Data berhasil ditambahkan']);
});


// Rute untuk Update (Edit)
$app->put('/data-member/{id}', function ($request, $response, $args) use ($db) {
    $id = $args['id'];
    $data = $request->getParsedBody(); // Ambil data dari form atau JSON request
    $db->update('tbl_member', $data, ['id' => $id]);
    return $response->withJson(['message' => 'Data berhasil diperbarui']);
});


// Rute untuk Create Sekolah (Insert)
$app->post('/create-sekolah', function ($request, $response) use ($db) {
    $data = $request->getParsedBody(); // Ambil data dari form atau JSON request
    
    $db->insert('tbl_sekolah', $data);
    // return $response->withJson(['message' => 'Data berhasil ditambahkan']);
    return $response->withJson(['message' => 'Data berhasil ditambahkan']);
});

//data form edit siswa
$app->get('/data-sekolah-cek/{id}', function ($request, $response, $args) use ($db) {
    $id = $args['id'];
    $data = $db->select("tbl_sekolah",["id", "nama_sekolah", "alamat"], ["id" => $id]);

    if (!empty($data)) {
        return $response->withJson($data[0]); // Mengembalikan data pertama (jika ada)
    } else {
        // Mengembalikan respons kosong atau pesan kesalahan jika data tidak ditemukan
        return $response->withJson(['message' => 'Data tidak ditemukan'], 404);
    }
});

// Rute untuk Update Sekolah (Edit)
$app->put('/data-sekolah/update/{id}', function ($request, $response, $args) use ($db) {
    $id = $args['id'];
    $data = $request->getParsedBody(); // Ambil data dari form atau JSON request
    $db->update('tbl_sekolah', $data, ['id' => $id]);
    return $response->withJson(['message' => 'Data berhasil diperbarui']);
});


//DELETE SEKOLAH
$app->get('/data-sekolah/{id}', function ($request, $response, $args) use ($db) {
    $id = $args['id'];
    $db->delete("tbl_sekolah", ["id" => $id]);
    
});