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
                        <table id="tabelDataProduk" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>kategori</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
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
                    <form role="form" id="formProduk">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kodeProduk">Kode Produk</label>
                                <input type="text" class="form-control" name="kodeProduk" id="kodeProduk" placeholder="Kode Produk">
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
        $("#tabelDataProduk").DataTable({
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
        $("#kodeProduk").removeAttr("readonly");
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormProduk").text("Tambah Data Produk");
        $("#btn-simpan").html("Tambah");
        $("#btn-simpan").attr("onclick", "tambahDataProduk()");
        $("#formProduk").trigger("reset");
        $("#modalFormProduk").modal("show");

        selectProduk();
    }

    function selectProduk(paramKat = null, paramSat = null) {
        console.log(paramKat, paramSat);
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/selectInputProduk",
            dataType: "JSON",
            success: (res) => {
                if (res.status == 200) {
                    let optionKat, indexKat, idKat, selectKat, optionSat, indexSat, idSat, selectSat;
                    optionKat = '<option value="" hidden>Pilih</option>';
                    optionSat = '<option value="" hidden>Pilih</option>';

                    for (indexKat = 0; indexKat < res.kategori.length; indexKat++) {
                        idKat = res.kategori[indexKat].id;
                        selectKat = idKat == paramKat ? 'selected' : "";
                        optionKat += '<option value="' + idKat + '" ' + selectKat + '>' + res.kategori[indexKat].kategori + '</option>';
                    }
                    for (indexSat = 0; indexSat < res.satuan.length; indexSat++) {
                        idSat = res.satuan[indexSat].id;
                        selectSat = idSat == paramSat ? 'selected' : "";
                        optionSat += '<option value="' + idSat + '"' + selectSat + '>' + res.satuan[indexSat].satuan + '</option>';
                    }
                    $("#kategoriProduk").html(optionKat);
                    $("#satuanProduk").html(optionSat);
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
                    $("#tabelDataProduk").DataTable().ajax.reload();
                    $("#formProduk").trigger("reset");
                }
            }
        });
    }

    function formUbahDataProduk(kodeProduk) {
        $("#kodeProduk").attr("readonly", true);
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormProduk").text("Ubah Data Produk");
        $("#btn-simpan").html("Ubah");
        $("#btn-simpan").attr("onclick", "ubahDataProduk()");
        $("#modalFormProduk").modal("show");

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/getDataProduk",
            dataType: "JSON",
            data: {
                kodeProduk: kodeProduk
            },
            success: (res) => {
                $("#kodeProduk").val(res.kode_produk);
                $("#namaProduk").val(res.nama_produk);
                selectProduk(res.id_kategori, res.id_satuan);
                $("#hargaProduk").val(res.harga_produk);
            }
        });
    }

    function ubahDataProduk() {
        const data = $("#formProduk").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/ubahDataProduk",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res.status == 200) {
                    notif('Data berhasil diubah');
                    $("#ProdukProduk").val(res.data.Produk);
                    $("#tabelDataProduk").DataTable().ajax.reload();
                }
            }
        })
    }

    function formHapusDataProduk(kodeProduk) {
        $("#modalTitle").text("Hapus Data");
        $("#modalContent").text("Apakah Anda Yakin?");
        $(".modalAlertButton").removeAttr("id");
        $("#modal-alert").modal("show");
        $(".modalAlertButton").attr("id", "hapusDataProduk");
        $("#hapusDataProduk").click(() => {
            hapusDataProduk(kodeProduk)
        });
    }

    function hapusDataProduk(kodeProduk) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/hapusDataProduk",
            dataType: "JSON",
            data: {
                kodeProduk: kodeProduk
            },
            success: (res) => {
                if (res.status == 200) {
                    $("#modal-alert").modal("hide");
                    notif('Data berhasil ddihapus');
                    $("#tabelDataProduk").DataTable().ajax.reload();
                }
            }
        });
    }
</script>

<?= $this->endSection() ?>