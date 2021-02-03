`<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="formTambahDataSupplier()">Tambah</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelDataSupplier" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Supplier</th>
                                    <th>Nama Supplier</th>
                                    <th>Kontak Supplier</th>
                                    <th>Alamat Supplier</th>
                                    <th style="width: 70px;">Opsi</th>
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

    <div class="modal fade" id="modalFormSupplier">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleFormSupplier"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formSupplier">
                        <input type="hidden" name="kodeSupplier" id="kodeSupplier">
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
                    <button type="button" class="btn btn-primary" id="btn-simpan"></button>
                </div>
            </div>
        </div>
    </div>



</section>

<script>
    $(function() {
        $("#tabelDataSupplier").DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?= base_url() ?>/Supplier/dataTableSupplier",
                type: 'POST',
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }],
        });
    });

    function formTambahDataSupplier() {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormSupplier").text("Tambah Data Supplier");
        $("#btn-simpan").html("Tambah");
        $("#btn-simpan").attr("onclick", "tambahDataSupplier()");
        $("#formSupplier").trigger("reset");
        $("#modalFormSupplier").modal("show");
    }

    function tambahDataSupplier() {
        const data = $("#formSupplier").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Supplier/tambah",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res == 200) {
                    notif('Data berhasil ditambahkan');
                    $("#tabelDataSupplier").DataTable().ajax.reload();
                    $("#formSupplier").trigger("reset");
                }
            }
        });
    }

    function formUbahDataSupplier(kodeSupplier) {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormSupplier").text("Ubah Data Supplier");
        $("#btn-simpan").html("Ubah");
        $("#btn-simpan").attr("onclick", "ubahDataSupplier()");
        $("#modalFormSupplier").modal("show");

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Supplier/getDataSupplier",
            dataType: "JSON",
            data: {
                kodeSupplier: kodeSupplier
            },
            success: (res) => {
                $("#kodeSupplier").val(res.kode_supplier);
                $("#namaSupplier").val(res.nama_supplier);
                $("#kontakSupplier").val(res.kontak_supplier);
                $("#alamatSupplier").val(res.alamat_supplier);
            }
        });
    }

    function ubahDataSupplier() {
        const data = $("#formSupplier").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Supplier/ubah",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res.status == 200) {
                    notif('Data berhasil diubah');
                    $("#namaSupplier").val(res.data.nama_supplier);
                    $("#kontakSupplier").val(res.data.kontak_supplier);
                    $("#alamatSupplier").val(res.data.alamat_supplier);
                    $("#tabelDataSupplier").DataTable().ajax.reload();
                }
            }
        })
    }

    function formHapusDataSupplier(kodeSupplier) {
        $("#modalTitle").text("Hapus Data");
        $("#modalContent").text("Apakah Anda Yakin?");
        $(".modalAlertButton").removeAttr("id");
        $("#modal-alert").modal("show");
        $(".modalAlertButton").attr("id", "hapusDataSupplier");
        $("#hapusDataSupplier").click(() => {
            hapusDataSupplier(kodeSupplier)
        });
    }

    function hapusDataSupplier(kodeSupplier) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Supplier/hapus",
            dataType: "JSON",
            data: {
                kodeSupplier: kodeSupplier
            },
            success: (res) => {
                if (res.status == 200) {
                    $("#modal-alert").modal("hide");
                    notif('Data berhasil ddihapus');
                    $("#tabelDataSupplier").DataTable().ajax.reload();
                }
            }
        });
    }
</script>

<?= $this->endSection() ?>