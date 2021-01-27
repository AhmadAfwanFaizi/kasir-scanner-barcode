`<?= $this->extend('layout/template') ?>
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
                    <h4 class="modal-title">Tambah Data Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formTambahSupplier">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="namaSupplier">Nama Supplier</label>
                                <input type="text" class="form-control" name="namaSupplier" id="namaSupplier" placeholder="Nama Supplier">
                            </div>
                            <div class="form-group">
                                <label for="kontakSupplier">Kontak Supplier</label>
                                <input type="text" class="form-control" name="kontakSupplier" id="kontakSupplier" placeholder="kontak Supplier" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="alamatSupplier">Alamat Supplier</label>
                                <textarea class="form-control" name="alamatSupplier" id="alamatSupplier" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="tambahDataSupplier()">Simpan</button>
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

    function tambahDataSupplier() {
        const data = $("#formTambahSupplier").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Supplier/tambah",
            data: data,
            success: (res) => {
                console.log('ok');
            }
        });
    }
</script>

<?= $this->endSection() ?>`