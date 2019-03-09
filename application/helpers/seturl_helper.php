<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('skin_url'))
{
	function skin_url($url="")
	{ 
		return base_url("skins/".$url."");
	}
}

if ( ! function_exists('skin_frontend'))
{
	function skin_frontend($url="")
	{ 
		return base_url(SKIN."/".FRONTEND."/".$url."");
	}
}

if ( ! function_exists('skin_backend'))
{
	function skin_backend($url="")
	{ 
		return base_url(SKIN."/".BACKEND."/".$url."");
	}
}

if ( ! function_exists('backend_url')) 
{
	function backend_url($path='') 
	{
		$url = BACKEND.'/'.$path;
		$url = str_replace("///","/",$url);
		$url = str_replace("//","/",$url);
		return base_url($url);
	}
};

