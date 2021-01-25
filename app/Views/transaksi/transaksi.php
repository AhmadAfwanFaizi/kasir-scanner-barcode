<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="callout callout-info">
                    <h1>Rp.<div class="float-right">100.000</div>
                    </h1>
                    <h4>
                        <small class="">Tanggal: 2/10/2014</small>
                    </h4>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-list"></i>
                                    Tabel Transaksi
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama Barang</th>
                                            <th>Harga</th>
                                            <th style="width: 10px">Jumlah</th>
                                            <th style="width: 95px">Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>Update software</td>
                                            <td>
                                                samsu
                                            </td>
                                            <td>1</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Clean database</td>
                                            <td>
                                                Filter
                                            </td>
                                            <td>2</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-4">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Total
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="">
                                    <div class="form-group">
                                        <label for="Uang Masuk">Uang Masuk</label>
                                        <input type="number" class="form-control" id="inputUangMasuk" placeholder="Rp.">
                                    </div>
                                    <div class="form-group">
                                        <label for="Uang Kembali">Uang Kembali</label>
                                        <input type="number" class="form-control" id="inputUangKembali" placeholder="Rp." readonly>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-success">Selesai</button>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<?= $this->endSection() ?>