<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function index()
	{
		$query = $this->db->query('SELECT todo FROM dock_todo');
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode(array(
				$query->result()
			)));
	}

	public function mark()
	{
		$params = $this->security->xss_clean($this->input->get());
		if(!empty($params['task'])) {
			$response = $this->db->query('DELETE FROM dock_todo WHERE `todo`="' . $params['task'] . '"');
		}
		if($response) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array(
					"Task Marked Sucessfully!"
				)));
		}
	}
	public function add()
	{
		$params = $this->security->xss_clean($this->input->get());
		if(!empty($params['task'])) {
			$response = $this->db->query('INSERT INTO dock_todo SET `todo`="' . $params['task'] . '"');
		}
		if($response) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array(
					"Task Added Sucessfully!"
				)));
		}
	}

}
