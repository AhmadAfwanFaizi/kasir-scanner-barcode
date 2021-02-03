<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="formTambahDataKategori()">Tambah</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelDataKategoriProduk" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kategori Produk</th>
                                    <th>Opsi</th>
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

    <div class="modal fade" id="modalFormKategori">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleFormKategori"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formKategori">
                        <input type="hidden" name="idKategori" id="idKategori">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kategoriProduk">Kategori Produk</label>
                                <input type="text" class="form-control" name="kategoriProduk" id="kategoriProduk" placeholder="Kategori Produk" autofocus>
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
        $("#tabelDataKategoriProduk").DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?= base_url() ?>/Produk/getDataTableKategori",
                type: "POST",
            },
            "columnDefs": [{
                "targets": [0, 2],
                "orderable": false,
            }],
        });

    });

    function formTambahDataKategori() {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormKategori").text("Tambah Data Kategori");
        $("#btn-simpan").html("Tambah");
        $("#btn-simpan").attr("onclick", "tambahDataKategori()");
        $("#formKategori").trigger("reset");
        $("#modalFormKategori").modal("show");
    }

    function tambahDataKategori() {
        const data = $("#formKategori").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/tambahDataKategori",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res == 200) {
                    notif('Data berhasil ditambahkan');
                    $("#tabelDataKategoriProduk").DataTable().ajax.reload();
                    $("#formKategori").trigger("reset");
                }
            }
        });
    }

    function formUbahDataKategori(idKategori) {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormKategori").text("Ubah Data Kategori");
        $("#btn-simpan").html("Ubah");
        $("#btn-simpan").attr("onclick", "ubahDataKategori()");
        $("#modalFormKategori").modal("show");

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/getDataKategori",
            dataType: "JSON",
            data: {
                idKategori: idKategori
            },
            success: (res) => {
                console.log(res);
                $("#idKategori").val(res.id);
                $("#kategoriProduk").val(res.kategori);
            }
        });
    }

    function ubahDataKategori() {
        const data = $("#formKategori").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/ubahDataKategori",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res.status == 200) {
                    notif('Data berhasil diubah');
                    $("#kategoriProduk").val(res.data.kategori);
                    $("#tabelDataKategoriProduk").DataTable().ajax.reload();
                }
            }
        })
    }

    function formHapusDataKategori(idKategori) {
        $("#modalTitle").text("Hapus Data");
        $("#modalContent").text("Apakah Anda Yakin?");
        $(".modalAlertButton").removeAttr("id");
        $("#modal-alert").modal("show");
        $(".modalAlertButton").attr("id", "hapusDataKategori");
        $("#hapusDataKategori").click(() => {
            hapusDataKategori(idKategori)
        });
    }

    function hapusDataKategori(idKategori) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Produk/hapusDataKategori",
            dataType: "JSON",
            data: {
                idKategori: idKategori
            },
            success: (res) => {
                if (res.status == 200) {
                    $("#modal-alert").modal("hide");
                    notif('Data berhasil ddihapus');
                    $("#tabelDataKategoriProduk").DataTable().ajax.reload();
                }
            }
        });
    }
</script>

<?= $this->endSection() ?>