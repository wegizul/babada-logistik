<?php
class Model_Kota extends CI_Model
{
	var $table = 'wilayah_kabupaten';
	var $column_order = array('kab_id', 'kot_nama', 'prov_nama'); //set column field database for datatable orderable
	var $column_search = array('kab_id', 'kot_nama', 'prov_nama'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('kot_nama' => 'asc'); // default order

	private $db_wilayah;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->db_wilayah = $this->load->database('wilayah', TRUE);
	}

	private function _get_datatables_query()
	{
		$this->db_wilayah->from($this->table);
		$this->db_wilayah->join('wilayah_provinsi', 'prov_id = provinsi_id', 'left');
		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{
				if ($i === 0) // first loop
				{
					$this->db_wilayah->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db_wilayah->like($item, $_POST['search']['value']);
				} else {
					$this->db_wilayah->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db_wilayah->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db_wilayah->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			foreach ($this->order as $key => $order) {
				$this->db_wilayah->order_by($key, $order);
			}
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db_wilayah->limit($_POST['length'], $_POST['start']);
		$query = $this->db_wilayah->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db_wilayah->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db_wilayah->from($this->table);

		return $this->db_wilayah->count_all_results();
	}

	public function get_data_kota()
	{
		$this->db_wilayah->from($this->table);
		$query = $this->db_wilayah->get();

		return $query->result();
	}

	public function cari_data_kota($id)
	{
		$this->db_wilayah->from($this->table);
		$this->db_wilayah->where('kab_id', $id);
		$query = $this->db_wilayah->get();

		return $query->row();
	}

	public function get_provinsi()
	{
		$this->db_wilayah->from('wilayah_provinsi');
		$query = $this->db_wilayah->get();

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
