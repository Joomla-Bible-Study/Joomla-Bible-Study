<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 *
 * @copyright (C) 2008 - 2015 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

jimport ('joomla.error.profiler');

/**
 * Class JBSMProfiler
 */
class JBSMProfiler extends JProfiler
{
	protected static $_instances = array();
	protected $_kstart = array();
	/**
	 * @var array|JBSMProfilerItem[]
	 */
	protected $_heap = array();

	/**
	 * @param string $prefix
	 *
	 * @return JBSMProfiler
	 *
	 * @fixme override getInstance() and fix the function into Joomla
	 */
	public static function instance($prefix = 'Kunena')
	{
		if (empty(self::$_instances[$prefix]))
		{
			$c = __CLASS__;
			self::$_instances[$prefix] = new $c($prefix);
		}

		return self::$_instances[$prefix];
	}

	public function start($name)
	{
		$item = JBSMProfilerItem::getInstance($name);
		$item->start($this->getmicrotime());
		$this->_heap[] = $item;
	}

	public function getTime($name)
	{
		$item = JBSMProfilerItem::getInstance($name);

		return $this->getmicrotime() - $item->getStartTime();
	}

	public function stop($name)
	{
		$item = array_pop($this->_heap);

		if (!$item || $item->name != $name)
		{
			trigger_error(__CLASS__.'::'.__FUNCTION__."('$name') is missing start()");
		}

		$delta = $item->stop($this->getmicrotime());

		if (end($this->_heap))
		{
			$this->_heap[key($this->_heap)]->external($delta);
		}

		return $item;
	}

	public function getAll()
	{
		$items = JBSMProfilerItem::getAll();
		$this->sort($items);

		return $items;
	}

	function sort(&$array, $property = 'total')
	{
		return usort($array, function($a, $b) use ($property)
		{
			if ($a->$property == $b->$property)
			{
				return 0;
			}

			return $a->$property < $b->$property ? 1 : -1;
		});
	}
}

/**
 * Class JBSMProfilerItem
 */
class JBSMProfilerItem
{
	/**
	 * @var array|JBSMProfilerItem[]
	 */
	protected static $_instances = array();
	public $start = array();

	public function __construct($name)
	{
		$this->name = $name;
		$this->calls = 0;
		$this->total = 0.0;
		$this->external = 0.0;
	}

	/**
	 * @param string $name
	 * @return JBSMProfilerItem
	 */
	public static function getInstance($name)
	{
		if (empty(self::$_instances[$name]))
		{
			self::$_instances[$name] = new JBSMProfilerItem($name);
		}

		return self::$_instances[$name];
	}

	public static function getAll()
	{
		return self::$_instances;
	}

	public function getStartTime()
	{
		return end($this->start);
	}

	public function getTotalTime()
	{
		return $this->total;
	}

	public function getInternalTime()
	{
		return $this->total - $this->external;
	}

	public function start($starttime)
	{
		$this->calls++;
		$this->start[] = $starttime;
	}

	public function stop($stoptime)
	{
		$starttime = array_pop($this->start);

		if (!$starttime || !$stoptime)
		{
			return 0.0;
		}

		$delta = $stoptime - $starttime;
		$this->total += $delta;

		return $delta;
	}

	public function external($delta)
	{
		$this->external += $delta;
	}
}
