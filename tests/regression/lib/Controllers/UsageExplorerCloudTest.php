<?php

namespace Controllers;

use TestHarness\RegressionTestHelper;

/**
 * Test the usage explorer for cloud realm regressions.
 */
class UsageExplorerCloudTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \RegressionTestHelper
     */
    private static $helper;

    /**
     * Create the helper and authenticate.
     */
    public static function setUpBeforeClass()
    {
        self::$helper = new RegressionTestHelper();
        self::$helper->authenticate();
    }

    /**
     * Log out and output any messages generated by tests.
     */
    public static function tearDownAfterClass()
    {
        self::$helper->logout();
        self::$helper->outputMessages();
    }

    /**
     * Test usage explorer CSV export.
     *
     * @group regression
     * @group UsageExplorer
     * @dataProvider csvExportProvider
     */
    public function testCsvExport($testName, $input, $expectedFile, $userRole)
    {
        $this->assertTrue(self::$helper->checkCsvExport($testName, $input, $expectedFile, $userRole));
    }

    public function csvExportProvider(){
        $statistics = array(
            'cloud_num_sessions_ended',
            'cloud_num_sessions_running',
            'cloud_num_sessions_started',
            'cloud_avg_wallduration_hours',
            'cloud_core_time',
            'cloud_core_utilization',
            'cloud_wall_time',
            'cloud_avg_cores_reserved',
            'cloud_avg_memory_reserved',
            'cloud_avg_rv_storage_reserved'
        );

        $group_bys = array(
            'none',
            'project',
            'configuration',
            'resource',
            'person',
            'pi',
            'username',
            'vm_size_memory',
            'vm_size',
            'submission_venue',
            'domain',
            'provider',
            'fieldofscience',
            'nsfdirectorate',
            'parentscience',
            'instance_state'
        );

        $varSettings = array(
            'realm' => array('Cloud'),
            'dataset_type' => array('aggregate', 'timeseries'),
            'statistic' => $statistics,
            'group_by' => $group_bys,
            'aggregation_unit' => array('Day', 'Month', 'Quarter', 'Year')
        );

        return RegressionTestHelper::generateTests($varSettings, '2018-04-18', '2018-04-30');
    }
}
