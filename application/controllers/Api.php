<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Material', 'material');
        $this->load->model('Model_Penjualan', 'penjualan');
        $this->load->model('Model_PenjualanDetail', 'penjualan_detail');
        date_default_timezone_set('Asia/Jakarta');
    }

    // dropdown item menu tambah pembelian
    public function getMaterial()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->material->ambil_material();

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // mengambil data material yang dipilih pada dropdown menu tambah pembelian
    public function findMaterial()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->input->post('mtl_id');
            $data = $this->material->cari_material($id);

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // list riwayat pembelian kacab
    public function getPenjualan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->penjualan->list_penjualan($id);

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // list pembelian berdasarkan filter cabang
    public function getPenjualanFilter($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->penjualan->list_filterpenjualan($id);

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // mengambil item penjualan untuk di edit
    public function getPenjualanById($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $cari = $this->penjualan->item_penjualan($id);

            foreach ($cari as $p) {
                $data[$p->pjd_id] = "<tr><td width='45%'>" . $p->mtl_nama . "</td><td width='30%'><input type='number' min='0' value='" . $p->pjd_qty . "' class='form-control' style='width:50%;' onchange='ubah_qty(" . $p->pjd_id . ", this.value)'></td><td width='20%'>" . $p->smt_nama . "</td><td><span onClick='hapus_item(" . $p->pjd_id . "," . $p->pjd_pjl_id . ")' class='btn btn-danger btn-xs' title='Hapus Item'><i class='fa fa-trash-alt'></i></span></td></tr>";
            }

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // mengambil data penjualan
    public function getDataPenjualan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->penjualan->cari_penjualan2($id);

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // list riwayat penjualan semua cabang (akses level AM)
    public function getAllPenjualan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->penjualan->list_allpenjualan();

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // mengambil data invoice berdasarkan keyword yang dicari pada menu riwayat pembelian
    public function findInvoice()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomor = $this->input->post('pjl_faktur');
            $p = $this->penjualan->ambil_invoice($nomor);
            if ($p) {
                switch ($p->pjl_status) {
                    case 0:
                        $status = "<span class='label label-warning'>Menunggu Konfirmasi</span>";
                        break;
                    case 1:
                        $status = "<span class='label label-info'>Dikonfirmasi AM</span>";
                        break;
                    case 2:
                        $status = "<span class='label label-info'>Dikonfirmasi Logistik</span>";
                        break;
                    case 3:
                        $status = "<span class='label label-info'>Dikirim</span>";
                        break;
                    case 4:
                        $status = "<span class='label label-success'>Selesai</span>";
                        break;
                    case 6:
                        $status = "<span class='label label-danger'>Ditolak</span>";
                        break;
                }
                switch ($p->pjl_status_bayar) {
                    case 0:
                        $pembayaran = "<span class='label label-warning'>Tertunda</span>";
                        break;
                    case 1:
                        $pembayaran = "<span class='label label-danger'>Jatuh Tempo</span>";
                        break;
                    case 2:
                        $pembayaran = "<span class='label label-success'>Lunas</span>";
                        break;
                }
                if ($p->pjl_status == 3) {
                    $aksi = "<button type='button' id='klaim' class='btn btn-primary btn-xs' onClick='klaim(" . $p->pjl_id . ")'><i class='fas fa-exclamation-circle'></i> Klaim</button>";
                } else if ($p->pjl_status < 1) {
                    $aksi = "<a href='" . base_url('purchases/edit_pembelian/' . $p->pjl_id) . "' type='button' id='edit' class='btn btn-primary btn-xs'><i class='fas fa-pencil'></i> Edit</a>";
                } else {
                    $aksi = "<button type='button' class='btn btn-warning btn-xs' disabled>Klaim</button>";
                }
                $data = "<tr><td>" . $p->pjl_id . "</td><td>" . $p->pjl_tanggal . "</td><td>" . $p->pjl_faktur . "</td><td onClick='detail($p->pjl_id)' style='cursor:pointer;'>" . $p->pjl_customer . "</td><td>" . $p->pjl_total_item . "</td><td>Rp " . number_format($p->pjl_jumlah_bayar, 0, ',', '.') . "</td><td>" . $pembayaran . "</td><td>" . $status . "</td><td>" . $aksi . "</td></tr>";
            } else {
                $data = "<tr><td colspan='9' style='text-align: center;'><i>Data Tidak Ditemukan</i></td></tr>";
            }

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // menyimpan pembelian
    public function sendPurchase()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->input->post();

            unset($data['pjd_mtl_id']);
            unset($data['pjd_qty']);
            unset($data['pjd_smt_id']);

            $insert = $this->penjualan->simpan("penjualan", $data);

            $data2 = $this->input->post();
            $getLastPenjualan = $this->penjualan->getLast($data['pjl_user']);
            $total_harga = 0;
            $total_item = 0;

            foreach ($data2['pjd_qty'] as $idx => $kd) {
                $parameter_item = 1;
                $getMaterial = $this->material->cari_material($data2['pjd_mtl_id'][$idx]);

                $harga = $getMaterial->mtl_harga_jual;

                $detail = [
                    'pjd_pjl_id' => $getLastPenjualan->pjl_id,
                    'pjd_mtl_id' => $data2['pjd_mtl_id'][$idx],
                    'pjd_qty' => $data2['pjd_qty'][$idx],
                    'pjd_smt_id' => $data2['pjd_smt_id'][$idx],
                    'pjd_harga' => $harga * $data2['pjd_qty'][$idx],
                ];

                if ($insert) $insert_detail = $this->penjualan->simpan("penjualan_detail", $detail);

                $total_harga += ($harga * $data2['pjd_qty'][$idx]);
                $total_item += $parameter_item;
            }

            $tempdir = "assets/files/barcode/";
            $invoice = "INV" . sprintf("%04s", $getLastPenjualan->pjl_id);

            if (!file_exists($tempdir)) mkdir($tempdir, 0755);
            $fileImage = base_url("assets/php-barcode-master/barcode.php?text=" . $invoice . "-" . date('YmdHis') . "&codetype=code128&print=true&size=55");
            $content = file_get_contents($fileImage);
            $data4['pjl_barcode'] = $content;

            $update = [
                'pjl_faktur' => $invoice,
                'pjl_jumlah_bayar' => $total_harga,
                'pjl_total_item' => $total_item,
                'pjl_barcode' => $data4['pjl_barcode']
            ];
            $this->penjualan->update("penjualan", array('pjl_id' => $getLastPenjualan->pjl_id), $update);

            $error = $this->db->error();
            if (!empty($error)) {
                $err = $error['message'];
            } else {
                $err = "";
            }

            if ($insert_detail) {
                $resp['status'] = 1;
                $resp['desc'] = "Pembelian Berhasil Dikirim";
            } else {
                $resp['status'] = 0;
                $resp['desc'] = "Ada kesalahan dalam transaksi!";
                $resp['error'] = $err;
            }

            header('Access-Control-Allow-Origin: *');
            echo json_encode($resp);
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // menyimpan edit pembelian
    public function editPurchase()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data2 = $this->input->post();
            $pjl_id = $this->input->post('pjl_id');

            $total_harga = 0;
            $total_item = 0;

            if ($data2['parameter'] > 1) {
                foreach ($data2['pjd_qty'] as $idx => $kd) {
                    $parameter_item = 1;
                    $getMaterial = $this->material->cari_material($data2['pjd_mtl_id'][$idx]);

                    $harga = $getMaterial->mtl_harga_jual;

                    $detail = [
                        'pjd_pjl_id' => $pjl_id,
                        'pjd_mtl_id' => $data2['pjd_mtl_id'][$idx],
                        'pjd_qty' => $data2['pjd_qty'][$idx],
                        'pjd_smt_id' => $data2['pjd_smt_id'][$idx],
                        'pjd_harga' => $harga * $data2['pjd_qty'][$idx],
                    ];

                    $insert_detail = $this->penjualan->simpan("penjualan_detail", $detail);

                    $total_harga += ($harga * $data2['pjd_qty'][$idx]);
                    $total_item += $parameter_item;
                }
            }

            $getPenjualan = $this->penjualan->cari_penjualan($pjl_id);

            $update = [
                'pjl_jumlah_bayar' => $getPenjualan->pjl_jumlah_bayar + $total_harga,
                'pjl_total_item' => $getPenjualan->pjl_total_item + $total_item,
                'pjl_catatan' => $data2['pjl_catatan'],
            ];
            $update_pjl = $this->penjualan->update("penjualan", array('pjl_id' => $pjl_id), $update);

            $error = $this->db->error();
            if (!empty($error)) {
                $err = $error['message'];
            } else {
                $err = "";
            }

            if ($update_pjl) {
                $resp['status'] = 1;
                $resp['desc'] = "Berhasil mengupdate pembelian";
            } else {
                $resp['status'] = 0;
                $resp['desc'] = "Ada kesalahan dalam transaksi!";
                $resp['error'] = $err;
            }

            header('Access-Control-Allow-Origin: *');
            echo json_encode($resp);
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // mengambil item pembelian untuk ditampilkan pada dropdown klaim item
    public function getItemPenjualan($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->penjualan->item_penjualan($id);

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // mengambil item pembelian untuk ditampilkan pada list detail pembelian
    public function getItemPenjualan2($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $getPenjualan = $this->penjualan->item_penjualan2($id);

            foreach ($getPenjualan as $p) {
                if ($p->pjd_status == 6) {
                    $data[$p->pjd_id] = "<tr class='bg bg-danger'><td>" . $p->mtl_nama . " <i>(item tidak tersedia)</i></td><td>" . $p->pjd_qty . "</td><td>" . $p->smt_nama . "</td></tr>";
                } else {
                    $data[$p->pjd_id] = "<tr><td>" . $p->mtl_nama . "</td><td>" . $p->pjd_qty . "</td><td>" . $p->smt_nama . "</td></tr>";
                }
            }

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // mengambil item pembelian untuk ditampilkan pada list klaim
    public function getItemPenjualanKlaim($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $getPenjualan = $this->penjualan->item_penjualan($id);

            foreach ($getPenjualan as $idx => $p) {
                $data[$p->pjd_id] = "<tr><td>" . $p->mtl_nama . "</td><td><input type='text' class='form-control' name='rjt_keterangan[]' id='rjt_keterangan" . $idx . "'><input type='hidden' id='rjt_material" . $idx . "' name='rjt_material[]' value='" . $p->pjd_mtl_id . "'><input type='hidden' id='rjt_pjd_id" . $idx . "' name='rjt_pjd_id[]' value='" . $p->pjd_id . "'><input type='hidden' id='rjt_qty" . $idx . "' name='rjt_qty[]' value='" . $p->pjd_qty . "'></td></tr>";
            }

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // menyimpan klaim
    public function sendClaim()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->input->post();

            foreach ($data['rjt_keterangan'] as $idx => $kd) {
                if ($data['rjt_keterangan'][$idx]) {
                    $detail = [
                        'rjt_pjl_id' => $data['rjt_pjl_id'],
                        'rjt_pjd_id' => $data['rjt_pjd_id'][$idx],
                        'rjt_material' => $data['rjt_material'][$idx],
                        'rjt_qty' => $data['rjt_qty'][$idx],
                        'rjt_keterangan' => $data['rjt_keterangan'][$idx],
                        'rjt_customer' => $data['rjt_customer'],
                    ];
                    $this->penjualan->simpan("reject", $detail);

                    $update = [
                        'pjd_status' => 5,
                    ];
                    $this->penjualan->update("penjualan_detail", array('pjd_id' => $data['rjt_pjd_id'][$idx]), $update);
                }
            }

            $resp['status'] = 1;
            $resp['desc'] = "Pengajuan Klaim Berhasil Dikirim";

            header('Access-Control-Allow-Origin: *');
            echo json_encode($resp);
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // simpan edit qty item
    public function editQty($id, $qty)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $getPenjualanDetail = $this->penjualan_detail->cari_penjualan_detail($id);
            $getMaterial = $this->material->cari_material($getPenjualanDetail->pjd_mtl_id);

            $edit = [
                'pjd_qty' => $qty,
                'pjd_harga' =>  $getMaterial->mtl_harga_jual * $qty,
            ];
            $update = $this->penjualan->update("penjualan_detail", array('pjd_id' => $id), $edit);

            $getJumlahBayar = $this->penjualan_detail->jumlah_bayar($getPenjualanDetail->pjd_pjl_id);

            $edit_jml_byr = [
                'pjl_jumlah_bayar' => $getJumlahBayar->jumlah_bayar,
            ];
            $this->penjualan->update("penjualan", array('pjl_id' => $getPenjualanDetail->pjd_pjl_id), $edit_jml_byr);

            $error = $this->db->error();
            if (!empty($error)) {
                $err = $error['message'];
            } else {
                $err = "";
            }
            if ($update) {
                $resp['status'] = 1;
                $resp['desc'] = "Berhasil mengubah quantity";
            } else {
                $resp['status'] = 0;
                $resp['desc'] = "Ada kesalahan dalam penyimpanan!";
                $resp['error'] = $err;
            }

            header('Access-Control-Allow-Origin: *');
            echo json_encode($resp);
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // hapus item pembelian
    public function hapusItem($id, $pjl_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $delete = $this->penjualan->delete('penjualan_detail', 'pjd_id', $id);

            $getJumlahBayar = $this->penjualan_detail->jumlah_bayar($pjl_id);
            $getTotalItem = $this->penjualan_detail->total_item($pjl_id);

            $edit = [
                'pjl_total_item' => $getTotalItem->total_item,
                'pjl_jumlah_bayar' => $getJumlahBayar->jumlah_bayar,
            ];

            if ($delete) $update_total = $this->penjualan->update("penjualan", array('pjl_id' => $pjl_id), $edit);

            $error = $this->db->error();
            if (!empty($error)) {
                $err = $error['message'];
            } else {
                $err = "";
            }
            if ($update_total) {
                $resp['status'] = 1;
                $resp['desc'] = "Berhasil menghapus item";
            } else {
                $resp['status'] = 0;
                $resp['desc'] = "Ada kesalahan dalam proses hapus!";
                $resp['error'] = $err;
            }

            header('Access-Control-Allow-Origin: *');
            echo json_encode($resp);
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    // menyimpan konfirmasi AM
    public function konfir_am($pjl_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $update = [
                'pjl_status' => 1,
                'pjl_date_kon_am' => date('Y-m-d H:i:s'),
            ];

            $this->penjualan->update("penjualan", array('pjl_id' => $pjl_id), $update);
            $konfir = $this->penjualan->update("penjualan_detail", array('pjd_pjl_id' => $pjl_id), array('pjd_status' => 1));

            $error = $this->db->error();
            if (!empty($error)) {
                $err = $error['message'];
            } else {
                $err = "";
            }
            if ($konfir) {
                $resp['status'] = 1;
                $resp['desc'] = "Berhasil mengkonfirmasi pembelian";
            } else {
                $resp['status'] = 0;
                $resp['desc'] = "Ada kesalahan dalam konfirmasi!";
                $resp['error'] = $err;
            }

            header('Access-Control-Allow-Origin: *');
            echo json_encode($resp);
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }
}
