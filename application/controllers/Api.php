<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Material', 'material');
        $this->load->model('Model_Penjualan', 'penjualan');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function getMaterial()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $data = $this->material->get_material();

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

    public function findMaterial()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->input->post('mtl_id');
            $data = $this->material->cari_material($id);

            $json_data = json_encode($data);

            header('Content-Type: application/json');
            echo $json_data;
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }

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

                if ($data['pjl_jenis_harga'] == 1) {
                    $harga = $getMaterial->mtl_harga_jual;
                } else {
                    $harga = $getMaterial->mtl_harga_modal;
                }

                $detail = [
                    'pjd_pjl_id' => $getLastPenjualan->pjl_id,
                    'pjd_mtl_id' => $data2['pjd_mtl_id'][$idx],
                    'pjd_qty' => $data2['pjd_qty'][$idx],
                    'pjd_smt_id' => $data2['pjd_smt_id'][$idx],
                    'pjd_harga' => $harga * $data2['pjd_qty'][$idx],
                    'pjd_status' => $data['pjl_status']
                ];

                $data3['mtl_stok'] = $getMaterial->mtl_stok - $data2['pjd_qty'][$idx];

                if ($insert) $insert_detail = $this->penjualan->simpan("penjualan_detail", $detail);
                if ($insert_detail) $this->material->update("material", array('mtl_id' => $data2['pjd_mtl_id'][$idx]), $data3);

                $total_harga += ($harga * $data2['pjd_qty'][$idx]);
                $total_item += $parameter_item;
            }

            $tempdir = "assets/files/barcode/";
            $invoice = "INV" . sprintf("%04s", $getLastPenjualan->pjl_id);

            if (!file_exists($tempdir)) mkdir($tempdir, 0755);
            $target_path = $tempdir . $invoice . '-' . date('YmdHis') . ".png";
            /*using server online */
            // $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
            // $fileImage = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/php-barcode/barcode.php?text=" . $invoice . "-" . date('YmdHis') . "&codetype=code128&print=true&size=55";
            /*using server localhost*/
            $fileImage = base_url("assets/php-barcode-master/barcode.php?text=" . $invoice . "-" . date('YmdHis') . "&codetype=code128&print=true&size=55");
            /*get content from url*/
            $content = file_get_contents($fileImage);
            /*save file */
            file_put_contents($target_path, $content);
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
            echo json_encode($resp);
        } else {
            http_response_code(405);
            echo json_encode(array('message' => 'Method Not Allowed'));
        }
    }
}
