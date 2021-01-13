<?php

namespace App\Models;

use CodeIgniter\Model;

class MovieModel extends Model
{
    protected $table = 'film';
    protected $useTimeStamps = true;
    //
    protected $allowedFields = ['judul', 'slug', 'sutradara', 'rumahproduksi', 'cover'];

    public function getMovie($slug = false)
    {
        if ($slug == false) {
            //
            return $this->findAll();
        }
        return $this->where(['slug' => $slug])->first();
    }
}
