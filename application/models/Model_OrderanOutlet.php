<?php
class Model_OrderanOutlet extends CI_Model
{
	var $table = 'penjualan';
	var $column_order = array('pjl_id', 'pjl_customer'); //set column field database for datatable orderable
	var $column_search = array('pjl_id', 'pjl_customer'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('pjl_customer' => 'asc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($bln)
	{
		$this->db->from($this->table);
		if ($bln == 0) {
			$this->db->where('MONTH(pjl_tanggal)', date('n'));
		} else {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
		$this->db->group_by('pjl_customer');

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

	public function getTotalItem($cust, $bln)
	{
		$this->db->select("SUM(pjl_total_item) as total");
		$this->db->from($this->table);
		$this->db->where('pjl_cust_id', $cust);
		if ($bln == 0) {
			$this->db->where('MONTH(pjl_tanggal)', date('n'));
		} else {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
		$query = $this->db->get();

		return $query->row();
	}

	public function getTotalBayar($cust, $bln)
	{
		$this->db->select("SUM(pjl_jumlah_bayar) as total");
		$this->db->from($this->table);
		$this->db->where('pjl_cust_id', $cust);
		$this->db->where('pjl_status_bayar', 2);
		if ($bln == 0) {
			$this->db->where('MONTH(pjl_tanggal)', date('n'));
		} else {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
		$query = $this->db->get();

		return $query->row();
	}

	public function getTotalTransaksi($cust, $bln)
	{
		$this->db->from($this->table);
		$this->db->where('pjl_cust_id', $cust);
		if ($bln == 0) {
			$this->db->where('MONTH(pjl_tanggal)', date('n'));
		} else {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function ambil_penjualan($cust, $bln)
	{
		$this->db->select("*, SUM(pjd_qty) as total, COUNT(pjd_mtl_id) as total_dipesan");
		$this->db->from('penjualan_detail');
		$this->db->join('penjualan', 'pjl_id = pjd_pjl_id', 'left');
		$this->db->join("material", "mtl_id = pjd_mtl_id", "left");
		$this->db->join("satuan_material", "smt_id = pjd_smt_id", "left");
		$this->db->where('pjl_cust_id', $cust);
		if ($bln == 0) {
			$this->db->where('MONTH(pjl_tanggal)', date('n'));
		} else {
			$this->db->where('MONTH(pjl_tanggal)', $bln);
		}
		$this->db->group_by('mtl_id');
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
