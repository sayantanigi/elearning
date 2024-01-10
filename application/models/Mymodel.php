<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Mymodel extends MY_Model {



	public function insert($table, $data)

	{

		if($this->db->insert($table, $data)) {

			return true;

		} else {

			return false;

		}

	}



	public function getApprovalStatus($userId)

	{

		$user = $this->select('approval', 'users', true, ['userId' => $userId]);

		return $user->approval;

	}



	public function getSettings()

	{

		return $this->get('settings', true, 'settingId', '1');

	}

	public function add_details($tbl,$data)

	{

		$this->db->insert($tbl,$data);

		$lastid= $this->db->insert_id();

		return $lastid;		

	}





	public function getCatgoryTitle($cid)

	{

		$info = $this->select('categoryName', 'category', true, ['categoryId' => $cid]);

		return $info->categoryName;

	}

	public function getSubCatgoryTitle($cid)

	{

		$info = $this->select('subcategoryName', 'subcategory', true, ['subcategoryId' => $cid]);

		return $info->subcategoryName;

	}



	public function getTotalPayment($bookingId)

	{

		$sql = "SELECT SUM(amount) AS total FROM booking_order_payment WHERE bookingId = '$bookingId' AND status=1";

	 	$total=$this->fetch($sql, true)->total;

	 	if(empty($total))

	 	{

	 		$total = "0.00";

	 	} 

		return $total;

	}

	/* get currency symbol */

    public function get_currency_symbol($cc = 'USD')

    {

        $cc       = strtoupper($cc);

        $currency = array(

            "USD" => "$", //U.S. Dollar

            "AUD" => "A$", //Australian Dollar

            "BRL" => "R$", //Brazilian Real

            "CAD" => "C$", //Canadian Dollar

            "XCD" => "X$", //Caribbean island currency Dollar

            "CZK" => "Kč", //Czech Koruna

            "DKK" => "kr", //Danish Krone

            "EUR" => "€", //Euro

            "HKD" => "&#36", //Hong Kong Dollar

            "HUF" => "Ft", //Hungarian Forint

            "ILS" => "₪", //Israeli New Sheqel

            "INR" => "₹", //Indian Rupee

            "JPY" => "¥", //Japanese Yen

            "MYR" => "RM", //Malaysian Ringgit

            "MXN" => "&#36", //Mexican Peso

            "NOK" => "kr", //Norwegian Krone

            "NZD" => "&#36", //New Zealand Dollar

            "PHP" => "₱", //Philippine Peso

            "PLN" => "zł", //Polish Zloty

            "GBP" => "£", //Pound Sterling

            "SEK" => "kr", //Swedish Krona

            "CHF" => "Fr", //Swiss Franc

            "TWD" => "$", //Taiwan New Dollar

            "THB" => "฿", //Thai Baht

            "TRY" => "₺", //Turkish Lira

        );



        if (array_key_exists($cc, $currency)) {

            return $currency[$cc];

        }

    }









public function my_encrypt($data)

{

	return $this->my_simple_crypt($data, 'e');

}



public function my_decrypt($data) 

{

	return $this->my_simple_crypt($data, 'd');

}



public function my_simple_crypt( $string, $action='e') 

{

	$secret_key = HASH_KEY;

	$secret_iv = HASH_KEY;

	$output = false;

	$encrypt_method = "AES-256-CBC";

	$key = hash('sha256', $secret_key);

	$iv = substr(hash('sha256', $secret_iv), 0, 16 );



	if ($action =='e')

	{

		$output = urlencode(base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv)));

	} else if ($action =='d') 

	{

		$output = urldecode(openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv));

	}

	return $output;

}



public function myUrlEncode($string) 

{

	$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');

	$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");

	return str_replace($entities, $replacements, urlencode($string));

}





function randString($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789')

{

	$str = '';

	$count = strlen($charset);

	while ($length--) {

		$str .= $charset[mt_rand(0, $count-1)];

	}



	return $str;

}



	function curl_get_file_contents($URL)

	{

		$c = curl_init();

		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($c, CURLOPT_URL, $URL);

		$contents = curl_exec($c);

		curl_close($c);

		if ($contents) return $contents;

		else return FALSE;

	}



	public function getCity($lat, $lng)

	{

		

		$url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&result_type=locality&key=AIzaSyC-lvMq8NKOfWvoc-hLJuKJ3k-Y0itifgc';

		$json = $this->curl_get_file_contents($url);

		$data = json_decode($json);

		$status = @$data->status;

		$city ='';

		if($status=="OK") 

		{



			for ($j=0; $j<count($data->results[0]->address_components); $j++) 

			{

				$cn=array($data->results[0]->address_components[$j]->types[0]);

				if(in_array("locality", $cn)) 

				{

					$city= $data->results[0]->address_components[$j]->long_name;

				}

			}

		} else{

			//echo 'Location Not Found';

		}

		return $city;

	}

	public function hoursandmins($time, $format = '%02d:%02d')
	{
		if ($time < 1) {
			return;
		}
		$hours = floor($time / 60);
		$minutes = ($time % 60);
		return sprintf($format, $hours, $minutes);
	}

	public function GetData($table_name='',$condition=array()){
		
		if($condition && count($condition)){
			foreach($condition as $k=>$v)
		    $this->db->where($k,$v);
		}
		return $this->db->get($table_name)->result_array();
	}

}

