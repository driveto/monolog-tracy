<?php
/**
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Driveto\MonologTracy\Tracy;

use DateTimeImmutable;
use DateTimeInterface;
use Tracy\BlueScreen;

class LoggerHelper extends \Tracy\Logger
{

	/**
	 * @param string $directory
	 * @param BlueScreen $blueScreen
	 */
	public function __construct($directory, BlueScreen $blueScreen)
	{
		$logDirectoryRealPath = realpath($directory);
		if ($logDirectoryRealPath === FALSE || !is_dir($directory)) {
			throw new \Driveto\MonologTracy\Tracy\InvalidLogDirectoryException(sprintf(
				'Tracy log directory "%s" not found or is not a directory.',
				$directory
			));
		}

		parent::__construct($logDirectoryRealPath, NULL, $blueScreen);
	}

	/**
	 * @param \Exception|\Throwable $exception
	 * @param DateTimeInterface $datetime
	 * @return string file path
	 */
	public function renderToFile($exception, DateTimeInterface $datetime = NULL)
	{
		return $this->logException($exception, $this->getExceptionFile($exception, $datetime));
	}

	/**
	 * @param \Exception|\Throwable $exception
	 * @return string
	 */
	public function getExceptionHash($exception)
	{
		return substr(md5(preg_replace('~(Resource id #)\d+~', '$1', $exception)), 0, 10);
	}

	/**
	 * @param \Exception|\Throwable $exception
	 * @param DateTimeInterface $datetime
	 * @return string
	 */
	public function formatExceptionFilePath($exception, DateTimeInterface $datetime = NULL)
	{
		if ($datetime === NULL) {
			$datetime = new DateTimeImmutable();
		}
		$dir = strtr($this->directory . '/', '\\/', DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR);
		$hash = $this->getExceptionHash($exception);
		foreach (new \DirectoryIterator($this->directory) as $file) {
			if (strpos($file, $hash)) {
				return $dir . $file;
			}
		}
		return $dir . 'exception--' . $datetime->format('Y-m-d--H-i-s') . '--' . $hash . '.html';
	}

	/**
	 * @deprecated
	 * @param \Exception|\Throwable $exception
	 * @param DateTimeInterface $datetime
	 * @return string
	 */
	public function getExceptionFile($exception, DateTimeInterface $datetime = NULL)
	{
		return $this->formatExceptionFilePath($exception, $datetime);
	}

	/**
	 * @deprecated
	 * @param string $message
	 * @param string $priority
	 */
	public function log($message, $priority = self::INFO)
	{
		throw new \Driveto\MonologTracy\Tracy\NotSupportedException('LoggerHelper::log is not supported.');
	}

	/**
	 * @codeCoverageIgnore
	 * @deprecated
	 * @param string $message
	 */
	protected function formatMessage($message)
	{
		throw new \Driveto\MonologTracy\Tracy\NotSupportedException('LoggerHelper::formatMessage is not supported.');
	}

	/**
	 * @codeCoverageIgnore
	 * @deprecated
	 * @param string $message
	 * @param string|NULL $exceptionFile
	 */
	protected function formatLogLine($message, $exceptionFile = NULL)
	{
		throw new \Driveto\MonologTracy\Tracy\NotSupportedException('LoggerHelper::formatLogLine is not supported.');
	}

	/**
	 * @codeCoverageIgnore
	 * @deprecated
	 * @param string $message
	 */
	protected function sendEmail($message)
	{
		throw new \Driveto\MonologTracy\Tracy\NotSupportedException('LoggerHelper::sendEmail is not supported.');
	}

	/**
	 * @deprecated
	 * @param string $message
	 * @param string $email
	 */
	public function defaultMailer($message, $email)
	{
		throw new \Driveto\MonologTracy\Tracy\NotSupportedException('LoggerHelper::defaultMailer is not supported.');
	}

}
