<?php
class Model_Dana extends CI_Model
{
	var $table = 'dana_operasional';
	var $column_order = array('dop_id', 'dop_tanggal', 'dop_jumlah', 'dop_terpakai', 'dop_sisa', 'log_nama'); //set column field database for datatable orderable
	var $column_search = array('dop_id', 'dop_tanggal', 'dop_jumlah', 'dop_terpakai', 'dop_sisa', 'log_nama'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('dop_tanggal' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($bln)
	{
		$this->db->from($this->table);
		$this->db->join("sys_login", "log_id = dop_user_input", "left");
		if ($bln != 'null') {
			$this->db->where('MONTH(dop_tanggal)', $bln);
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

	public function get_dana_operasional()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_dana_operasional($id)
	{
		$this->db->from($this->table);
		$this->db->where('dop_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function export_excel($bln)
	{
		$this->db->from($this->table);
		$this->db->join('sys_login', 'log_id = dop_user_input', 'left');
		if ($bln != 'null') {
			$this->db->where('MONTH(dop_tanggal)', $bln);
		}
		$query = $this->db->get();

		return $query->result();
	}

	public function ambil_dana_operasional($bln)
	{
		$this->db->from($this->table);
		$this->db->where('MONTH(dop_tanggal)', $bln);
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
