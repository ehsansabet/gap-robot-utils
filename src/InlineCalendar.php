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
			'monthRowType' => '3*4',
			'dir'    => 'rtl',
		];
		$showMonth = false;
		$showListMonths = false;
		$calendar = [];

		if ( ! is_null( $options['year'] ) && ! is_null( $options['month'] ) ) {
			$year  = $options['year'];
			$month = $options['month'];
			$showMonth = true;
		} elseif ( ! is_null( $options['format'] ) ) {
			$date  = explode( '-', $options['format'] );
			$year  = $date[0] ?? null;
			$month = $date[1] ?? null;

			if(!empty($year) && !empty($month)){
				$showMonth = true;
			}else{
				$showListMonths = true;
			}

		} else {
			$now   = Jalalian::now();
			$month = $now->getMonth();
			$year  = $now->getYear();
			$showMonth = true;
		}

		if($showListMonths){
			$start = new Jalalian( $year, 1, 5, 0, 0, 0 );
			$nextYear = $start->addYears( 1 )->format( 'Y' );
			$prevYear = $start->subYears( 1 )->format( 'Y' );

			if($options['monthRowType'] == '4*3') {
				$calendar = [
					[
						['text' => $options['prev_label'], 'cb_data' => $prevYear],
						['text' => "انتخاب ماه", 'cb_data' => $year],
						['text' => "$year", 'cb_data' => $year . "-0"],
						['text' => $options['next_label'], 'cb_data' => $nextYear]
					],
					[
						['text' => 'فروردین', 'cb_data' => $year . '-1'],
						['text' => 'اردیبهشت', 'cb_data' => $year . '-2'],
						['text' => 'خرداد', 'cb_data' => $year . '-3'],
					],
					[
						['text' => 'تیر', 'cb_data' => $year . '-4'],
						['text' => 'مرداد', 'cb_data' => $year . '-5'],
						['text' => 'شهریور', 'cb_data' => $year . '-6'],
					],
					[
						['text' => 'مهر', 'cb_data' => $year . '-7'],
						['text' => 'آبان', 'cb_data' => $year . '-8'],
						['text' => 'آذر', 'cb_data' => $year . '-9'],
					],
					[
						['text' => 'دی', 'cb_data' => $year . '-10'],
						['text' => 'بهمن', 'cb_data' => $year . '-11'],
						['text' => 'اسفند', 'cb_data' => $year . '-12'],
					]
				];
			}

			if($options['monthRowType'] == '3*4'){
				$calendar = [
					[
						[ 'text' => $options['prev_label'] , 'cb_data' => $prevYear ],
						[ 'text' => "انتخاب ماه", 'cb_data' => $year ],
						[ 'text' => "$year", 'cb_data' => $year."-0" ],
						[ 'text' => $options['next_label'], 'cb_data' => $nextYear ]
					],
					[
						[ 'text' => 'فروردین', 'cb_data' => $year.'-1' ],
						[ 'text' => 'تیر', 'cb_data' => $year.'-4' ],
						[ 'text' => 'مهر', 'cb_data' => $year.'-7' ],
						[ 'text' => 'دی', 'cb_data' => $year.'-10' ],
					],
					[
						[ 'text' => 'اردیبهشت', 'cb_data' => $year.'-2' ],
						[ 'text' => 'مرداد', 'cb_data' => $year.'-5' ],
						[ 'text' => 'آبان', 'cb_data' => $year.'-8' ],
						[ 'text' => 'بهمن', 'cb_data' => $year.'-11' ],
					],
					[
						[ 'text' => 'خرداد', 'cb_data' => $year.'-3' ],
						[ 'text' => 'شهریور', 'cb_data' => $year.'-6' ],
						[ 'text' => 'آذر', 'cb_data' => $year.'-9' ],
						[ 'text' => 'اسفند', 'cb_data' => $year.'-12' ],
					]
				];
			}
		}

		if($showMonth){
			$start = new Jalalian( $year, $month, 1, 0, 0, 0 );

			$numberDays = $start->getMonthDays();
			$monthName  = CalendarUtils::strftime( '%B', $start->getTimestamp() );
			$dayOfWeek  = $start->getDayOfWeek();

			$nextMonth = $start->addMonths( 1 )->format( 'Y-m' );

			$prevMonth = $start->subMonths( 1 )->format( 'Y-m' );
			if ( $month == $start->subMonths( 1 )->format( 'm' ) ) {
				$prevMonth = $start->subMonths( 1 )->subSeconds( 1 )->format( 'Y-m' );
			}

			$calendar[0] = [
				[ 'text' => $options['prev_label'], 'cb_data' => $prevMonth ],
				[ 'text' => "$monthName", 'cb_data' => $year ],
				[ 'text' => "$year", 'cb_data' => $year],
				[ 'text' => $options['next_label'], 'cb_data' => $nextMonth ]
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