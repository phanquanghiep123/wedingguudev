<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_format_datetime_list() {
    $formats = array("Y-m-d H:i:s", "d/m/Y H:i:s", "l jS \of F Y h:i:s A");

    return $formats;
}