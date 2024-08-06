<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

// Include Composer's autoload file
require_once APPPATH . '../vendor/autoload.php';

// Use Midtrans classes
use Midtrans\Config;
use Midtrans\Snap;

class Bill extends REST_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Mcrud');
    $this->load->config('midtrans');

    // Midtrans configuration
    Config::$serverKey = $this->config->item('midtrans_server_key');
    Config::$isProduction = $this->config->item('midtrans_is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;
    
  }

  public function index_get() {
    $data = $this->Mcrud->getBill();

    if (!empty($data)) {
      foreach ($data->result() as $row) {
        $row->foto = base_url("assets/image/anak_kos/$row->foto");
      }
      $this->response([
        'status' => TRUE,
        'message' => 'Berhasil',
        'data' => $data->result(),
      ], REST_Controller::HTTP_OK);
    } else {
      $this->response([
        'status' => FALSE,
        'message' => 'Tidak Ditemukan.',
      ], REST_Controller::HTTP_OK);
    }
  }

  public function filter_get() {
    $status = $this->get('status');
    $selectedMonth = $this->get('selectedMonth');
    $selectedYear = $this->get('selectedYear');

    if (!$status || !$selectedMonth || !$selectedYear) {
        $this->response([
            'status' => FALSE,
            'message' => 'Parameter status, selectedMonth, dan selectedYear diperlukan.',
        ], REST_Controller::HTTP_BAD_REQUEST);
        return;
    }

    // Konversi nama bulan ke nomor bulan
    $monthNumber = date('n', strtotime($selectedMonth));

    $data = $this->Mcrud->getBillByFilter($status, $monthNumber, $selectedYear);

    if ($data->num_rows() > 0) {
        foreach ($data->result() as $row) {
            $row->foto = base_url("assets/image/anak_kos/$row->foto");
        }
        $this->response([
            'status' => TRUE,
            'message' => 'Berhasil',
            'data' => $data->result(),
        ], REST_Controller::HTTP_OK);
    } else {
        $this->response([
            'status' => FALSE,
            'message' => 'Tidak Ditemukan.',
        ], REST_Controller::HTTP_OK);
    }
  }

  public function generate_post() {
    $bulan = strip_tags($this->post('bulan'));
    $tahun = strip_tags($this->post('tahun'));
    $users = $this->Mcrud->getBillAnakKosBaru($bulan, $tahun);
    foreach ($users->result() as $key => $value) {
      $day = date('d', strtotime($value->tgl_masuk));
      $date = strtotime("$tahun-$bulan-$day");

      $userData = array(
        'id_anak_kos' => $value->id_anak_kos,
        'tgl_bill' => date('Y-m-d', $date),
        'nominal' => $value->biaya,
        'status' => 0,
      );
      $insert = $this->Mcrud->tambah('bill', $userData);
    }

    $data = $this->Mcrud->getBillByMonth($bulan, $tahun);

    if (!empty($data)) {
      foreach ($data->result() as $row) {
        $row->foto = base_url("assets/image/anak_kos/$row->foto");
      }
      $this->response([
        'status' => TRUE,
        'message' => 'Berhasil',
        'data' => $data->result(),
      ], REST_Controller::HTTP_OK);
    } else {
      $this->response([
        'status' => FALSE,
        'message' => 'Tidak Ditemukan.',
      ], REST_Controller::HTTP_OK);
    }
  }

  public function user_get($id) {
    $data = $this->Mcrud->getBillByIdAnakKos($id);

    if (!empty($data)) {
        foreach ($data as $row) {
            $row->foto = base_url("assets/image/anak_kos/$row->foto");
        }
        $this->response([
            'status' => TRUE,
            'message' => 'Berhasil',
            'data' => $data,
        ], REST_Controller::HTTP_OK);
    } else {
        $this->response([
            'status' => FALSE,
            'message' => 'Tidak Ditemukan.',
        ], REST_Controller::HTTP_OK);
    }
  }


    public function get_snap_token_post() {
        $id_bill = strip_tags($this->post('id_bill'));

        // Fetch bill details from the database
        $bill = $this->Mcrud->getBillById($id_bill);
        if (empty($bill)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Bill not found.'
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        // Fetch customer details based on id_anak_kos from the bill
        $id_anak_kos = $bill->id_anak_kos;
        $customer = $this->Mcrud->getAnakKosById($id_anak_kos);
        if (empty($customer)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Customer not found.',
            ], REST_Controller::HTTP_NOT_FOUND);
            return;
        }

        $params = array(
            'transaction_details' => array(
                'order_id' => $id_bill,
                'gross_amount' => $bill->nominal,
            ),
            'customer_details' => array(
                'first_name' => $customer->nama,
                'last_name' => '',
                'phone' => $customer->kontak,
                'address' => $customer->alamat,
                'tgl_masuk' => $customer->tgl_masuk,
            ),
        );

        try {
            $snapToken = Snap::getSnapToken($params);
            // Prepare additional response data
            $additional_data = array(
                'transaction_details' => $params['transaction_details'],
                'customer_details' => $params['customer_details'],
            );

            $this->response([
                'status' => TRUE,
                'snap_token' => $snapToken,
                'additional_data' => $additional_data, // Add additional data here
            ], REST_Controller::HTTP_OK);
        } catch (Exception $e) {
            $this->response([
                'status' => FALSE,
                'message' => 'Gagal mendapatkan Snap Token: ' . $e->getMessage(),
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function update_status_post() {
      $id_bill = strip_tags($this->post('id_bill'));
      $metode_pembayaran = strip_tags($this->post('metode_pembayaran'));
  
      // Validate input
      if (empty($id_bill) || !is_numeric($id_bill)) {
          $this->response([
              'status' => FALSE,
              'message' => 'Invalid input.'
          ], REST_Controller::HTTP_BAD_REQUEST);
          return;
      }
  
      if (empty($metode_pembayaran)) {
          $this->response([
              'status' => FALSE,
              'message' => 'Payment method is required.'
          ], REST_Controller::HTTP_BAD_REQUEST);
          return;
      }
  
      // Update status and payment method in the database
      $data = array(
          'status' => 1, // Set status to 1 (sudah dibayar)
          'metode_pembayaran' => $metode_pembayaran // Set payment method
      );
      $update = $this->Mcrud->ubah('bill', $data, array('id_bill' => $id_bill));
  
      if ($update) {
          $this->response([
              'status' => TRUE,
              'message' => 'Status and payment method updated successfully.'
          ], REST_Controller::HTTP_OK);
      } else {
          $this->response([
              'status' => FALSE,
              'message' => 'Failed to update status and payment method.'
          ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
      }
  }
  


}
?>
