<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table = 'komik';
    protected $useTimeStamps = true;
    //digunakan untuk menentukan fields mana saja pada tabel database yang dapat di edit 
    protected $allowedFields = ['judul', 'slug', 'penulis', 'penerbit', 'sampul'];

    public function getKomik($slug = false)
    { //jika  tidak terdapat slug, maka
        if ($slug == false) {
            //seleksi dan kembalikan  semua data 
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
        //akan mengembalkan nilai slug jika ada
    }
}
