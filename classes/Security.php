<?php


namespace app\classes;

/**
 * Security class
 *
 * Class Security
 * @package app\classes
 * @author  Juan Monsalve
 */
class Security{

    CONST ENCRYPT_METHOD = "AES-256-CBC";

    CONST SECRET_KEY = 'ijsb';

    CONST SECRET_IV = 'ijsb123';


    public static function getInstance(){
    	
    	return new self();
    }
    
	public function encrypt($string){

		$output = false;

		// hash
    	$key = hash('sha256', self::SECRET_KEY);
    
    	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    	$iv = substr(hash('sha256', self::SECRET_IV), 0, 16);

    	$output = openssl_encrypt($string, self::ENCRYPT_METHOD, $key, 0, $iv);
        $output = base64_encode($output);

		return $output;
	}	

	public function decrypt($string){

		// hash
    	$key = hash('sha256', self::SECRET_KEY);
    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', self::SECRET_IV), 0, 16);
		//decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), self::ENCRYPT_METHOD, $key, 0, $iv);

        return $output;
	}
}

?>