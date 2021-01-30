<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="formTambahDataProduk()">Tambah</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelDataProdukProduk" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>kategori Produk</th>
                                    <th>Satuan Produk</th>
                                    <th>Harga Produk</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
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

    <div class="modal fade" id="modalFormProduk">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleFormProduk"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" name="formProduk">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kodeProduk">Kode Produk</label>
                                <input type="text" class="form-control" name="kodeProduk" id="kodeProduk" placeholder="Kode Produk" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="namaProduk">Nama Produk</label>
                                <input type="text" class="form-control" name="namaProduk" id="namaProduk" placeholder="Nama Produk">
                            </div>
                            <div class="form-group">
                                <label for="kategoriProduk">Kategori Produk</label>
                                <select class="form-control" name="kategoriProduk" id="kategoriProduk">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="satuanProduk">satuan Produk</label>
                                <select class="form-control" name="satuanProduk" id="satuanProduk">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="hargaProduk">Harga Produk</label>
                                <input type="text" class="form-control" name="hargaProduk" id="hargaProduk" placeholder="Harga Produk">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</section>

<script>
    $(function() {
        $("#tabelDataProdukProduk").DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?= base_url() ?>/Produk/getDataTableProduk",
                type: "POST",
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }]
        });
    });

    function formTambahDataProduk() {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormProduk").text("Tambah Data Produk");
        $("#btn-simpan").html("Tambah");
        $("#btn-simpan").attr("onclick", "tambahDataProduk()");
        $("#formProduk").trigger("reset");
        $("#modalFormProduk").modal("show");

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/selectInputProduk",
            dataType: "JSON",
            success: (res) => {
                if (res.status == 200) {
                    let optKat, iKat, optSat, iSat;
                    for (iKat = 0; iKat < res.kategori.length; iKat++) {
                        optKat += '<option value="" hidden>Pilih</option>';
                        optKat += '<option value="' + res.kategori[iKat].id + '">' + res.kategori[iKat].kategori + '</option>';
                    }

                    for (iSat = 0; iSat < res.satuan.length; iSat++) {
                        optSat += '<option value="" hidden>Pilih</option>';
                        optSat += '<option value="' + res.satuan[iSat].id + '">' + res.satuan[iSat].satuan + '</option>';
                    }
                    $("#kategoriProduk").html(optKat);
                    $("#satuanProduk").html(optSat);
                }
            }
        });

    }

    function tambahDataProduk() {
        const data = $("#formProduk").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/tambahDataProduk",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res == 200) {
                    notif('Data berhasil ditambahkan');
                    $("#tabelDataProdukProduk").DataTable().ajax.reload();
                    $("#formProduk").trigger("reset");
                }
            }
        });
    }
</script>

<?= $this->endSection() ?>