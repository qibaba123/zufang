<?php
class Logger {
	public static function info($msg) {
		IF (! ON_LINE) {
			echo "<br/>";
			echo '【INFO】', $msg;
			echo "<br/>";
		}
	}
	public static function debug($msg) {
		if (DEBUG) {
			echo "<br/>";
			echo "【DEBUG】", $msg;
			echo "<br/>";
		}
	}
	public static function error($msg) {
		IF (!ON_LINE) {
			echo "<br/>";
			echo "【ERROR】", $msg;
			echo "<br/>";
		}
	}
}

?>