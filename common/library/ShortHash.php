<?php
namespace common\library;
define('MD5_24_ALPHABET', '0123456789abcdefghijklmnopqrstuvwxyzABCDE');
class ShortHash{
	public static function MD5_24($str) {
		return self::RawToShortMD5(MD5_24_ALPHABET, md5($str, true));
	}
	
	public static function MD5File_24($file) {
		return self::RawToShortMD5(MD5_24_ALPHABET, md5_file($file, true));
	}
	
	public static function MD5_RawTo24($str) {
		return self::RawToShortMD5(MD5_24_ALPHABET, $str);
	}
	
	public static function MD5_32to24($hash32) {
		return self::RawToShortMD5(MD5_24_ALPHABET, self::MD5ToRaw($hash32));
	}
	
	public static function MD5_24toRaw($hash24) {
		return self::ShortToRawMD5(MD5_24_ALPHABET, $hash24);
	}
	
	public static function MD5_24to32($hash24) {
		return self::RawToMD5(self::ShortToRawMD5(MD5_24_ALPHABET, $hash24));
	}
	
	public static function RawToShortMD5($alphabet, $raw) {
		$result = '';
		$length = strlen(self::DecToBase($alphabet, 2147483647));
	
		foreach (str_split($raw, 4) as $dword) {
			$dword = ord($dword[0]) + ord($dword[1]) * 256 + ord($dword[2]) * 65536 + ord($dword[3]) * 16777216;
			$result .= str_pad(self::DecToBase($alphabet, $dword), $length, $alphabet[0], STR_PAD_LEFT);
		}
	
		return $result;
	}
	
	public static function DecToBase($alphabet, $dword) {
		$rem = (int) fmod($dword, strlen($alphabet));
		if ($dword < strlen($alphabet)) {
			return $alphabet[$rem];
		} else {
			return self::DecToBase($alphabet, ($dword - $rem) / strlen($alphabet)).$alphabet[$rem];
		}
	}
	
	public static function ShortToRawMD5($alphabet, $short) {
		$result = '';
		$length = strlen(self::DecToBase($alphabet, 2147483647));
	
		foreach (str_split($short, $length) as $chunk) {
			$dword = self::BaseToDec($alphabet, $chunk);
			$result .= chr($dword & 0xFF) . chr($dword >> 8 & 0xFF) . chr($dword >> 16 & 0xFF) . chr($dword >> 24);
		}
	
		return $result;
	}
	
	public static function BaseToDec($alphabet, $str) {
		$result = 0;
		$prod = 1;
	
		for ($i = strlen($str) - 1; $i >= 0; --$i) {
			$weight = strpos($alphabet, $str[$i]);
			if ($weight === false) {
				throw new Exception('BaseToDec failed - encountered a character outside of given alphabet.');
			}
	
			$result += $weight * $prod;
			$prod *= strlen($alphabet);
		}
	
		return $result;
	}
	
	public static function MD5ToRaw($str) { return pack('H*', $str); }
	public static function RawToMD5($raw) { return bin2hex($raw); }
}