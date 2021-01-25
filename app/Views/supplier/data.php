<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg">Tambah</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelDataSupplier" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Supplier</th>
                                    <th>Kontak Supplier</th>
                                    <th>Alamat Supplier</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Misc</td>
                                    <td>IE Mobile</td>
                                    <td>Windows Mobile 6</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Misc</td>
                                    <td>PSP browser</td>
                                    <td>PSP</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Other browsers</td>
                                    <td>All others</td>
                                    <td>-</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning"><i class="far fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama Supplier</th>
                                    <th>Kontak Supplier</th>
                                    <th>Alamat Supplier</th>
                                    <th>Opsi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kodeProduk">Kode Produk</label>
                                <input type="text" class="form-control" id="kodeProduk" placeholder="Kode Produk" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="namaProduk">Nama Produk</label>
                                <input type="text" class="form-control" id="namaProduk" placeholder="Nama Produk">
                            </div>
                            <div class="form-group">
                                <label for="jenisProduk">Jenis Produk</label>
                                <select class="form-control" id="jenisProduk">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="satuanProduk">satuan Produk</label>
                                <select class="form-control" id="satuanProduk">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</section>

<script>
    $(function() {
        $("#tabelDataSupplier").DataTable({
            "responsive": true,
            "autoWidth": false,
        });


    });
</script>

<?= $this->endSection() ?>