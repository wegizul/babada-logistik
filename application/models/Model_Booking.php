<?php
class Model_Booking extends CI_Model
{
	var $table = 'booking';
	var $column_order = array('bk_id', 'bk_kode', 'bk_tanggal', 'jp_nama', 'bk_nama_pengirim', 'bk_nama_penerima', 'sp_nama'); //set column field database for datatable orderable
	var $column_search = array('bk_id', 'bk_kode', 'bk_tanggal', 'jp_nama', 'bk_nama_pengirim', 'bk_nama_penerima', 'sp_nama'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('bk_tanggal' => 'desc', 'bk_date_created' => 'desc'); // default order

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		$this->db->join('jenis_produk', 'jp_id = bk_jenis_produk', 'left');
		$this->db->join('status_pengiriman', 'sp_kode = bk_status_pengiriman', 'left');

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

	public function get_booking()
	{
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}

	public function cari_booking($id)
	{
		$this->db->from($this->table);
		$this->db->where('bk_id', $id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_last_booking()
	{
		$this->db->from($this->table);
		$this->db->join('jenis_produk', 'jp_id = bk_jenis_produk', 'left');
		$this->db->join('status_pengiriman', 'sp_kode = bk_status_pengiriman', 'left');
		$this->db->join('tipe_komoditas', 'tk_id = bk_tipe_komoditas', 'left');
		$this->db->join('tipe_alamat', 'ta_id = bk_tipe_alamat', 'left');
		$this->db->order_by('bk_id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();

		return $query->row();
	}

	public function ambil_booking($bk_id)
	{
		$this->db->from('booking_detail');
		$this->db->join('booking', 'bk_id = bd_bk_id', 'left');
		$this->db->join('jenis_produk', 'jp_id = bk_jenis_produk', 'left');
		$this->db->join('status_pengiriman', 'sp_kode = bk_status_pengiriman', 'left');
		$this->db->join('tipe_komoditas', 'tk_id = bk_tipe_komoditas', 'left');
		$this->db->join('tipe_alamat', 'ta_id = bk_tipe_alamat', 'left');
		$this->db->where('bk_id', $bk_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_jumlah_bd($id)
	{
		$this->db->from('booking_detail');
		$this->db->where('bd_bk_id', $id);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function lacak_paket($kode)
	{
		$this->db->from($this->table);
		$this->db->join('booking_detail', 'bd_bk_id = bk_id', 'left');
		$this->db->join('jenis_produk', 'jp_id = bk_jenis_produk', 'left');
		$this->db->join('status_pengiriman', 'sp_kode = bd_sp_kode', 'left');
		$this->db->join('tipe_komoditas', 'tk_id = bk_tipe_komoditas', 'left');
		$this->db->join('tipe_alamat', 'ta_id = bk_tipe_alamat', 'left');
		$this->db->where('bd_kode', $kode);
		$query = $this->db->get();

		return $query->row();
	}

	public function lacak_paket2($kode)
	{
		$this->db->from("tracking");
		$this->db->join('booking_detail', 'bd_kode = tr_bd_kode', 'left');
		$this->db->join('booking', 'bk_id = bd_bk_id', 'left');
		$this->db->join('jenis_produk', 'jp_id = bk_jenis_produk', 'left');
		$this->db->join('status_pengiriman', 'sp_kode = tr_sp_kode', 'left');
		$this->db->join('tipe_komoditas', 'tk_id = bk_tipe_komoditas', 'left');
		$this->db->join('tipe_alamat', 'ta_id = bk_tipe_alamat', 'left');
		$this->db->join('sys_login', 'log_id = tr_user', 'left');
		$this->db->where('tr_bd_kode', $kode);
		$this->db->order_by('tr_waktu_scan', 'desc');
		$query = $this->db->get();

		return $query->result();
	}

	public function ekspor_excel($tgl)
	{
		$this->db->from($this->table);
		$this->db->join('jenis_produk', 'jp_id = bk_jenis_produk', 'left');
		$this->db->join('tipe_komoditas', 'tk_id = bk_tipe_komoditas', 'left');
		if ($tgl != 'null') {
			$this->db->where('bk_tanggal', $tgl);
		}
		$query = $this->db->get();

		return $query->result();
	}

	public function bulan($bln)
	{
		$arr = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		return $arr[$bln];
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
