<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <a href="/Movie/create" class="btn btn-primary mt-3">tambah data film</a>
    <h1 class="mt-2">Daftar Komik</h1>
    <?php if (session()->getFlashData('pesan')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashData('pesan'); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">review</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movie as $mov) : ?>
                        <tr>
                            <th scope="row"><?= $mov['id']; ?></th>
                            <td><img src="/img/<?= $mov['cover']; ?>" alt="" class="sampul"></td>
                            <td><?= $mov['judul']; ?></td>
                            <td><a href="/movie/<?= $mov['slug']; ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>