<?php
	require_once(dirname(__FILE__) . "/license.php");
	require_once(dirname(__FILE__) . "/localization.php");
	require_once(dirname(__FILE__) . "/base64.php");
	require_once(dirname(__FILE__) . "/../include/tag_support.inc.php");
	require_once(dirname(__FILE__) . "/../include/common.inc.php");

	/**
	 *	@class SingularLicense
	 *	@short Helper class to handle Singular software licenses.
	 */
	class SingularLicense extends License
	{		
		/**
		 *	@short Constant for single user license type.
		 */
		const SINGLE_USER_LICENSE = 0;

		/**
		 *	@short Constant for familypack license type.
		 */
		const FAMILYPACK_LICENSE = 1;

		/**
		 *	@short Constant for site license type.
		 */
		const SITE_LICENSE = 2;
		
		/**
		 *	@short Constant for the default license duration (365 days).
		 */
		const DEFAULT_LICENSE_DURATION = 31536000;
		
		/**
		 *	@fn SingularLicense($name, $email, $key)
		 *	@short Constructor for SingularLicense objects.
		 */
		public function SingularLicense($name = '', $email = '', $key = '')
		{
			$this->username = $name;
			$this->email = $email;
			$this->key = $key;
			
			$this->init();
		}
		
		/**
		 *	@fn init
		 *	@short Initializes a SingularLicense object.
		 */
		protected function init()
		{
			if (self::valid_key($this->key,
				$this->username,
				$cleartext))
			{
				$cleartext_parts = explode(';', $cleartext);
				$this->registration_date = strtotime($cleartext_parts[1]);
				$this->expiration_date = strtotime($cleartext_parts[2]);
				$this->license_type = $cleartext_parts[3];
			}
		}
		
		/**
		 *	@fn parse_url($the_url)
		 *	@short Creates a SingularLicense object from an activation URL.
		 *	@param the_url The URL to parse.
		 */
		public static function parse_url($the_url)
		{
			$license = NULL;
			$parts = explode('/', $the_url);
			if (count($parts) == 6)
			{
				$email = rawurldecode($parts[3]);
				$username = rawurldecode($parts[4]);
				$key = rawurldecode($parts[5]);
				
				$license = new self($username,
					$email,
					$key);
			}
			return $license;
		}
		
		/**
		 *	@fn generate_key($username, $registration_date, $expiration_date, $license_type)
		 *	@short Singular license generator
		 */
		public static function generate_key($username,
			$registration_date = NULL,
			$expiration_date = NULL,
			$license_type = SingularLicense::SINGLE_USER_LICENSE)
		{
			$key = NULL;
			
			// Convert from ISO-8859-1 to UTF-8
			$username = iconv("iso-8859-1", "utf-8", $username);
			// Calculate SHA-1 hash
			$hash = sha1($username);
			// License start date
			if (empty($registration_date))
			{
				$registration_date = date("Y-m-d");
			}
			// License expiration date
			if (empty($expiration_date))
			{
				$expiration_date = date("Y-m-d", time() + SingularLicense::DEFAULT_LICENSE_DURATION);
			}
			// Digest to cypher
			$digest = "{$hash};{$registration_date};{$expiration_date};{$license_type}";

			$priv_key_path = dirname(__FILE__) . "/../openssl/singular_private_key.pem";
			
			if (file_exists($priv_key_path))
			{
				$fp = fopen($priv_key_path,"r");
				$priv_key = fread($fp, filesize($priv_key_path));
				fclose($fp);
				// $passphrase is required if your key is encoded (suggested)
				$passphrase = '';
				if (($res = openssl_get_privatekey($priv_key, $passphrase)) !== FALSE)
				{
					/*
					 * NOTE:  Here you use the returned resource value
					 */
					openssl_private_encrypt($digest, $crypttext, $res);
					// Calculate the key
					$key = Base64::encode_linelength($crypttext, 32);
				}
			}
			return $key;
		}
		
		/**
		 *	@fn function valid_key($key, $username, $cleartext)
		 *	@short Singular license validator
		 */
		public static function valid_key($key,
			$username = '',
			&$cleartext = NULL)
		{
			$valid = FALSE;
			
			if (strlen($key) > 0 &&
				strlen($username) > 0)
			{
				// Convert from ISO-8859-1 to UTF-8
				$username = iconv("iso-8859-1", "utf-8", $username);
				// Calculate SHA-1 hash
				$hash = sha1($username);
				// 
				$raw_key = Base64::decode($key);
	
				$pub_key_path = dirname(__FILE__) . "/../openssl/singular_public_key.pem";
				
				if (file_exists($pub_key_path))
				{
					$fp = fopen($pub_key_path, "r");
					$pub_key = fread($fp, filesize($pub_key_path));
					fclose($fp);
					if (($res = openssl_get_publickey($pub_key)) !== FALSE)
					{
						/*
						 * NOTE:  Here you use the returned resource value
						 */
						openssl_public_decrypt($raw_key, $cleartext, $res);
						
						$cleartext_parts = explode(';', $cleartext);
						$valid = $cleartext_parts[0] == $hash;
					}
				}
			}
			return $valid;
		}
		
		/**
		 *	@fn activation_link($text)
		 *	@short Creates a hyperlink that activates a copy of Singular.
		 *	@text An optional label for the hyperlink.
		 */
		public function activation_link($text = NULL)
		{
			if (empty($text))
			{
				$text = l('Click here to activate Singular');
			}
			return a($text, array('href' => $this->activation_url()));
		}
		
		/**
		 *	@fn activation_url
		 *	@short Creates an activation URL that can activate a copy of Singular.
		 */
		public function activation_url()
		{
			return sprintf('singular://register/%s/%s/%s',
				rawurlencode($this->email),
				rawurlencode($this->username),
				rawurlencode($this->key));
		}
	}

?>