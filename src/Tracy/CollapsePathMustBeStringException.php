<?php
/**
 * Copyright (c) Patrik Votoček (https://patrik.votocek.cz)
 *
 * For the full copyright and license information,
 * please view the file LICENSE.md that was distributed with this source code.
 */

namespace Driveto\MonologTracy\Tracy;

class CollapsePathMustBeStringException extends \InvalidArgumentException implements \Driveto\MonologTracy\Tracy\Exception
{

	/**
	 * @param string $givenType
	 * @param \Exception|NULL $previous
	 */
	public function __construct($givenType, \Exception $previous = NULL)
	{
		parent::__construct(sprintf(
			'Collapse path must be string "%s" given,',
			$givenType
		), 0, $previous);
	}

}
