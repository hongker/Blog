<?php 
namespace Blog\Components;

/**
 * 日期组件类
 * @author hongker
 * @version 1.0
 */
class DateComponent extends BaseComponent {
	/**
	 * The day constants
	 */
	const SUNDAY = 0;
	const MONDAY = 1;
	const TUESDAY = 2;
	const WEDNESDAY = 3;
	const THURSDAY = 4;
	const FRIDAY = 5;
	const SATURDAY = 6;
	/**
	 * Names of days of the week.
	 *
	 * @var array
	 */
	protected static $days = array(
			self::SUNDAY => 'Sunday',
			self::MONDAY => 'Monday',
			self::TUESDAY => 'Tuesday',
			self::WEDNESDAY => 'Wednesday',
			self::THURSDAY => 'Thursday',
			self::FRIDAY => 'Friday',
			self::SATURDAY => 'Saturday',
	);
	
	protected static $formats = array(
			'year' => 'Y',
			'yearIso' => 'o',
			'month' => 'n',
			'day' => 'j',
			'hour' => 'G',
			'minute' => 'i',
			'second' => 's',
			'micro' => 'u',
			'dayOfWeek' => 'w',
			'dayOfYear' => 'z',
			'weekOfYear' => 'W',
			'daysInMonth' => 't',
			'timestamp' => 'U',
	);
	
	/**
	 * 今天
	 * @return string
	 */
	public static function getCurrentDay() {
		return date('Ymd');
	}
	
	/**
	 * 获取本周日期
	 * @return multitype:string
	 */
	public static function getDaysOfCurrentWeek() {
		$dates = array();
		$month = date('m');
		
		$today = date(self::$formats['day']);
		$dayOfWeek = date(self::$formats['dayOfWeek']);
		
		for ($i=1;$i<=7;$i++) {
			$day = $today - $dayOfWeek + $i;
			$date = date('Ymd', mktime(0,0,0,$month,$day,date('Y')));
			$dates[] = $date;
		}
		return $dates;
	}
	
	/**
	 * 获取本月的日期
	 */
	public static function getCurrentMonth() {
		$daysInMonth = date(self::$formats['daysInMonth']);
		$month = date('Ym');
		$dates = array();
		for ($day=1;$day<=$daysInMonth;$day++) {
			$date = date('Ymd', mktime(0,0,0,$month,$day));
			$dates[] = $date;
		}
		return $dates;
	}
	
	public static function getCurrentYear() {
	
	}
}