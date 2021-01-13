<?php

namespace App\Controllers;

use App\Models\MovieModel;
use Config\Validation;

class Movie extends BaseController
{

    protected $movieModel;
    public function __construct()
    {
        //koneksi ke database
        $this->db = \Config\Database::connect();
        //
        $this->movieModel = new MovieModel();
    }
    public function index()
    {
        $data =
            [
                'title' => 'Daftar Film',
                'movie' => $this->movieModel->getMovie()
            ];
        return view('Movie/index', $data);
    }
    public function detail($slug)
    {
        $data = [
            'title' => 'Detail',
            'detail' => $this->movieModel->getMovie($slug)
        ];
        if (empty($data['detail'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Film ' . $slug . ' tidak ditemukan!');
        }
        return view('Movie/detail', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Buat Data Film Baru',
            'validation' => \Config\Services::validation()
        ];
        return view('Movie/create', $data);
    }
    public function save()
    {
        if (!$this->validate([
            //didapatkan dari name pada file create
            'judul' => [
                'rules' => 'required|is_unique[film.judul]',
                'errors' => [
                    'required' => '{field} harus diisi!',
                    'is_unique' => '{field} sudah ada silahkan pilih {field} lain!'
                ]
            ],
            'cover' => [
                //batas maksimal upload file php
                // uploaded[cover]
                'rules' => 'max_size[cover,10240]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Belum ada {field} yang di pilih!',
                    'mime_in' => 'extensi file salah!',
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \config\Services::validation();
            // return redirect()->to('/Movie/create')->withInput()->with('validation', $validation);
            return redirect()->to('/Movie/create')->withInput();
        }
        // dd('berhasil');
        //kelola gambar
        //ambil gambar simpan ke variabel
        $gambar = $this->request->getFile('cover');
        //apakah tidak ada file diupload
        if ($gambar->getError() == 4) {
            $namaGambarRandom = 'default.jpg';
        } else {
            //generate nama sampul
            $namaGambarRandom = $gambar->getRandomName();
            //pindahkan file ke folder (img(langsung ke folder public),parameter untuk gambar random)
            $gambar->move('img', $namaGambarRandom);
            //ambil nama file
            // $namaGambar = $gambar->getName();
            // dd($gambar);
        }
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->movieModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'sutradara' => $this->request->getVar('sutradara'),
            'rumahproduksi' => $this->request->getVar('rumahproduksi'),
            'cover' => $namaGambarRandom
        ]);
        session()->setFlashData('pesan', ' data berhasil ditambahkan');
        return redirect()->to('/movie');
    }
    public function delete($id)
    { //fungsi sql di sambungkan dulu ke database mysql di constructor
        $sqla = ("ALTER TABLE film DROP id");
        $sqlb = ("ALTER TABLE film ADD  id INT( 11 ) NOT NULL AUTO_INCREMENT FIRST ,ADD KEY (id)");

        //cari gambar berdasarkan id
        //buat variabel untuk menyimpan nilaiya dulu
        $gambarHapus = $this->movieModel->find($id);
        //cek apakah gambar yang digunakan default.jpg
        if ($gambarHapus['cover'] != 'default/jpg') {
            if ($this->movieModel->delete($id)) {
                //menjalankan query database
                $this->db->query($sqla);
                $this->db->query($sqlb);
            }
            session()->setFlashData('pesan', 'data berhasil dihapus');
            return redirect()->to('/movie');
        }
    }
    public function edit($slug)
    {
        $data = [
            'title' => 'edit movie',
            'validation' => \Config\Services::validation(),
            'editmovie' => $this->movieModel->getMovie($slug)
        ];
        return view('/Movie/edit', $data);
    }
    public function update($id)
    {
        $moviebaru = $this->request->getVar('judul');
        $movielama = $this->movieModel->getMovie($this->request->getVar('slug'));
        if ($moviebaru == $movielama['judul']) {
            $rulejudul = 'required';
        } else {
            $rulejudul = 'required|is_unique[film.judul]';
        }
        if (!$this->validate([
            'judul' => [
                'rules' => $rulejudul,
                'errors' => [
                    'required' => '{field} harus diisi, dan tidak boleh kosong!',
                    'is_unique' => '{field} sudah ada sebelumnya, coba gunakan {field} lainnya!'
                ]
            ],
            'cover' => [
                //batas maksimal upload file php
                // uploaded[cover]
                'rules' => 'max_size[cover,10240]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    // 'uploaded' => 'Belum ada {field} yang di pilih!',
                    'mime_in' => 'extensi file salah!',
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // $validation = \config\Services::validation();
            // return redirect()->to('/Movie/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
            return redirect()->to('/Movie/edit/' . $this->request->getVar('slug'))->withInput();
        }
        $gambarbaru = $this->request->getFile('cover');
        //kalau tidak memasukkan gambar baru
        if ($gambarbaru->getError() == 4) {
            //maka diambil file gambar lamanya
            $namacover = $this->request->getVar('coverlama');
            //kalau memasukkan gambar baru
        } else {
            //buat random name gambar baru
            $namacover = $gambarbaru->getRandomName();
            //pindahkan ke img, randomvar
            $gambarbaru->move('img', $namacover);
            //hapus file lama
            unlink('img/' . $this->request->getVar('coverlama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->movieModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'sutradara' => $this->request->getVar('sutradara'),
            'rumahproduksi' => $this->request->getVar('rumahproduksi'),
            'cover' => $namacover
        ]);
        session()->setFlashData('pesan', 'data berhasil di update!');
        return redirect()->to('/movie');
    }
}
