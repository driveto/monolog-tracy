<?php
/**
 *
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Driveto\MonologTracy\Tracy\Panel;

use Tracy\Dumper;

class PanelTest extends \Driveto\MonologTracy\TestCase
{

	/** @var TestPanel */
	private $panel;

	protected function setUp()
	{
		parent::setUp();

		$this->panel = new TestPanel();
	}

	public function testNotSupportedException()
	{
		$this->assertEmpty(call_user_func($this->panel, new \Exception()));
	}

	public function testSupportedException()
	{
		$exception = new \Driveto\MonologTracy\Tracy\NotSupportedException('test');

		$output = call_user_func($this->panel, $exception);

		$this->assertNotNull($output);
		$this->assertArrayHasKey('tab', $output);
		$this->assertArrayHasKey('panel', $output);

		$this->assertSame(get_class($exception), $output['tab']);
		$this->assertSame(Dumper::toHtml($exception), $output['panel']);
	}

}
