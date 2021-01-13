<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Tambah Data Film</h2>
            <!-- kita cetak $validation, kita ambil semua error yang tampil -->
            <!-- pake phpp $validation->listErrors(); -->

            <form action="/movie/save" method="post" enctype="multipart/form-data">
                <!-- diarahkan ke mathod diatas untuk menyimpan data kalau berhasil dan melakukan validasi kalau gagal -->
                <!-- jadi misalnya ada input yang belum diisi tapi harus diisi jadi nanti di validiasi disini -->
                <!-- methodnya post bukan get karena supaya nanti di routesnya khusus untuk post jadi lebih secure -->
                <!-- kalau menggunakan input type file harus menggunakan enctype, supaya form bisa bekerja degan file dan inputan biasa -->

                <?= csrf_field(); ?>
                <!-- cros side resource forgery -->
                <!-- agar form nya hanya bisa diinput lewat halaman ini saja  -->
                <div class="form-group row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <!-- auto focus untuk auto fokus pada field utama yang ingin diisi -->
                        <!-- operasi ternary(if dan else dalam satu baris) untuk membuat form menjadi merah jika inputan salah -->
                        <!-- value untuk membuat teks yang sudah ditulis sebelumnya tidak hilang saa halaman di refresh-->
                        <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= old('judul'); ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <!-- digunakan untuk menampika feedback jika terdapat errr -->
                            <?= $validation->getError('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sutradara" class="col-sm-2 col-form-label">sutradara</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="sutradara" name="sutradara" value="<?= old('sutradara'); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rumahproduksi" class="col-sm-2 col-form-label">rumah produksi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rumahproduksi" name="rumahproduksi" value="<?= old('rumahproduksi'); ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cover" class="col-sm-2 col-form-label">cover</label>
                    <div class="col-sm-2">
                        <img src="/img/default.jpg" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('cover')) ? 'is-invalid' : ''; ?>" id="cover" name="cover" onchange="previewImg()">
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <!-- digunakan untuk menampika feedback jika terdapat errr -->
                                <?= $validation->getError('cover'); ?>
                            </div>
                            <label class="custom-file-label" for="cover">upload cover</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>