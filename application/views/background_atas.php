<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title><?= $this->session->userdata("nama"); ?> | Logistik Olah Gemilang</title>

  <link rel="icon" href="<?= base_url("assets/"); ?>files/logo.png" type="image/jpg">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/dist/css/adminlte.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Select 2 -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/select2/css/select2.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.css">
  <!-- Daterangepicker -->
  <link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/daterangepicker/daterangepicker.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    body {
      padding-right: 0px !important;
    }

    /* width */
    ::-webkit-scrollbar {
      width: 8px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey;
      border-radius: 5px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
      background: #e3e3e3;
      border-radius: 5px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
      background: #a1a1a1;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
  <input type="hidden" id="base_link" value="<?= base_url(); ?>">
  <!-- jQuery -->
  <script src="<?= base_url("assets"); ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url("assets"); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url("assets"); ?>/dist/js/adminlte.min.js"></script>
  <!-- Custom -->
  <script src="<?= base_url("assets"); ?>/dist/js/ubah_pass.js"></script>
  <!-- Wysihtml5 -->
  <script src="<?= base_url("assets"); ?>/dist/ckeditor/ckeditor.js"></script>

  <!-- Modal Konfirmasi Ya Tidak -->
  <div class="modal fade" id="frmKonfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="jdlKonfirm">Konfirmasi Hapus</h4>
        </div>
        <div class="modal-body">
          <div id="isiKonfirm"></div>
          <input type="hidden" name="id" id="id">
          <input type="hidden" name="mode" id="mode">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="yaKonfirm"><i class="fas fa-trash-alt"></i> Hapus</button>
          <button data-dismiss="modal" class="btn btn-dark btn-sm" id="tidakKonfirm"><i class="fas fa-times-circle"></i> Batal</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="frmKonfirm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="jdlKonfirm2">Konfirmasi Hapus</h4>
        </div>
        <div class="modal-body">
          <div id="isiKonfirm2"></div>
          <input type="hidden" name="id" id="id2">
          <input type="hidden" name="mtl" id="mtl">
          <input type="hidden" name="jml" id="jml">
          <input type="hidden" name="mode" id="mode">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="yaKonfirm2"><i class="fas fa-trash-alt"></i> Hapus</button>
          <button data-dismiss="modal" class="btn btn-dark btn-sm" id="tidakKonfirm2"><i class="fas fa-times-circle"></i> Batal</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="frmKonfirm3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="jdlKonfirm3">Konfirmasi Logout</h4>
        </div>
        <div class="modal-body">
          <div id="isiKonfirm3"></div>
          <input type="hidden" name="id" id="id3">
          <input type="hidden" name="mode" id="mode3">
        </div>
        <div class="modal-footer">
          <a href="<?= base_url('Login/logout') ?>" type="button" class="btn btn-danger btn-sm"><i class="fas fa-sign-out-alt"></i> Keluar</a>
          <button data-dismiss="modal" class="btn btn-dark btn-sm" id="tidakKonfirm3"><i class="fas fa-times-circle"></i> Batal</button>
        </div>
      </div>
    </div>
  </div>

  <input type="hidden" name="base_link" id="base_link" value="<?= base_url() ?>">

  <!-- Bootstrap modal -->
  <div class="modal fade" id="ubah_pass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-lock"></i> Ubah Password</h5>
        </div>
        <form method="post" id="frm_ubahpass">
          <div class="modal-body form">
            <input type="hidden" name="pgnID" value="<?php $this->session->userdata("id_user"); ?>">
            <div class="col-lg">
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">Password Lama</span>
                </div>
                <input type="password" class="form-control infonya" name="log_pass" id="log_pass" value="" required>
              </div>
            </div>
            <div class="col-lg">
              <label>Password Baru</label>
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control infonya" name="log_passBaru" id="log_passBaru" value="" required>
              </div>
            </div>
            <div class="col-lg">
              <label>Konfirmasi Password Baru</label>
              <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control infonya" name="log_passBaru2" id="log_passBaru2" value="" required>
              </div>
            </div>
            <div class="alert alert-danger animated fadeInDown" role="alert" id="up_infoalert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <div id="up_pesan"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" id="up_simpan" class="btn btn-dark btn-sm"><i class="fas fa-check-circle"></i> Simpan</a>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fas fa-times-circle"></i> Batal</button>
          </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-angles-right"></i></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <?php if ($this->session->userdata("id_user")) { ?>
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item" title="Logout">
            <a class="nav-link" href="#" role="button" onClick="logout(<?= $this->session->userdata("id_user") ?>)">
              <i class="fas fa-sign-out-alt"></i>
            </a>
          </li>
        </ul>
      <?php } else { ?>
        <ul class="navbar-nav ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url("Login"); ?>" role="button">
              <i class="fas fa-user"></i> Login
            </a>
          </li>
        </ul>
      <?php } ?>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-navy elevation-4">
      <a href="<?= base_url() ?>" class="brand-link" style="background-color:#fff;">
        <img src="<?= base_url("assets"); ?>/files/logo.png" alt="Logo" class="brand-image">
        <span class="brand-text font-weight-dark" style="color: #010536;"><b>System</b></span>
      </a>
      <!-- Sidebar -->

      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-1 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url('assets/dist/img/user-blank.png'); ?>" class="img-circle elevation-2 mt-3" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= $this->session->userdata("nama"); ?></a>
            <span class="badge badge-dark"><?php
                                            switch ($this->session->userdata("level")) {
                                              case 1:
                                                echo "Super Admin";
                                                break;
                                              case 2:
                                                echo "Admin";
                                                break;
                                              case 3:
                                                echo "Admin Gudang";
                                                break;
                                              case 4:
                                                echo "Customer";
                                                break;
                                            }; ?></span>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?= base_url("Dashboard/tampil"); ?>" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <?php if ($this->session->userdata("level") < 3) : ?>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-suitcase"></i>
                  <p>
                    Data Master
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("Supplier/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-building"></i>
                      <p>
                        Data Supplier
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("Pengguna/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-user-cog"></i>
                      <p>
                        Data User
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("JenisProduk/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Jenis Produk
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("SatuanMaterial/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Satuan Material
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("StatusPengiriman/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Status Pengiriman
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("TipeAlamat/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Tipe Alamat
                      </p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif;
            if ($this->session->userdata('level') < 4) : ?>
              <li class="nav-item">
                <a href="<?= base_url("Material/tampil") ?>" class="nav-link">
                  <i class="nav-icon fas fa-database"></i>
                  <p>
                    Data Material
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("Premix/tampil") ?>" class="nav-link">
                  <i class="nav-icon fas fa-cube"></i>
                  <p>
                    Data Premix
                  </p>
                </a>
              </li>
            <?php endif; ?>
            <?php if ($this->session->userdata('level') < 3) { ?>
              <li class="nav-item">
                <a href="<?= base_url("Pengeluaran/tampil") ?>" class="nav-link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    Pengeluaran
                  </p>
                </a>
              </li>
            <?php } ?>
            <?php if ($this->session->userdata('level') < 4) { ?>
              <li class="nav-item">
                <a href="<?= base_url("Pembelian/tampil") ?>" class="nav-link">
                  <i class="nav-icon fas fa-cart-plus"></i>
                  <p>
                    Pembelian
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("Penjualan/tampil") ?>" class="nav-link">
                  <i class="nav-icon fas fa-cart-flatbed"></i>
                  <p>
                    Penjualan<?php if ($notifikasi > 0) { ?><sup><span class="badge badge-warning"><?= $notifikasi ?> Orderan Baru</span></sup><?php } ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("Klaim/tampil") ?>" class="nav-link">
                  <i class="nav-icon fas fa-exclamation-circle"></i>
                  <p>
                    Pengajuan Klaim<?php if ($klaim > 0) { ?><sup><span class="badge badge-warning"><?= $klaim ?> Klaim</span></sup><?php } ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url("ScanKirim/tampil") ?>" class="nav-link">
                  <i class="nav-icon fas fa-truck-fast"></i>
                  <p>
                    Pengiriman
                  </p>
                </a>
              </li>
            <?php } ?>
            <?php if ($this->session->userdata('level') < 3) { ?>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-file-excel"></i>
                  <p>
                    Laporan
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("LapMaterial/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Laporan Material
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("Premix/laporan") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Laporan Premix
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("Pembelian/laporan") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Laporan Pembelian
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("LapPenjualan/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Laporan Penjualan
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("Manifest/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Laporan Pengiriman
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("LapOrderan/tampil") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Laporan Orderan Outlet
                      </p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item" style="padding-left: 20px;">
                    <a href="<?= base_url("Material/laporan") ?>" class="nav-link">
                      <i class="nav-icon fas fa-cube"></i>
                      <p>
                        Laporan Rekap Barang
                      </p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php } ?>
          </ul>
        </nav>
        <nav class="mt-2 pt-3" style="border-top:1px solid #595959;">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="#" data-target="#ubah_pass" data-toggle="modal" class="nav-link">
                <i class="nav-icon fas fa-lock"></i>
                <p>
                  Ubah Password
                </p>
              </a>
          </ul>
        </nav>
      </div>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container">
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content pt-2">

        <script>
          function logout(id) {
            event.preventDefault();
            $("#log_id").val(id);
            $("#jdlKonfirm3").html("<i class='fas fa-sign-out-alt fa-xs'></i> Logout");
            $("#isiKonfirm3").html("Apakah anda ingin Keluar Aplikasi ?");
            $("#frmKonfirm3").modal({
              show: true,
              keyboard: false,
              backdrop: 'static'
            });
          }

          /** add active class and stay opened when selected */
          var url = window.location;

          // for sidebar menu entirely but not cover treeview
          $('ul.nav-sidebar a').filter(function() {
            return this.href == url;
          }).addClass('active');

          // for treeview
          $('ul.nav-treeview a').filter(function() {
            return this.href == url;
          }).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open').css({
            display: "block"
          });
        </script>