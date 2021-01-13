<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <a href="/Komik/create" class="btn btn-primary mt-3">tambah data komik</a>
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
                    <?php foreach ($komik as $kom) : ?>
                        <tr>
                            <th scope="row">1</th>
                            <td><img src="/img/<?= $kom['sampul']; ?>" alt="" class="sampul"></td>
                            <td><?= $kom['judul']; ?></td>
                            <td><a href="/komik/<?= $kom['slug']; ?>" class="btn btn-success">review</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>