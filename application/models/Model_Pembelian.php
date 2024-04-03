<?php
class Model_Pembelian extends CI_Model
{
	var $table = 'pembelian';
	var $column_order = array('pbl_id', 'pbl_tanggal', 'pbl_supplier', 'pbl_no_faktur', 'log_nama'); //set column field database for datatable orderable
	var $column_search = array('pbl_id', 'pbl_tanggal', 'pbl_supplier', 'pbl_no_faktur'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('pbl_tanggal' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($bln)
	{
		$this->db->from($this->table);
		$this->db->join("sys_login", "log_id = pbl_user", "left");
		if ($bln != 'null') {
			$this->db->where('MONTH(pbl_tanggal)', $bln);
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

	function get_datatables($bln)
	{
		$this->_get_datatables_query($bln);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($bln)
	{
		$this->_get_datatables_query($bln);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_pembelian()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_pembelian($id)
	{
		$this->db->from($this->table);
		$this->db->where('pbl_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_last_pembelian()
	{
		$this->db->from($this->table);
		$this->db->order_by('pbl_id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row();
	}

	public function ambil_pembelian($pbl_id)
	{
		$this->db->from('pembelian_detail');
		$this->db->join('pembelian', 'pbl_id = pbd_pbl_id', 'left');
		$this->db->where('pbl_id', $pbl_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_jumlah_pbd($id)
	{
		$this->db->from('pembelian_detail');
		$this->db->where('pbd_pbl_id', $id);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function export_excel($bln)
	{
		$this->db->from($this->table);
		$this->db->join('pembelian_detail', 'pbd_pbl_id = pbl_id', 'left');
		$this->db->join('material', 'mtl_id = pbd_mtl_id', 'left');
		$this->db->join('satuan_material', 'smt_id = pbd_satuan', 'left');
		$this->db->join('sys_login', 'log_id = pbl_user', 'left');
		$this->db->group_by("pbl_id");
		if ($bln != 'null') {
			$this->db->where('MONTH(pbl_tanggal)', $bln);
		}
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
