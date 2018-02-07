<?php
/**
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Driveto\MonologTracy\Tracy;

class NotSupportedException extends \LogicException implements \Driveto\MonologTracy\Tracy\Exception
{

	/**
	 * @param string $message
	 * @param \Exception|NULL $previous
	 */
	public function __construct($message, \Exception $previous = NULL)
	{
		parent::__construct($message, 0, $previous);
	}

}
