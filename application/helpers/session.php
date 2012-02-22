<?php
namespace Helper;

class Session
{
	function __set($key, $val)
	{
		$_SESSION[$key] = $val;
	}
	
	function __get($key)
	{
		if(isset($_SESSION[$key]))
			return $_SESSION[$key];
		
		return NULL;
	}
	
	function destroy()
	{
		session_destroy();
	}

}

?>
