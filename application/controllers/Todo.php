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
		$taskResp = '';
		$query = $this->db->query('SELECT todo FROM dock_todo');
		$response = $query->result();
		if(!empty($response)) {
			foreach ($response as $index => $task) {
				$tasktodo = ($index+1)  . ". " . (string)$task->todo . PHP_EOL;
				$taskResp .= $tasktodo;
			}
		}
		if(!empty($taskResp)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output($taskResp);
		} else {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output("No task to list!");
		}
	}

	public function mark()
	{
		$params = $this->security->xss_clean(($this->input->get('text')));
		if(!empty($params)) {
			$response = $this->db->query('DELETE FROM dock_todo WHERE `todo`="' . $params . '"');
		}
		if(!empty($response)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(
					"Task Marked Sucessfully!"
				);
		} else {
			syslog(LOG_ERR,"Error adding todo");
			return $this->output
				->set_content_type('application/json')
				->set_status_header(500)
				->set_output(
					"Task could not be marked!"
				);
		}
	}
	public function add()
	{
		$params = $this->security->xss_clean(($this->input->get('text')));
		if(!empty($params)) {
			$response = $this->db->query('INSERT INTO dock_todo SET `todo`="' . $params . '"');
		}
		if(!empty($response)) {
			return $this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(
					"Task Added Sucessfully!"
				);
		} else {
			syslog(LOG_ERR,"Error adding todo");
			return $this->output
				->set_content_type('application/json')
				->set_status_header(500)
				->set_output(
					"Task could not be added!"
				);
		}
	}

}
