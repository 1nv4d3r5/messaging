<?php

class functions {
	public static function getPepper() {
		return 'WA£ZSXDRCFT213VGYB_HNU';
	}
	
	public static function generateHash($params) {
		return sha1($params['salt'] . $params['password'] . $params['pepper']);
	}
}