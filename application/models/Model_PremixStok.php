<?php
class Model_PremixStok extends CI_Model
{
	var $table = 'premix_stok';
	var $column_order = array('pxs_id', 'pxs_date_created', 'pmx_nama', 'pxs_tipe', 'pxs_qty'); //set column field database for datatable orderable
	var $column_search = array('pxs_id', 'pxs_date_created', 'pmx_nama', 'pxs_tipe', 'pxs_qty'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('pxs_date_created' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($bln)
	{
		$this->db->from($this->table);
		$this->db->join("premix", "pmx_id = pxs_pmx_id", "left");
		$this->db->join("sys_login", "log_id = pxs_user", "left");
		if ($bln != 'null') {
			$this->db->where('MONTH(pxs_date_created)', $bln);
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

	public function get_premix_stok()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_premix_stok($id)
	{
		$this->db->from($this->table);
		$this->db->where('pxs_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function export_excel($bln)
	{
		$this->db->from($this->table);
		$this->db->join("premix", "pmx_id = pxs_pmx_id", "left");
		$this->db->join("sys_login", "log_id = pxs_user", "left");
		if ($bln != 'null') {
			$this->db->where('MONTH(pxs_date_created)', $bln);
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
