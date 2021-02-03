<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="formTambahDataStok()">Tambah</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelDataStok" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
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

    <div class="modal fade" id="modalFormStok">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleFormStok"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formStok">
                        <input type="hidden" name="idStok" id="idStok">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kodeProduk">Kode Produk</label>
                                <input type="text" class="form-control" name="kodeProduk" id="kodeProduk" placeholder="Stok Produk" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="statusStok">Status Stok</label>
                                <select class="form-control" name="statusStok" id="statusStok">
                                    <option value="" hidden>Pilih</option>
                                    <option value="MASUK">Masuk</option>
                                    <option value="KELUAR">Keluar</option>
                                </select>
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
        $("#tabelDataStok").DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?= base_url() ?>/Stok/getDataTableStok",
                type: "POST",
            },
            "columnDefs": [{
                "targets": [0, 5],
                "orderable": false,
            }],
        });

    });

    function formTambahDataStok() {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormStok").text("Tambah Data Stok");
        $("#btn-simpan").html("Tambah");
        $("#btn-simpan").attr("onclick", "tambahDataStok()");
        $("#formStok").trigger("reset");
        $("#modalFormStok").modal("show");
    }

    // function tambahDataStok() {
    //     const data = $("#formStok").serialize();
    //     $.ajax({
    //         type: "POST",
    //         url: "<?= base_url() ?>/Stok/tambahDataStok",
    //         dataType: "JSON",
    //         data: data,
    //         success: (res) => {
    //             if (res == 200) {
    //                 notif('Data berhasil ditambahkan');
    //                 $("#tabelDataStok").DataTable().ajax.reload();
    //                 $("#formStok").trigger("reset");
    //             }
    //         }
    //     });
    // }

    // function formUbahDataStok(idStok) {
    //     $("#btn-simpan").removeAttr("onclick");
    //     $("#titleFormStok").text("Ubah Data Stok");
    //     $("#btn-simpan").html("Ubah");
    //     $("#btn-simpan").attr("onclick", "ubahDataStok()");
    //     $("#modalFormStok").modal("show");

    //     $.ajax({
    //         type: "POST",
    //         url: "<?= base_url() ?>/Stok/getDataStok",
    //         dataType: "JSON",
    //         data: {
    //             idStok: idStok
    //         },
    //         success: (res) => {
    //             console.log(res);
    //             $("#idStok").val(res.id);
    //             $("#StokProduk").val(res.Stok);
    //         }
    //     });
    // }

    // function ubahDataStok() {
    //     const data = $("#formStok").serialize();
    //     $.ajax({
    //         type: "POST",
    //         url: "<?= base_url() ?>/Stok/ubahDataStok",
    //         dataType: "JSON",
    //         data: data,
    //         success: (res) => {
    //             if (res.status == 200) {
    //                 notif('Data berhasil diubah');
    //                 $("#StokProduk").val(res.data.Stok);
    //                 $("#tabelDataStok").DataTable().ajax.reload();
    //             }
    //         }
    //     })
    // }

    // function formHapusDataStok(idStok) {
    //     $("#modalTitle").text("Hapus Data");
    //     $("#modalContent").text("Apakah Anda Yakin?");
    //     $(".modalAlertButton").removeAttr("id");
    //     $("#modal-alert").modal("show");
    //     $(".modalAlertButton").attr("id", "hapusDataStok");
    //     $("#hapusDataStok").click(() => {
    //         hapusDataStok(idStok)
    //     });
    // }

    // function hapusDataStok(idStok) {
    //     $.ajax({
    //         type: "POST",
    //         url: "<?= base_url() ?>/Stok/hapusDataStok",
    //         dataType: "JSON",
    //         data: {
    //             idStok: idStok
    //         },
    //         success: (res) => {
    //             if (res.status == 200) {
    //                 $("#modal-alert").modal("hide");
    //                 notif('Data berhasil ddihapus');
    //                 $("#tabelDataStok").DataTable().ajax.reload();
    //             }
    //         }
    //     });
    // }
</script>

<?= $this->endSection() ?>