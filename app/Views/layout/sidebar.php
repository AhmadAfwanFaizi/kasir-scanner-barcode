<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="<?= base_url() ?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-box"></i>
                <p>
                    Produk
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url() ?>/Produk/data" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Produk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/Produk/kategori" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kategori Produk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() ?>/Produk/satuan" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Satuan Produk</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="<?= base_url() ?>/Stok" class="nav-link">
                <i class="nav-icon fas fa-boxes"></i>
                <p>
                    Stok
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url() ?>/Supplier" class="nav-link">
                <i class="nav-icon fas fa-truck"></i>
                <p>
                    Supplier
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url() ?>/Transaksi" class="nav-link">
                <i class="nav-icon fas fa-exchange-alt"></i>
                <p>
                    Transaksi
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url() ?>/assets/pages/widgets.html" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                    Pengaturan
                </p>
            </a>
        </li>
    </ul>
</nav>