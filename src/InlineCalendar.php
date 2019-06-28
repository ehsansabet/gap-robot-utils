<?php namespace ehsansabet\GapUtils;

use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

/**
 *  Gap messenger robot utils
 *
 * @author Ehsan Sabet (ehsan.sabet@hotmail.com)
 */
class InlineCalendar {

	public static function show( $options = [] ) {
		$options += [
			'year'   => null,
			'month'  => null,
			'format' => null,
			'next_label' => "⏪ ",
			'prev_label' => " ⏩",
			'dir'    => 'rtl',
		];

		if ( ! is_null( $options['year'] ) && ! is_null( $options['month'] ) ) {
			$year  = $options['year'];
			$month = $options['month'];
		} elseif ( ! is_null( $options['format'] ) ) {
			$date  = explode( '-', $options['format'] );
			$year  = $date[0];
			$month = $date[1];
		} else {
			$now   = Jalalian::now();
			$month = $now->getMonth();
			$year  = $now->getYear();
		}

		$start = new Jalalian( $year, $month, 1, 0, 0, 0 );

		$numberDays = $start->getMonthDays();
		$monthName  = CalendarUtils::strftime( '%B', $start->getTimestamp() );
		$dayOfWeek  = $start->getDayOfWeek();

		$nextMonth = $start->addMonths( 1 )->format( 'Y-m' );

		$prevMonth = $start->subMonths( 1 )->format( 'Y-m' );
		if ( $month == $start->subMonths( 1 )->format( 'm' ) ) {
			$prevMonth = $start->subMonths( 1 )->subSeconds( 1 )->format( 'Y-m-d' );
		}

		$calendar    = [];
		$calendar[0] = [
			[ 'text' => $options['prev_label'], 'cb_data' => 'gotoMonth_' . $prevMonth ],
			[ 'text' => "$monthName ($year)", 'cb_data' => 'activeMonth' ],
			[ 'text' => $options['next_label'], 'cb_data' => 'gotoMonth_' . $nextMonth ]
		];
		$calendar[1] = [
			[ 'text' => 'ش', 'cb_data' => 'null' ],
			[ 'text' => 'ی', 'cb_data' => 'null' ],
			[ 'text' => 'د', 'cb_data' => 'null' ],
			[ 'text' => 'س', 'cb_data' => 'null' ],
			[ 'text' => 'چ', 'cb_data' => 'null' ],
			[ 'text' => 'پ', 'cb_data' => 'null' ],
			[ 'text' => 'ج', 'cb_data' => 'null' ],
		];

		$currentDay = 1;
		if ( $dayOfWeek >= 0 ) {
			for ( $i = 0; $i < $dayOfWeek; $i ++ ) {
				$calendar[2][ $i ] = [ 'text' => "-", 'cb_data' => 'null' ];
			}
		}

		$month = str_pad( $month, 2, "0", STR_PAD_LEFT );
		$row   = 2;
		while ( $currentDay <= $numberDays ) {
			if ( $dayOfWeek == 7 ) {
				$dayOfWeek = 0;
				$row ++;
			}
			$currentDayRel      = str_pad( $currentDay, 2, "0", STR_PAD_LEFT );
			$currentDate        = "$year-$month-$currentDayRel";
			$calendar[ $row ][] = [ 'text' => $currentDay, 'cb_data' => $currentDate ];
			$currentDay ++;
			$dayOfWeek ++;
		}

		if ( $dayOfWeek < 7 ) {
			for ( $i = $dayOfWeek; $i < 7; $i ++ ) {
				$calendar[ $row ][ $i ] = [ 'text' => '-', 'cb_data' => 'null' ];
			}
		}

		if ( $options['dir'] != 'rtl' ) {
			return $calendar;
		}

		$calendarRTL = [];
		foreach ( $calendar as $value ) {
			$calendarRTL[] = array_reverse( $value );
		}

		return $calendarRTL;
	}

}