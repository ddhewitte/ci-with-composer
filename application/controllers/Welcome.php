<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH.'vendor/dompdf/dompdf/lib/html5lib/Parser.php';
require_once FCPATH.'vendor/dompdf/dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->db->select('*');
		$data['data'] = $this->db->get('post');
		$this->load->view('welcome_message', $data);
	}

	public function pdf()
	{
		

		$this->db->select('*');
		$db = $this->db->get('post');
		
		$data = '';
		foreach($db->result_array() as $row)
		{
			$data .= '<tr><td>Nama</td><td>: </td><td>'.$row['nama'].'</td></tr><tr><td>Kota</td><td>: 
				  </td><td>'.$row['kota'].'</td></tr><tr><td>Pesan</td><td>: </td><td>'.$row['pesan'].'</td></tr>';
		} 

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->loadHtml($data);

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream();
	}

}
