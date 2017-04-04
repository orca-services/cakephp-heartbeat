<?php

use \OrcaServices\Heartbeat\Heartbeat;

// @codeCoverageIgnoreStart
App::uses('Controller', 'Controller');
// @codeCoverageIgnoreEnd

/**
 * Heartbeat Controller
 */
class HeartbeatController extends Controller {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array(
		'RequestHandler'
	);

	/**
	 * Do not load any model
	 *
	 * @var bool
	 */
	public $uses = false;

	/**
	 * Heartbeat Status Page
	 *
	 * Resets the Heartbeat sensor cache if the query parameter
	 * ``reset-cache`` was given with a true-ish value.
	 *
	 * @return void
	 * @todo Cover layout overriding.
	 * @todo Cover cache-resetting.
	 */
	public function index() {
		$layout = Configure::read('App.Heartbeat.layout');
		if (!empty($layout)) {
			$this->layout = $layout;
		}

		$heartbeat = new Heartbeat();

		if ($this->request->query('reset-cache')) {
			$heartbeat->setCached(false);
		}

		$sensorStatuses = $heartbeat->check()->getSensorStatuses();
		$systemStatus = $heartbeat->getSystemStatus();

		$this->set(compact('systemStatus', 'sensorStatuses'));
	}

}
