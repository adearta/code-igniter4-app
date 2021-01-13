<?php

namespace App\Controllers;

use App\Database\Migrations\Orang;
use App\Models\ReviewModel;

class Review extends BaseController
{
    protected $ReviewModel;
    public function __construct()
    {
        $this->ReviewModel = new ReviewModel();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $orang = $this->ReviewModel->search($keyword);
        } else {
            $orang = $this->ReviewModel;
        }
        $data = [
            'title' => 'Review pager',
            // 'review' => $this->ReviewModel->findAll()
            'review' => $orang->paginate(6, 'orang'),
            'pager' => $this->ReviewModel->pager,
            'currentpage' => $currentPage
        ];
        return view('Review/index', $data);
    }
    // public function review($slug)
    // {
    //     $data = [
    //         'title' => 'Penilaian cerita',
    //         'review' => $this->ReviewModel->getReview($slug)
    //     ];
    //     return view('Review/review', $data);
    // }
}
