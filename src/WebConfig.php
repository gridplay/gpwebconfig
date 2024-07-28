<?php
namespace WebConfig;
use Log;
use Illuminate\Support\Facades\Storage;
class WebConfig {
	private static function randcode($length, $min = 0) {
		if ($min > 0) {
			$length = rand($min, $length);
		}
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ';
		return substr(str_shuffle($chars),0,$length);
	}
	public static function genCode($data = [], $length = 0) {
		if ($length == 0) {
			$length = config('gpwebconfig.code_length');
		}
		$code = self::randcode($length, 4);
		$seconds = config('gpwebconfig.expiration') * 60;
		$expire = time() + $seconds;
		$data['code_expire'] = $expire;
		$folder = config('gpwebconfig.folder');
		if (Storage::put($folder.'/'.$code.'.json', json_encode($data))) {
			return $code;
		}
		return "";
	}
	public static function ValidateCode($code) {
		$folder = config('gpwebconfig.folder');
		$s = Storage::json($folder.'/'.$code.".json");
		if (is_array($s)) {
			$expire = time();
			if (array_key_exists('code_expire', $s)) {
				$expire = $s['code_expire'];
			}
			if ($expire >= time()) {
				return $s;
			}
		}
		return null;
	}
	public static function getExpiration($code) {
		$folder = config('gpwebconfig.folder');
		$s = Storage::json($folder.'/'.$code.'.json');
		if (is_array($s)) {
			if (array_key_exists('code_expire', $s)) {
				return $s['code_expire'];
			}
		}
		return 0;
	}
	public static function deleteCode($code) {
		$folder = config('gpwebconfig.folder');
		if (Storage::exists($folder.'/'.$code.'.json')) {
			Storage::delete([$code.'.json']);
		}
	}
}