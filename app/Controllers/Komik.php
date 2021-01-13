<?php

namespace App\Controllers;

use App\Models\KomikModel;
use CodeIgniter\CodeIgniter;
use Config\Validation;
use Exception;

class Komik extends BaseController
{   //variabel yang digunakan menyimpan objek hasil instansiasi kelas KomikModel
    protected $komikModel;
    public function __construct()
    { //instansiasi objek komikModel
        $this->komikModel = new KomikModel();
    }
    //method untuk menampilkan semua data yang tersedia
    public function index()
    {   //menyimpan judul page dan nilai dari objek komikModel
        $data  =
            [
                'title' => 'Daftar Komik',
                'komik' => $this->komikModel->findAll()
            ];
        //mengembalikan / menampilkan view pada folder komik dengan nama index.php, dan mengirimkan data yang disimpan pada 
        //variabel data
        return view('Komik/index', $data);
    }
    //method yang digunakan untuk menampilkan detai dari dat tertentu yang dipilih dengan indikator parameter slug
    public function detail($slug)
    { //menyimpan judul page dan objek instansiasi komikModel dan menggunakan method getKomik yang terdapat didalamnya untuk
        //mengambil nilai slug
        $data =
            [
                'title' => 'Detail Komik',
                'detailkomik' => $this->komikModel->getKomik($slug)
            ];
        //jika tidak ada slug atau data slug kosong, maka
        if (empty($data['detailkomik'])) {
            //akan melemparkan exception slug tersebut tidak ditemukan 
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Komik ' . $slug . ' tidak ditemukan!');
        }
        //jika tersedia maka akan mengembalikan view detail dan di rute kan ke komik/detail, serta mengirimkan array data
        return view('komik/detail', $data);
    }
    //method create digunakan untuk membuat data dan memvalidasi data tersebut
    public function create()
    {
        //karena tadi input kekirim ke session(), maka harus dipanggil sessionya(nb: sessionnya saya letakan pada base kontroller)
        //bisa dipangggil disini atau langsung di taruh di base kontroller untuk bisa langusng dipangil dari awal saat dijalankan
        $data =
            [
                'title' => 'Form Tambah Data Komik',
                //kemudian validationnya juga harus dipanggil disini agar nantinya bisa di panggil pada form create.php
                'validation' => \Config\Services::validation()
            ];
        //mengembalikan tampilan form create dengan rute komik/create dan mengirimkan array data
        return view('komik/create', $data);
    }
    //method save digunakan untuk menyiman data
    public function save()
    {
        //valdasi input
        //kalau tidak tervalidasi, 
        if (!$this->validate([
            //aturan validasi gunakan name
            //untuk membbuat pesan eror secara berbeda berdasarkan rules maka rules nya harus dipisahkan
            'judul' => [
                //definisikan dahulu rules
                //required dan is_unique
                //komik.judul -> variable komik dengan field judul
                'rules' => 'required|is_unique[komik.judul]',
                //kemudian jika error terjadi maka pesan ini ditampilkan 
                'errors' => [
                    'required' => '{field} komik harus diisi !.',
                    //baca judul komik harus diisi
                    'is_unique' => '{field} tersebut sudah ada !.'
                ]
            ]
        ])) {
            //mengambil pesan kesalahan 
            $validation = \config\Services::validation();
            // dd($validation);
            //kirim validasi ke halaman create
            //chaining dengan method=> withInput() mengirim semua input yang diketik user, kemudian pas klik tambah data di kelola oleh method save
            //kemudian kita mau balikin lagi ke method create, jadi inputnya harus kita balikinin lagi, nanti input ini akan disimpan ke dalam session()
            //terus selain withInput()/input data, kita juga mau ngirimin data validation nya , nama key nya ('validation', nilainya diambil dari variable $validation
            //jadi input dikirim dan validationnya dikirim ke $data pada method create. lanjut ke line 42.
            return redirect()->to('/Komik/create')->withInput()->with('validation', $validation);
        }
        // mengelola data yang dikirim dari create untuk disimpan kedalam tabel
        //ngambil data yang dikirim untuk ngecek bahwa data sudah bisa dikirim atau ada isinya
        // dd($this->request->getPost());
        //kemudian untuk memasukkan data ke database
        //untuk membuat secaa otomatis slug yang diambil dari url yaitu judul kemudian akan di pisahkan dengan"-" antara kata dan dijadikan lowecase (true)
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);
        //flash data => menampilkan pesan hanya sekali disimpan dalam sesion jika data berhasil ditambahkan
        session()->setFlashData('pesan', 'data berhasil ditambahkan.');
        //kemudian mengembalikan ke halaman komik 
        return redirect()->to('/komik');
    }
    public function delete($id)
    {
        $this->komikModel->delete($id);
        session()->setFlashData('pesan', 'data berhasil dihapus.');
        return redirect()->to('/komik');
    }
    public function edit($slug)
    {
        $data =
            [
                'title' => 'Form Ubah Data Komik',
                //kemudian validationnya juga harus dipanggil disini agar nantinya bisa di panggil pada form create.php
                'validation' => \Config\Services::validation(),
                'editkomik' => $this->komikModel->getKomik($slug)
            ];
        return view('/Komik/edit', $data);
    }
    public function update($id)
    {
        //cek judul jika sebelumnya sama
        //baca
        // inisialisais variabel untuk menyimpan nilai slug 
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        // jika judul komik lama sama dengan judul komik yang diubah saat ini
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            // maka rule required yang digunakan
            $ruleJudul = 'required';
        } else {
            // jika tidak maka rule yang digunakan adalah judulnya harus unik dan judulny harus diisi 
            $ruleJudul = 'required|is_unique[komik.judul]';
        }
        if (!$this->validate([
            //aturan validasi gunakan name
            //untuk membbuat pesan eror secara berbeda berdasarkan rules maka rules nya harus dipisahkan
            'judul' => [
                //definisikan dahulu rules
                //required dan is_unique
                //komik.judul -> variable komik dengan field judul
                'rules' => $ruleJudul,
                //kemudian jika error terjadi maka pesan ini ditampilkan 
                'errors' => [
                    'required' => '{field} komik harus diisi !.',
                    //baca judul komik harus diisi
                    'is_unique' => '{field} tersebut sudah ada !.'
                ]
            ]
        ])) {
            //mengambil pesan kesalahan 
            $validation = \config\Services::validation();
            // dd($validation);
            //kirim validasi ke halaman create
            //chaining dengan method=> withInput() mengirim semua input yang diketik user, kemudian pas klik tambah data di kelola oleh method save
            //kemudian kita mau balikin lagi ke method create, jadi inputnya harus kita balikinin lagi, nanti input ini akan disimpan ke dalam session()
            //terus selain withInput()/input data, kita juga mau ngirimin data validation nya , nama key nya ('validation', nilainya diambil dari variable $validation
            //jadi input dikirim dan validationnya dikirim ke $data pada method create. lanjut ke line 42.
            return redirect()->to('/Komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }



        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')
        ]);
        //flash data => menampilkan pesan hanya sekali disimpan dalam sesion jika data berhasil ditambahkan
        session()->setFlashData('pesan', 'data berhasil diubah.');
        //kemudian mengembalikan ke halaman komik 
        return redirect()->to('/komik');
    }
}
