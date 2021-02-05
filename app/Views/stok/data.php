<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-one-masuk-tab" data-toggle="pill" href="#custom-tabs-one-masuk" role="tab" aria-controls="custom-tabs-one-masuk" aria-selected="true">Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-keluar-tab" data-toggle="pill" href="#custom-tabs-one-keluar" role="tab" aria-controls="custom-tabs-one-keluar" aria-selected="false">Keluar</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-masuk" role="tabpanel" aria-labelledby="custom-tabs-one-masuk-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div style="padding: 10px;">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" onclick="formTambahDataStok('MASUK')">Tambah</button>
                                        </div>

                                        <div>
                                            <table id="tabelDataStokMasuk" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Satuan</th>
                                                        <th>Jumlah</th>
                                                        <th>Supplier</th>
                                                        <th>Waktu</th>
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
                            <div class="tab-pane fade" id="custom-tabs-one-keluar" role="tabpanel" aria-labelledby="custom-tabs-one-keluar-tab">
                                <!-- <div class="row">
                                    <div class="col-12">
                                        <div style="padding: 10px;">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" onclick="formTambahDataStok('KELUAR')">Tambah</button>
                                        </div>

                                        <div>
                                            <table id="tabelDataStok" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Kode Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Satuan</th>
                                                        <th>Jumlah</th>
                                                        <th>Supplier</th>
                                                        <th>Waktu</th>
                                                        <th style="width: 70px;">Opsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
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
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kodeProduk">Produk</label>
                                <!-- <input type="text" class="form-control" name="kodeProduk" id="kodeProduk" placeholder="Stok Produk" autofocus> -->
                                <select class="form-control" name="kodeProduk" id="kodeProduk" style="width: 100%;">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kodeSupplier">Supplier</label>
                                <select class="form-control" name="kodeSupplier" id="kodeSupplier">

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Stok Produk" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="catatan">Catatan</label>
                                <textarea class="form-control" name="catatan" id="catatan" cols="30" rows="5"></textarea>
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
        $("#tabelDataStokMasuk").DataTable({
            "responsive": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?= base_url() ?>/Stok/getDataTableStok",
                type: "POST",
                data: {
                    param: "MASUK",
                }
            },
            "columnDefs": [{
                "targets": [0, 3, 7],
                "orderable": false,
            }],
        });

        // $("#tabelDataStokKeluar").DataTable({
        //     "responsive": true,
        //     "autoWidth": false,
        //     "processing": true,
        //     "serverSide": true,
        //     "ajax": {
        //         url: "<?= base_url() ?>/Stok/getDataTableStok",
        //         type: "POST",
        //     },
        //     "columnDefs": [{
        //         "targets": [0, 3, 7],
        //         "orderable": false,
        //     }],
        // });

        // $('.select2').select2();
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        loadData();
    });

    function loadData(produk = null, supplier = null) {
        let placeValProduk = (produk) ? produk : 'Pilih data Produk'
        let placeValSupplier = (supplier) ? supplier : 'Pilih data Supplier'

        $("#kodeProduk").select2({
            theme: 'bootstrap4',
            placeholder: placeValProduk,
            ajax: {
                url: "<?= base_url() ?>/Produk/getSelect",
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, (item) => {
                            return {
                                text: item.kode_produk + ' - ' + item.nama_produk,
                                id: item.kode_produk
                            }
                        })
                    }

                }
            },
        });

        $("#kodeSupplier").select2({
            theme: 'bootstrap4',
            placeholder: placeValSupplier,
            ajax: {
                url: "<?= base_url() ?>/Supplier/getSelect",
                dataType: 'json',
                data: function(params) {
                    return {
                        search: params.term
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, (item) => {
                            return {
                                text: item.kode_supplier + ' - ' + item.nama_supplier,
                                id: item.kode_supplier
                            }
                        })
                    }

                }
            },
        });
    }

    function resetSelect() {
        $("#kodeProduk").empty();
        $("#kodeSupplier").empty();
    }

    function formTambahDataStok() {
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormStok").text("Tambah Data Stok Masuk");
        $("#btn-simpan").html("Tambah");
        $("#btn-simpan").attr("onclick", "tambahDataStok()");
        $("#formStok").trigger("reset");
        resetSelect();
        loadData();
        $("#modalFormStok").modal("show");
    }

    function tambahDataStok() {
        const data = $("#formStok").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Stok/tambah",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res == 200) {
                    notif('Data berhasil ditambahkan');
                    $("#tabelDataStok").DataTable().ajax.reload();
                    $("#formStok").trigger("reset");
                    resetSelect();
                }
            }
        });
    }

    function formUbahDataStok(id) {
        resetSelect();
        $("#jumlah").attr("readonly", "readonly");
        $("#btn-simpan").removeAttr("onclick");
        $("#titleFormStok").text("Ubah Data Stok Masuk");
        $("#btn-simpan").html("Ubah");
        $("#btn-simpan").attr("onclick", "ubahDataStok()");
        $("#modalFormStok").modal("show");

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Stok/getDataStok",
            dataType: "JSON",
            data: {
                id: id
            },
            success: (res) => {
                let produk = res.kode_produk + ' - ' + res.nama_produk;
                let supplier = res.kode_supplier + ' - ' + res.nama_supplier;
                loadData(produk, supplier);
                $("#kodeProduk").select2('data', {
                    id: res.kode_produk,
                    text: res.nama_produk
                });
                $("#jumlah").val(res.jumlah);
                $("#catatan").val(res.catatan);
            }
        });
    }

    function ubahDataStok() {
        const data = $("#formStok").serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/Stok/ubah",
            dataType: "JSON",
            data: data,
            success: (res) => {
                if (res.status == 200) {
                    notif('Data berhasil diubah');
                    $("#StokProduk").val(res.data.Stok);
                    $("#tabelDataStok").DataTable().ajax.reload();
                }
            }
        })
    }

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