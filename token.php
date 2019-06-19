<?php
$address = "localhost";
$service_port = 8888;

class Token
{
	public $address = "127.0.0.1";
	public $service_port = 80;
	public function __construct($address = null, $service_port = null)
	{
		if($address != null)
		{
			$this->address = $address;
		}
		if($service_port != null)
		{
			$this->service_port = $service_port;
		}
	}
	public function getToken($partners = null)
	{
		$empty_request = false;
		$partners_object = array();
		if($partners == null)
		{
			$partners = array();
			$empty_request = true;
		}
		if(!is_array($partners))
		{
			$tmp = $partners;
			unset($partners);
			$partners = explode(',', $tmp);
			foreach($partners as $key=>$val)
			{
				$partners[$key] = trim($val);
			}
			foreach($partners as $key=>$val)
			{
				$partners_object[] = array('code'=>$val);
			}
		}
		else if(is_array($partners))
		{
			foreach($partners as $key=>$val)
			{
				if(is_scalar($val))
				{
					$partners_object[] = array('code'=>$val);
				}
				else
				{
					$partners_object[] = $val;
				}
			}
		}
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) 
		{
			echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
		} 
		else 
		{
		}
		
		$result = socket_connect($socket, $this->address, $this->service_port);
		if ($result === false) 
		{
			echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
		} 
		else 
		{
			$cl = "";
			do{
				if(stripos($cl, "\r\n\r\n") !== false) 
				{
					break;
				}
				$out = socket_read($socket, 1);
				$cl .= $out;
			}
			while($out != null);
			$content_length = trim($cl, "\r\n");
			$content = socket_read($socket, $content_length*1);
			$token = json_decode($content, true);
			
			
			if(!$empty_request)
			{
				$data = array(
					'command'=>'get-token',
					'data'=>array(
						'partner'=>$partners_object
					)
				);
				print_r($data);
				$in = json_encode($data);
				$data2sent = strlen($in)."\r\n\r\n".$in;
				socket_write($socket, $data2sent, strlen($data2sent));
				$cl = "";
				do
				{
					if(stripos($cl, "\r\n\r\n") !== false) 
					{
						break;
					}
					$out = socket_read($socket, 1);
					$cl .= $out;
				}
				while($out != null);
				$content_length = trim($cl, "\r\n");
				$content = socket_read($socket, $content_length*1);
				$token = json_decode($content, true);

			}

			socket_close($socket);
			return $token;
		}
	}
	public function updateToken($partner)
	{
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) 
		{
			echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
		} 
		else 
		{
		}
		
		$result = socket_connect($socket, $this->address, $this->service_port);
		if ($result === false) 
		{
			echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
		} 
		else 
		{
			$cl = "";
			do{
				if(stripos($cl, "\r\n\r\n") !== false) 
				{
					break;
				}
				$out = socket_read($socket, 1);
				$cl .= $out;
			}
			while($out != null);
			$content_length = trim($cl, "\r\n");
			$content = socket_read($socket, $content_length*1);
			$token = json_decode($content, true);
			
			
			$data = array(
				'command'=>'update-token',
				'data'=>array(
					'partner'=>array(array('code'=>$partner))
				)
			);
			print_r($data);
			$in = json_encode($data);
			$data2sent = strlen($in)."\r\n\r\n".$in;
			socket_write($socket, $data2sent, strlen($data2sent));
			$cl = "";
			do
			{
				if(stripos($cl, "\r\n\r\n") !== false) 
				{
					break;
				}
				$out = socket_read($socket, 1);
				$cl .= $out;
			}
			while($out != null);
			$content_length = trim($cl, "\r\n");
			$content = socket_read($socket, $content_length*1);
			$token = json_decode($content, true);


			socket_close($socket);
			return $token;
		}
	}
}


?>
