<?php
class Model_LapMaterial extends CI_Model
{
	var $table = 'material';
	var $column_order = array('mtl_id', 'jp_nama', 'mtl_nama', 'pjd_qty'); //set column field database for datatable orderable
	var $column_search = array('mtl_id', 'jp_nama', 'mtl_nama', 'pjd_qty'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('mtl_nama' => 'asc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($cus, $mtl, $bln, $tgl)
	{
		$this->db->from($this->table);
		$this->db->join("penjualan_detail", "pjd_mtl_id = mtl_id", "left");
		$this->db->join("penjualan", "pjl_id = pjd_pjl_id", "left");
		$this->db->join("satuan_material", "smt_id = mtl_satuan", "left");
		$this->db->join("jenis_produk", "jp_id = mtl_jenis", "left");
		if ($cus != 0) {
			$this->db->where('pjl_cust_id', $cus);
		}
		if ($mtl != 0) {
			$this->db->where('mtl_id', $mtl);
		}
		if ($bln != 0) {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
		if ($tgl != 0) {
			$this->db->where('pjl_tanggal', $tgl);
		}
		$this->db->group_by('mtl_id');
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

	function get_datatables($cus, $mtl, $bln, $tgl)
	{
		$this->_get_datatables_query($cus, $mtl, $bln, $tgl);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($cus, $mtl, $bln, $tgl)
	{
		$this->_get_datatables_query($cus, $mtl, $bln, $tgl);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_material()
	{
		$this->db->from($this->table);
		$this->db->join('jenis_produk', 'jp_id = mtl_jenis', 'left');
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_material($id)
	{
		$this->db->from($this->table);
		$this->db->join("satuan_material", "smt_id = mtl_satuan", "left");
		$this->db->where('mtl_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function getToju($cus, $mtl, $bln, $tgl)
	{
		$this->db->select("SUM(pjd_qty) as tot");
		$this->db->from("penjualan");
		$this->db->join("penjualan_detail", "pjl_id = pjd_pjl_id", "left");
		$this->db->where('pjd_mtl_id', $mtl);
		$this->db->where('pjl_cust_id', $cus);
		$this->db->where('pjl_tanggal', $tgl);
		$this->db->where('pjd_status <', 5);
		if ($bln != 0) {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
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
