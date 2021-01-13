<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $detail['cover']; ?>" class="card-img" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $detail['judul']; ?></h5>
                            <p class="card-text">
                                <b>Penulis : </b><?= $detail['sutradara']; ?>
                            </p>
                            <p class="card-text"><small class="text-muted"><b>Penerbit : </b><?= $detail['rumahproduksi']; ?></small></p>
                            <a href="/movie/edit/<?= $detail['slug']; ?>" class="btn btn-warning">Edit</a>
                            <form action="/movie/<?= $detail['id']; ?>" class="d-inline" method="POST">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('apakah yakin akan menghapus <?= $detail['judul']; ?> ?')">Delete</button>
                                <?php $sql = 'ALTER TABLE film DROP id;
                                                ALTER TABLE film ADD  id INT( 11 ) idT NULL AUTO_INCREMENT FIRST ,ADD KEY (id)'; ?>
                            </form>
                            <br></br>
                            <a href="/movie">kembali ke halaman utama</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>