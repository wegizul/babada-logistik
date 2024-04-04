<?php
class Model_Tracking extends CI_Model
{
	var $table = 'tracking';
	var $column_order = array('tr_id',); //set column field database for datatable orderable
	var $column_search = array('tr_id',); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('tr_id' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($jenis)
	{
		$user = $this->session->userdata('id_user');
		$this->db->from($this->table);
		$this->db->where('tr_user', $user);
		$this->db->where('tr_waktu_scan >', date('Y-m-d 00:00:00'));
		$this->db->where('tr_jenis', $jenis);
		$this->db->where('tr_kode_manifest', NULL);
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

	function get_datatables($jenis)
	{
		$this->_get_datatables_query($jenis);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($jenis)
	{
		$this->_get_datatables_query($jenis);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);

		return $this->db->count_all_results();
	}

	public function get_tracking()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_tracking($id)
	{
		$this->db->from($this->table);
		$this->db->where('tr_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function ambil_paket($kode)
	{
		$this->db->from('penjualan');
		$this->db->join('tracking', 'tr_pjl_faktur = pjl_faktur', 'left');
		$this->db->where('tr_kode_manifest', $kode);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_manifest()
	{
		$this->db->from("manifest");
		$this->db->where('mf_tgl_pickup', date('Y-m-d'));
		$this->db->where('mf_user', $this->session->userdata('id_user'));
		$query = $this->db->get();

		return $query->result();
	}

	public function ambil_manifest($kode)
	{
		$this->db->from("manifest");
		$this->db->where('mf_kode', $kode);
		$query = $this->db->get();

		return $query->row();
	}

	public function ambil_tracking($kode)
	{
		$this->db->from("tracking");
		$this->db->join("manifest", "mf_kode = tr_kode_manifest", "left");
		$this->db->join("booking_detail", "bd_kode = tr_bd_kode", "left");
		$this->db->join("booking", "bk_id = bd_bk_id", "left");
		$this->db->join("jenis_produk", "jp_id = bk_jenis_produk", "left");
		$this->db->where('tr_kode_manifest', $kode);
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
