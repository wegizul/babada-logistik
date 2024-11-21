<?php
class Model_PembelianDetail extends CI_Model
{
	var $table = 'pembelian_detail';
	var $column_order = array('pbd_id', 'mtl_nama', 'pbd_qty', 'smt_nama', 'pbd_harga'); //set column field database for datatable orderable
	var $column_search = array('pbd_id', 'mtl_nama'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('pbd_id' => 'asc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($id)
	{
		$this->db->from($this->table);
		$this->db->join("pembelian", "pbl_id = pbd_pbl_id", "left");
		$this->db->join("material", "mtl_id = pbd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pbd_satuan", "left");
		$this->db->where("pbd_pbl_id", $id);
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

	function get_datatables($id)
	{
		$this->_get_datatables_query($id);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id)
	{
		$this->_get_datatables_query($id);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_pembelian_detail()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_pembelian_detail($id)
	{
		$this->db->from($this->table);
		$this->db->join('pembelian', 'pbl_id = pbd_pbl_id', 'left');
		$this->db->join("material", "mtl_id = pbd_mtl_id", "left");
		$this->db->join('satuan_material', 'smt_id = pbd_satuan', 'left');
		$this->db->where('pbd_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function ambil_pembelian_detail($id)
	{
		$this->db->from($this->table);
		$this->db->join("material", "mtl_id = pbd_mtl_id", "left");
		$this->db->where('pbd_pbl_id', $id);
		$query = $this->db->get();

		return $query->result();
	}

	public function jumlah_bayar($id)
	{
		$this->db->select("SUM(pbd_harga) as jumlah_bayar, SUM(pbd_ppn) as jumlah_ppn, COUNT(pbd_mtl_id) as total_item");
		$this->db->from($this->table);
		$this->db->where('pbd_pbl_id', $id);
		$query = $this->db->get();

		return $query->row();
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
