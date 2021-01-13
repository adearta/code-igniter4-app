<?php

namespace App\Controllers;

use App\Models\KomikModel;
use CodeIgniter\CodeIgniter;
use Config\Validation;
use Exception;
use CodeIgniter\HTTP\IncomingRequest;

class Api extends BaseController
{
    protected $komikModel;
    public function __construct()
    { //instansiasi objek komikModel
        $this->komikModel = new KomikModel();
    }

    public function getData()
    {
        // $request = service('request');
        // $auth = $request->getHeader('Authorization');
        $detail = $this->request->getVar('detail');
        $data = array(
            'detail' => $detail
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function saveKomik()
    {
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit')
        ]);

        $data = array(
            'response' => "sukses"
        );

        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
