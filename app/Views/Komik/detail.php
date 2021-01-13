<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $detailkomik['sampul']; ?>" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $detailkomik['judul']; ?></h5>
                            <p class="card-text">
                                <b>Penulis : </b><?= $detailkomik['penulis']; ?>
                            </p>
                            <p class="card-text"><small class="text-muted"><b>Penerbit : </b><?= $detailkomik['penerbit']; ?></small></p>
                            <a href="/komik/edit/<?= $detailkomik['slug']; ?>" class="btn btn-warning">Edit</a>

                            <form action="/komik/<?= $detailkomik['id']; ?>" class="d-inline" method="POST">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin menghapus <?= $detailkomik['judul']; ?> ?')">delete</button>
                            </form>
                            <!-- <a href="/komik/delete/phpp" class="btn btn-danger">Delete</a> -->
                            <br></br>
                            <a href="/komik">kembali ke halaman utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>