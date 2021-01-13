<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="center">
                        <img src="/img/<?= $review['thumbnail']; ?>" class="center" width="500px" alt="...">
                    </div>
                    <div class="center">
                        <br></br>
                        <div class="card-body">
                            <h5 class="card-text"><?= $review['judul']; ?></h5>
                            <p class="card-text">
                                <b>Penulis : </b><?= $review['sutradara']; ?>
                            </p>
                            <p class="card-text"><small class="text-muted"><b>Penerbit : </b><?= $review['rumahproduksi']; ?></small></p>
                            <a href="" class="btn btn-warning">Edit</a>
                            <a href="" class="btn btn-danger">Delete</a>
                            <br></br>
                            <a href="/review">kembali ke halaman utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>