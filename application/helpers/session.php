<?php
namespace Helper;

class Session {

	function set($key, $val)
	{
		$_SESSION["$key"] = $val;
	}
	
	function get($key)
	{
		return $_SESSION["$key"];
	}
	
	function destroy()
	{
		session_destroy();
	}

}

?>
