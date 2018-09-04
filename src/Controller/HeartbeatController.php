<?php

namespace OrcaServices\Heartbeat\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use OrcaServices\Heartbeat\Heartbeat\Heartbeat;
/**
 * Heartbeat Controller
 */
class HeartbeatController extends AppController
{
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $layout = Configure::read('App.Heartbeat.layout');
        if (!empty($layout)) {
            $this->viewBuilder()->setLayout($layout);
        }
    }

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
    public function index()
    {
        $heartbeat = new Heartbeat();

        if ($this->request->getQuery('reset-cache')) {
            $heartbeat->setCached(false);
        }

        $sensorStatuses = $heartbeat->check()->getSensorStatuses();
        $systemStatus = $heartbeat->getSystemStatus();

        $this->set(compact('systemStatus', 'sensorStatuses'));
    }

}
