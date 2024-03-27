<?php
class Model_Dashboard extends CI_Model
{
	public function get_penjualan_perbulan($thn)
	{
		$this->db->select('count(pjl_faktur) as jumlah, pjl_tanggal');
		$this->db->from('penjualan');
		if (!$thn) {
			$thn = date("Y");
		}
		$this->db->where("YEAR(pjl_tanggal) = '{$thn}'");
		$this->db->group_by("MONTH(pjl_tanggal)", "asc");

		$query = $this->db->get();
		$data = $query->result();
		foreach ($data as $dt) {
			$haha = [
				"bulan" => "{$dt->pjl_tanggal}",
				"jml" => $dt->jumlah
			];
			$hasil[] = $haha;
		}
		return $hasil;
	}

	public function get_produk_perbulan($thn)
	{
		$this->db->select('sum(pjd_qty) as total, mtl_nama, mtl_id, smt_nama');
		$this->db->from('penjualan_detail');
		$this->db->join('material', 'mtl_id = pjd_mtl_id');
		$this->db->join('satuan_material', 'smt_id = pjd_smt_id');
		$this->db->group_by('mtl_id');
		$this->db->order_by('total', 'asc');
		$this->db->limit(10);
		if (!$thn) {
			$thn = date("Y");
		}
		$this->db->where("YEAR(pjd_date_created) = '{$thn}'");
		$this->db->group_by("MONTH(pjd_date_created)", "asc");

		$query = $this->db->get();
		$data = $query->result();
		foreach ($data as $dt) {
			$hehe = [
				"jml" => $dt->total,
				"material" => $dt->mtl_nama,
				"satuan" => $dt->smt_nama
			];
			$hasil[] = $hehe;
		}
		return $hasil;
	}

	public function stok_sedikit()
	{
		$this->db->from("material");
		$this->db->where('mtl_stok < 10000');
		$this->db->order_by("mtl_stok", "asc");
		$this->db->limit(10);
		$query = $this->db->get();

		return $query->result();
	}

	public function pesanan_baru()
	{
		$this->db->from("penjualan");
		$this->db->where('pjl_status', 1);
		$this->db->order_by("pjl_tanggal", "asc");
		$this->db->limit(5);
		$query = $this->db->get();

		return $query->result();
	}
}
