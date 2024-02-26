<?php
class Model_Dashboard extends CI_Model
{
	public function get_booking_perbulan($thn)
	{
		$this->db->select('count(bk_nama_pengirim) as jumlah, bk_tanggal');
		$this->db->from('booking');
		if (!$thn) {
			$thn = date("Y");
		}
		$this->db->where("YEAR(bk_tanggal) = '{$thn}'");
		$this->db->group_by("MONTH(bk_tanggal)", "asc");

		$query = $this->db->get();
		$data = $query->result();
		foreach ($data as $dt) {
			$dgji = [
				"bulan" => "{$dt->bk_tanggal}",
				"jml" => $dt->jumlah
			];
			$hasil[] = $dgji;
		}
		return $hasil;
	}

	public function getlastquery()
	{
		$query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

		return $query;
	}
}
