<?php
class Model_Reject extends CI_Model
{
	var $table = 'reject';
	var $column_order = array('rjt_id', 'rjt_date_created', 'pjl_faktur', 'mtl_nama', 'pjd_qty', 'rjt_keterangan'); //set column field database for datatable orderable
	var $column_search = array('rjt_id', 'rjt_date_created', 'pjl_faktur', 'mtl_nama', 'pjd_qty', 'rjt_keterangan'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('rjt_id' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		$this->db->join("penjualan", 'pjl_id=rjt_pjl_id', 'left');
		$this->db->join("penjualan_detail", 'pjd_id=rjt_pjd_id', 'left');
		$this->db->join("material", 'mtl_id=rjt_material', 'left');
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

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_reject()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_reject($id)
	{
		$this->db->from($this->table);
		$this->db->where('rjt_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function ambil_reject($id)
	{
		$this->db->from($this->table);
		$this->db->where('rjt_pjd_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function notifikasi()
	{
		$this->db->from("reject");
		$this->db->where('rjt_status', 0);
		$query = $this->db->get();

		return $query->num_rows();
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
