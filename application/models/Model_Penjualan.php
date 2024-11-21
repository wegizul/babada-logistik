<?php
class Model_Penjualan extends CI_Model
{
	var $table = 'penjualan';
	var $column_order = array('pjl_id', 'pjl_tanggal', 'pjl_faktur', 'pjl_customer', 'pjl_total_item', 'pjl_jumlah_bayar', 'pjl_status_bayar'); //set column field database for datatable orderable
	var $column_search = array('pjl_id', 'pjl_tanggal', 'pjl_faktur', 'pjl_customer', 'pjl_total_item', 'pjl_jumlah_bayar', 'pjl_status_bayar'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('pjl_tanggal' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($bln, $tgl)
	{
		$this->db->from($this->table);
		$this->db->where('pjl_status >', 0);
		if ($bln != 'null') {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
		if ($tgl != 'null') {
			$this->db->where('pjl_tanggal', $tgl);
		}
		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{
				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			foreach ($this->order as $key => $order) {
				$this->db->order_by($key, $order);
			}
		}
	}

	function get_datatables($bln, $tgl)
	{
		$this->_get_datatables_query($bln, $tgl);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($bln, $tgl)
	{
		$this->_get_datatables_query($bln, $tgl);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_penjualan()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_penjualan($id)
	{
		$this->db->from($this->table);
		$this->db->where('pjl_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function cari_penjualan2($id)
	{
		$this->db->select('pjl_id, pjl_faktur, pjl_tanggal, pjl_customer, pjl_cust_id, pjl_total_item, pjl_status, pjl_user, pjl_catatan');
		$this->db->from($this->table);
		$this->db->where('pjl_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function getLast($user)
	{
		$this->db->from($this->table);
		$this->db->where('pjl_user', $user);
		$this->db->order_by('pjl_id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row();
	}

	public function ambil_penjualan($pjl_id)
	{
		$this->db->from('penjualan_detail');
		$this->db->join('penjualan', 'pjl_id = pjd_pjl_id', 'left');
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		$this->db->where('pjl_id', $pjl_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function notifikasi()
	{
		$this->db->from("penjualan");
		$this->db->where('pjl_status', 1);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function ambil_total($pjl_id)
	{
		$this->db->select("*, SUM(pjd_harga) as htot, COUNT(pjd_mtl_id) as itot");
		$this->db->from("penjualan_detail");
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->where('pjd_pjl_id', $pjl_id);
		$this->db->where('pjd_status <', 6);
		$query = $this->db->get();

		return $query->row();
	}

	public function lacak_paket($kode)
	{
		$this->db->from($this->table);
		$this->db->join('penjualan_detail', 'pjd_pjl_id = pjl_id', 'left');
		$this->db->where('pjl_faktur', $kode);
		$query = $this->db->get();

		return $query->row();
	}

	public function export_excel($bln)
	{
		$this->db->from($this->table);
		$this->db->join('sys_login', 'log_id = pjl_user', 'left');
		if ($bln != 'null') {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
		$query = $this->db->get();

		return $query->result();
	}

	public function list_penjualan($user)
	{
		$this->db->select('pjl_id, pjl_tanggal, pjl_faktur, pjl_customer, pjl_total_item, pjl_jumlah_bayar, pjl_status_bayar, pjl_status, pjd_id');
		$this->db->from('penjualan_detail');
		$this->db->join('penjualan', 'pjl_id = pjd_pjl_id', 'left');
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		$this->db->where('pjl_user', $user);
		$this->db->group_by('pjl_id');
		$this->db->order_by('pjl_id', 'desc');
		$query = $this->db->get();

		return $query->result();
	}

	public function list_allpenjualan()
	{
		$this->db->select('pjl_id, pjl_tanggal, pjl_faktur, pjl_customer, pjl_total_item, pjl_jumlah_bayar, pjl_status_bayar, pjl_status, pjd_id');
		$this->db->from('penjualan_detail');
		$this->db->join('penjualan', 'pjl_id = pjd_pjl_id', 'left');
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		$this->db->group_by('pjl_id');
		$this->db->order_by('pjl_id', 'desc');
		$query = $this->db->get();

		return $query->result();
	}

	public function list_filterpenjualan($id)
	{
		$this->db->select('pjl_id, pjl_tanggal, pjl_faktur, pjl_customer, pjl_total_item, pjl_jumlah_bayar, pjl_status_bayar, pjl_status');
		$this->db->from('penjualan');
		$this->db->join('penjualan_detail', 'pjd_id = pjd_pjl_id', 'left');
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		if ($id != 0) {
			$this->db->where('pjl_cust_id', $id);
		}
		$this->db->group_by('pjl_id');
		$this->db->order_by('pjl_id', 'desc');
		$query = $this->db->get();

		return $query->result();
	}

	public function ambil_invoice($kode)
	{
		$this->db->select('pjl_id, pjl_tanggal, pjl_faktur, pjl_customer, pjl_total_item, pjl_jumlah_bayar, pjl_status_bayar, pjl_status');
		$this->db->from($this->table);
		$this->db->join('penjualan_detail', 'pjd_id = pjd_pjl_id', 'left');
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		$this->db->where('pjl_faktur', $kode);
		$query = $this->db->get();

		return $query->row();
	}

	public function item_penjualan($pjl_id)
	{
		$this->db->select('pjd_pjl_id, pjd_id, pjd_qty, pjd_status, pjd_mtl_id, mtl_nama, smt_nama');
		$this->db->from('penjualan_detail');
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		$this->db->where('pjd_status <', 5);
		$this->db->where('pjd_pjl_id', $pjl_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function item_penjualan2($pjl_id)
	{
		$this->db->select('pjd_pjl_id, pjd_id, pjd_qty, pjd_status, pjd_mtl_id, mtl_nama, smt_nama');
		$this->db->from('penjualan_detail');
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		$this->db->where('pjd_pjl_id', $pjl_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function penjualan_material($id)
	{
		$this->db->select("pjd_qty, pjl_id, pjl_faktur, pjl_tanggal, pjl_customer, pjl_status, pjd_pjl_id, pjd_mtl_id, pjd_smt_id, mtl_id, smt_id, mtl_nama, smt_nama");
		$this->db->from($this->table);
		$this->db->join("penjualan_detail", "pjd_pjl_id = pjl_id", "left");
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		$this->db->where('pjd_mtl_id', $id);
		$this->db->order_by('pjl_faktur', 'desc');
		$query = $this->db->get();

		return $query->result();
	}

	public function getlastquery()
	{
		$query = str_replace(array("\r", "\n", "\t"), '', trim($this->db->last_query()));

		return $query;
	}

	public function update($tbl, $where, $data)
	{
		$this->db->update($tbl, $data, $where);
		return $this->db->affected_rows();
	}

	public function simpan($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function delete($table, $field, $id)
	{
		$this->db->where($field, $id);
		$this->db->delete($table);

		return $this->db->affected_rows();
	}
}
