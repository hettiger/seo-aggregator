<?php namespace Hettiger\SeoAggregator;

use Hettiger\SeoAggregator\Interfaces\HelpersInterface;

class Generator {

	/**
	 * @var HelpersInterface
	 */
	protected $helpers;

	protected $protocol;
	protected $host;
	protected $field_names;

	/**
	 * @param HelpersInterface $helpers
	 * @param string $protocol
	 * @param null|string $host
	 * @param array $field_names
	 * @return Generator
	 */
	function __construct($helpers, $protocol = 'http', $host = null, $field_names = array())
	{
		$this->helpers = $helpers;

		$this->protocol = $protocol;
		$this->host = $host;
		$this->field_names = $field_names;
	}

}
