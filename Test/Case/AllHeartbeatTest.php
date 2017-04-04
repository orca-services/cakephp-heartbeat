<?php
/**
 * All Heartbeat plugin tests
 */
class AllHeartbeatTest extends CakeTestCase {

	/**
	 * Suite define the tests for this plugin
	 *
	 * @return CakeTestSuite The test suite to execute.
	 */
	public static function suite() {
		$suite = new CakeTestSuite('All Heartbeat test');

		$path = CakePlugin::path('Heartbeat') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}

}
