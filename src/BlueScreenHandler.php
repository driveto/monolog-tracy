<?php
/**
 * Copyright (c) 2014 Pavel Kučera (http://github.com/pavelkucera)
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Driveto\MonologTracy;

use Driveto\MonologTracy\Tracy\LoggerHelper;
use Monolog\Logger;

class BlueScreenHandler extends \Monolog\Handler\AbstractProcessingHandler
{

	/** @var LoggerHelper */
	private $loggerHelper;

	private $ignoredExceptions;

	/**
	 * @param LoggerHelper $loggerHelper
	 * @param int $level
	 * @param bool $bubble
	 * @param array $ignoredExceptions
	 */
	public function __construct(LoggerHelper $loggerHelper, $level = Logger::DEBUG, $bubble = TRUE, array $ignoredExceptions = [])
	{
		parent::__construct($level, $bubble);

		$this->loggerHelper = $loggerHelper;
		$this->ignoredExceptions = $ignoredExceptions;
	}

	/**
	 * @param array $record
	 */
	protected function write(array $record)
	{
		if (!isset($record['context']['exception']) || (!$record['context']['exception'] instanceof \Exception
			&& !$record['context']['exception'] instanceof \Throwable
		)) {
			return;
		}
		$exception = $record['context']['exception'];

		foreach ($this->ignoredExceptions as $ignoredClass) {
			if ($exception instanceof $ignoredClass) {
				return;
			}
		}

		if (!file_exists($this->loggerHelper->getExceptionFile($exception))) {
			$this->loggerHelper->renderToFile($exception);
		}
	}

}
