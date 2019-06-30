<?php

use ehsansabet\GapUtils\InlineCalendar;
use PHPUnit\Framework\TestCase;

/**
 *  Corresponding Class to test Gap robot utils class
 *
 * @author Ehsan Sabet (ehsan.sabet@hotmail.com)
 */
class InlineCalendarTest extends TestCase {

	public function testIsThereAnySyntaxError() {
		$var = new ehsansabet\GapUtils\InlineCalendar;
		$this->assertTrue( is_object( $var ) );
		unset( $var );
	}

	public function testCalendar() {
		$show = '[[{"text":"\u23ea ","cb_data":"1398-05"},{"text":"1398","cb_data":"1398"},{"text":"\u062a\u06cc\u0631","cb_data":"1398"},{"text":" \u23e9","cb_data":"1398-03"}],[{"text":"\u062c","cb_data":"null"},{"text":"\u067e","cb_data":"null"},{"text":"\u0686","cb_data":"null"},{"text":"\u0633","cb_data":"null"},{"text":"\u062f","cb_data":"null"},{"text":"\u06cc","cb_data":"null"},{"text":"\u0634","cb_data":"null"}],[{"text":7,"cb_data":"1398-04-07"},{"text":6,"cb_data":"1398-04-06"},{"text":5,"cb_data":"1398-04-05"},{"text":4,"cb_data":"1398-04-04"},{"text":3,"cb_data":"1398-04-03"},{"text":2,"cb_data":"1398-04-02"},{"text":1,"cb_data":"1398-04-01"}],[{"text":14,"cb_data":"1398-04-14"},{"text":13,"cb_data":"1398-04-13"},{"text":12,"cb_data":"1398-04-12"},{"text":11,"cb_data":"1398-04-11"},{"text":10,"cb_data":"1398-04-10"},{"text":9,"cb_data":"1398-04-09"},{"text":8,"cb_data":"1398-04-08"}],[{"text":21,"cb_data":"1398-04-21"},{"text":20,"cb_data":"1398-04-20"},{"text":19,"cb_data":"1398-04-19"},{"text":18,"cb_data":"1398-04-18"},{"text":17,"cb_data":"1398-04-17"},{"text":16,"cb_data":"1398-04-16"},{"text":15,"cb_data":"1398-04-15"}],[{"text":28,"cb_data":"1398-04-28"},{"text":27,"cb_data":"1398-04-27"},{"text":26,"cb_data":"1398-04-26"},{"text":25,"cb_data":"1398-04-25"},{"text":24,"cb_data":"1398-04-24"},{"text":23,"cb_data":"1398-04-23"},{"text":22,"cb_data":"1398-04-22"}],[{"text":"-","cb_data":"null"},{"text":"-","cb_data":"null"},{"text":"-","cb_data":"null"},{"text":"-","cb_data":"null"},{"text":31,"cb_data":"1398-04-31"},{"text":30,"cb_data":"1398-04-30"},{"text":29,"cb_data":"1398-04-29"}]]';
		$this->assertTrue( json_encode( InlineCalendar::show( [ 'format' => '1398-4' ] ) ) == $show );
	}
}
