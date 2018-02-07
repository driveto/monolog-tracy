<?php
/**
 *
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Driveto\MonologTracy\Tracy;

class LoggerHelperTest extends \Driveto\MonologTracy\TestCase
{

	/** @var LoggerHelper */
	private $loggerHelper;

	public function setUp()
	{
		parent::setUp();
		$logDirectory = sys_get_temp_dir() . '/' . getmypid() . microtime() . '-LoggerHelperTest';
		@rmdir($logDirectory); // directory may not exist
		if (@mkdir($logDirectory) === FALSE && !is_dir($logDirectory)) {
			$this->fail(sprintf('Temp directory "%s" could not be created.', $logDirectory));
		}

		$this->loggerHelper = new LoggerHelper($logDirectory, new \Tracy\BlueScreen());
	}

	public function testRenderToFile()
	{
		$file = $this->loggerHelper->renderToFile(new \Exception('Test exception'));
		$this->assertFileExists($file);
		$this->assertContains('Test exception', file_get_contents($file));
	}

	/**
	 * @expectedException \Driveto\MonologTracy\Tracy\NotSupportedException
	 */
	public function testLog()
	{
		$this->loggerHelper->log('Test');
	}

	/**
	 * @expectedException \Driveto\MonologTracy\Tracy\NotSupportedException
	 */
	public function testDefaultMailer()
	{
		$this->loggerHelper->defaultMailer('Test', 'email@example.com');
	}

	/**
	 * @expectedException \Driveto\MonologTracy\Tracy\InvalidLogDirectoryException
	 */
	public function testInvalidLogDirectory()
	{
		$logDirectory = sys_get_temp_dir() . '/' . getmypid() . microtime() . '-LoggerHelperTest';
		new LoggerHelper($logDirectory, new \Tracy\BlueScreen());
	}

}
