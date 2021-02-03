<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="formTambahDataSatuan()">Tambah</button>
                    </div>
                    <div class="card-body">
                        <table id="tabelDataSatuanProduk" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Satuan Produk</th>
                                    <th style="width: 70px;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFormSatuan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleFormSatuan"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formSatuan">
                        <input type="hidden" name="idSatuan" id="idSatuan">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="satuanProduk">Satuan Produk</label>
                                <input type="text" class="form-control" name="satuanProduk" id="satuanProduk" placeholder="Satuan Produk" autofocus>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn-simpan"></button>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    $(function() {
        $("#tabelDataSatuanProduk").DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?= base_url() ?>/Produk/getDataTableSatuan",
                type: "POST",
            },
            "columnDefs": [{
                "targets": [0, 2],
                "orderable": false,
            }]
        });
    });

    function formTambahDataSatuan() {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormSatuan").text("Tambah Data Satuan");
        $("#btn-simpan").html("Tambah");
        $("#btn-simpan").attr("onclick", "tambahDataSatuan()");
        $("#formSatuan").trigger("reset");
        $("#modalFormSatuan").modal("show");
    }

    function tambahDataSatuan() {
        const data = $("#formSatuan").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/tambahDataSatuan",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res == 200) {
                    notif('Data berhasil ditambahkan');
                    $("#tabelDataSatuanProduk").DataTable().ajax.reload();
                    $("#formSatuan").trigger("reset");
                }
            }
        });
    }

    function formUbahDataSatuan(idSatuan) {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormSatuan").text("Ubah Data Satuan");
        $("#btn-simpan").html("Ubah");
        $("#btn-simpan").attr("onclick", "ubahDataSatuan()");
        $("#modalFormSatuan").modal("show");

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/getDataSatuan",
            dataType: "JSON",
            data: {
                idSatuan: idSatuan
            },
            success: (res) => {
                console.log(res);
                $("#idSatuan").val(res.id);
                $("#satuanProduk").val(res.satuan);
            }
        });
    }

    function ubahDataSatuan() {
        const data = $("#formSatuan").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/ubahDataSatuan",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res.status == 200) {
                    notif('Data berhasil diubah');
                    $("#satuanProduk").val(res.data.satuan);
                    $("#tabelDataSatuanProduk").DataTable().ajax.reload();
                }
            }
        })
    }

    function formHapusDataSatuan(idSatuan) {
        $("#modalTitle").text("Hapus Data");
        $("#modalContent").text("Apakah Anda Yakin?");
        $(".modalAlertButton").removeAttr("id");
        $("#modal-alert").modal("show");
        $(".modalAlertButton").attr("id", "hapusDataSatuan");
        $("#hapusDataSatuan").click(() => {
            hapusDataSatuan(idSatuan)
        });
    }

    function hapusDataSatuan(idSatuan) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/hapusDataSatuan",
            dataType: "JSON",
            data: {
                idSatuan: idSatuan
            },
            success: (res) => {
                if (res.status == 200) {
                    console.log(res);
                    $("#modal-alert").modal("hide");
                    notif('Data berhasil ddihapus');
                    $("#tabelDataSatuanProduk").DataTable().ajax.reload();
                }
            }
        });
    }
</script>

<?= $this->endSection() ?>