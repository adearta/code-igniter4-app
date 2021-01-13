<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Ketikkan Nama Orang" aria-label="Cari Orang" aria-describedby="button-addon2" name="keyword">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" name="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <h1 class="mt-2">Daftar orang</h1>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 + (6 * ($currentpage - 1)); ?>
                    <?php foreach ($review as $rev) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $rev['nama']; ?></td>
                            <td><?= $rev['alamat']; ?></td>
                            <td><?= $rev['updated_at']; ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?= $pager->links('orang', 'review_pagination') ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>