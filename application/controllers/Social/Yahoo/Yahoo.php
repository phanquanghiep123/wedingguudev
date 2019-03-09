<?php
/**
 * Helper functions for OAuth
 */

/**
 * Build a query parameter string according to OAuth Spec.
 * @param array $params an array of query parameters
 * @return string all the query parameters properly sorted and encoded
 * according to the OAuth spec, or an empty string if params is empty.
 * @link http://oauth.net/core/1.0/#rfc.section.9.1.1
 */
class Yahoo
{
	private $debug = 0;
	function oauth_http_build_query($params, $excludeOauthParams=false)
	{
	  $query_string = '';
	  if (! empty($params)) {

	    // rfc3986 encode both keys and values
	    $keys = $this->rfc3986_encode(array_keys($params));
	    $values = $this->rfc3986_encode(array_values($params));
	    $params = array_combine($keys, $values);

	    // Parameters are sorted by name, using lexicographical byte value ordering.
	    // http://oauth.net/core/1.0/#rfc.section.9.1.1
	    uksort($params, 'strcmp');

	    // Turn params array into an array of "key=value" strings
	    $kvpairs = array();
	    foreach ($params as $k => $v) {
	      if ($excludeOauthParams && substr($k, 0, 5) == 'oauth') {
	        continue;
	      }
	      if (is_array($v)) {
	        // If two or more parameters share the same name,
	        // they are sorted by their value. OAuth Spec: 9.1.1 (1)
	        natsort($v);
	        foreach ($v as $value_for_same_key) {
	          array_push($kvpairs, ($k . '=' . $value_for_same_key));
	        }
	      } else {
	        // For each parameter, the name is separated from the corresponding
	        // value by an '=' character (ASCII code 61). OAuth Spec: 9.1.1 (2)
	        array_push($kvpairs, ($k . '=' . $v));
	      }
	    }

	    // Each name-value pair is separated by an '&' character, ASCII code 38.
	    // OAuth Spec: 9.1.1 (2)
	    $query_string = implode('&', $kvpairs);
	  }

	  return $query_string;
	}

	/**
	 * Parse a query string into an array.
	 * @param string $query_string an OAuth query parameter string
	 * @return array an array of query parameters
	 * @link http://oauth.net/core/1.0/#rfc.section.9.1.1
	 */
	function oauth_parse_str($query_string)
	{
	  $query_array = array();

	  if (isset($query_string)) {

	    // Separate single string into an array of "key=value" strings
	    $kvpairs = explode('&', $query_string);

	    // Separate each "key=value" string into an array[key] = value
	    foreach ($kvpairs as $pair) {
	      list($k, $v) = explode('=', $pair, 2);

	      // Handle the case where multiple values map to the same key
	      // by pulling those values into an array themselves
	      if (isset($query_array[$k])) {
	        // If the existing value is a scalar, turn it into an array
	        if (is_scalar($query_array[$k])) {
	          $query_array[$k] = array($query_array[$k]);
	        }
	        array_push($query_array[$k], $v);
	      } else {
	        $query_array[$k] = $v;
	      }
	    }
	  }

	  return $query_array;
	}

	/**
	 * Build an OAuth header for API calls
	 * @param array $params an array of query parameters
	 * @return string encoded for insertion into HTTP header of API call
	 */
	function build_oauth_header($params, $realm='')
	{
	  $header = 'Authorization: OAuth realm="' . $realm . '"';
	  foreach ($params as $k => $v) {
	    if (substr($k, 0, 5) == 'oauth') {
	      $header .= ',' . $this->rfc3986_encode($k) . '="' . $this->rfc3986_encode($v) . '"';
	    }
	  }
	  return $header;
	}

	/**
	 * Compute an OAuth PLAINTEXT signature
	 * @param string $consumer_secret
	 * @param string $token_secret
	 */
	function oauth_compute_plaintext_sig($consumer_secret, $token_secret)
	{
	  return ($consumer_secret . '&' . $token_secret);
	}

	/**
	 * Compute an OAuth HMAC-SHA1 signature
	 * @param string $http_method GET, POST, etc.
	 * @param string $url
	 * @param array $params an array of query parameters for the request
	 * @param string $consumer_secret
	 * @param string $token_secret
	 * @return string a base64_encoded hmac-sha1 signature
	 * @see http://oauth.net/core/1.0/#rfc.section.A.5.1
	 */
	function oauth_compute_hmac_sig($http_method, $url, $params, $consumer_secret, $token_secret)
	{
	  $base_string = $this->signature_base_string($http_method, $url, $params);
	  $signature_key = $this->rfc3986_encode($consumer_secret) . '&' . $this->rfc3986_encode($token_secret);
	  $sig = base64_encode(hash_hmac('sha1', $base_string, $signature_key, true));
	  if ($this->debug) {
	    $this->logit("oauth_compute_hmac_sig:DBG:sig:$sig");
	  }
	  return $sig;
	}

	/**
	 * Make the URL conform to the format scheme://host/path
	 * @param string $url
	 * @return string the url in the form of scheme://host/path
	 */
	function normalize_url($url)
	{
	  $parts = parse_url($url);
	  $scheme = @$parts['scheme'];
	  $host = @$parts['host'];
	  $port = @$parts['port'];
	  $path = @$parts['path'];

	  if (! $port) {
	    $port = ($scheme == 'https') ? '443' : '80';
	  }
	  if (($scheme == 'https' && $port != '443')
	      || ($scheme == 'http' && $port != '80')) {
	    $host = "$host:$port";
	  }

	  return "$scheme://$host$path";
	}

	/**
	 * Returns the normalized signature base string of this request
	 * @param string $http_method
	 * @param string $url
	 * @param array $params
	 * The base string is defined as the method, the url and the
	 * parameters (normalized), each urlencoded and the concated with &.
	 * @see http://oauth.net/core/1.0/#rfc.section.A.5.1
	 */
	function signature_base_string($http_method, $url, $params)
	{
	  // Decompose and pull query params out of the url
	  $query_str = parse_url($url, PHP_URL_QUERY);
	  if ($query_str) {
	    $parsed_query = $this->oauth_parse_str($query_str);
	    // merge params from the url with params array from caller
	    $params = array_merge($params, $parsed_query);
	  }

	  // Remove oauth_signature from params array if present
	  if (isset($params['oauth_signature'])) {
	    unset($params['oauth_signature']);
	  }

	  // Create the signature base string. Yes, the $params are double encoded.
	  $base_string = $this->rfc3986_encode(strtoupper($http_method)) . '&' .
	                 $this->rfc3986_encode($this->normalize_url($url)) . '&' .
	                 $this->rfc3986_encode($this->oauth_http_build_query($params));

	  $this->logit("signature_base_string:INFO:normalized_base_string:$base_string");

	  return $base_string;
	}

	/**
	 * Encode input per RFC 3986
	 * @param string|array $raw_input
	 * @return string|array properly rfc3986 encoded raw_input
	 * If an array is passed in, rfc3896 encode all elements of the array.
	 * @link http://oauth.net/core/1.0/#encoding_parameters
	 */
	function rfc3986_encode($raw_input)
	{
	  if (is_array($raw_input)) {
	    return array_map(array($this, 'rfc3986_encode'), $raw_input);
	  } else if (is_scalar($raw_input)) {
	    return str_replace('%7E', '~', rawurlencode($raw_input));
	  } else {
	    return '';
	  }
	}

	function rfc3986_decode($raw_input)
	{
	  return rawurldecode($raw_input);
	}

	function logit($msg,$preamble=true)
	{
	  //  date_default_timezone_set('America/Los_Angeles');
	  $now = date(DateTime::ISO8601, time());
	  error_log(($preamble ? "+++${now}:" : '') . $msg);
	}

	/**
	 * Do an HTTP GET
	 * @param string $url
	 * @param int $port (optional)
	 * @param array $headers an array of HTTP headers (optional)
	 * @return array ($info, $header, $response) on success or empty array on error.
	 */
	function do_get($url, $port=80, $headers=NULL)
	{
	  $retarr = array();  // Return value
	  
	  $curl_opts = array(CURLOPT_URL => $url,
	                     CURLOPT_PORT => $port,
	                     CURLOPT_POST => false,
	                     CURLOPT_SSL_VERIFYHOST => false,
	                     CURLOPT_SSL_VERIFYPEER => false,
	                     CURLOPT_RETURNTRANSFER => true);

	  if ($headers) { $curl_opts[CURLOPT_HTTPHEADER] = $headers; }
	 
	  $response = $this->do_curl($curl_opts);
	  
	  if (! empty($response)) { $retarr = $response; }
	  
	  return $retarr;
	}

	/**
	 * Do an HTTP POST
	 * @param string $url
	 * @param int $port (optional)
	 * @param array $headers an array of HTTP headers (optional)
	 * @return array ($info, $header, $response) on success or empty array on error.
	 */
	function do_post($url, $postbody, $port=80, $headers=NULL)
	{
	  $retarr = array();  // Return value

	  $curl_opts = array(CURLOPT_URL => $url,
	                     CURLOPT_PORT => $port,
	                     CURLOPT_POST => true,
	                     CURLOPT_SSL_VERIFYHOST => false,
	                     CURLOPT_SSL_VERIFYPEER => false,
	                     CURLOPT_POSTFIELDS => $postbody,
	                     CURLOPT_RETURNTRANSFER => true);

	  if ($headers) { $curl_opts[CURLOPT_HTTPHEADER] = $headers; }

	  $response = $this->do_curl($curl_opts);

	  if (! empty($response)) { $retarr = $response; }

	  return $retarr;
	}

	/**
	 * Make a curl call with given options.
	 * @param array $curl_opts an array of options to curl
	 * @return array ($info, $header, $response) on success or empty array on error.
	 */
	function do_curl($curl_opts)
	{
	  
	  $retarr = array();  // Return value
	 
	  if (! $curl_opts) {
	    if ($this->debug) { $this->logit("do_curl:ERR:curl_opts is empty"); }
	    return $retarr;
	  }

	 
	  // Open curl session
	  $ch = curl_init();
	   
	  if (! $ch) {
	    if ($this->debug) { $this->logit("do_curl:ERR:curl_init failed"); }
	    return $retarr;
	  }
	 
	  // Set curl options that were passed in
	  curl_setopt_array($ch, $curl_opts);

	  // Ensure that we receive full header
	  curl_setopt($ch, CURLOPT_HEADER, true);

	  if ($this->debug) {
	    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	    curl_setopt($ch, CURLOPT_VERBOSE, true);
	  }

	  // Send the request and get the response
	  ob_start();
	  $response = curl_exec($ch);
	  $curl_spew = ob_get_contents();
	  ob_end_clean();
	  if ($this->debug && $curl_spew){
	    $this->logit("do_curl:INFO:curl_spew begin");
	    $this->logit($curl_spew, false);
	    $this->logit("do_curl:INFO:curl_spew end");
	  }

	  // Check for errors
	  if (curl_errno($ch)) {
	    $errno = curl_errno($ch);
	    $errmsg = curl_error($ch);
	    if ($this->debug) { $this->logit("do_curl:ERR:$errno:$errmsg"); }
	    curl_close($ch);
	    unset($ch);
	    return $retarr;
	  }

	  if ($this->debug) {
	    $this->logit("do_curl:DBG:header sent begin");
	    $header_sent = curl_getinfo($ch, CURLINFO_HEADER_OUT);
	    $this->logit($header_sent, false);
	    $this->logit("do_curl:DBG:header sent end");
	  }

	  // Get information about the transfer
	  $info = curl_getinfo($ch);

	  // Parse out header and body
	  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	  $header = substr($response, 0, $header_size);
	  $body = substr($response, $header_size );

	  // Close curl session
	  curl_close($ch);
	  unset($ch);

	  if ($this->debug) {
	    $this->logit("do_curl:DBG:response received begin");
	    if (!empty($response)) { $this->logit($response, false); }
	    $this->logit("do_curl:DBG:response received end");
	  }

	  // Set return value
	  array_push($retarr, $info, $header, $body);

	  return $retarr;
	}

	/**
	 * Pretty print some JSON
	 * @param string $json The packed JSON as a string
	 * @param bool $html_output true if the output should be escaped
	 * (for use in HTML)
	 * @link http://us2.php.net/manual/en/function.json-encode.php#80339
	 */
	function json_pretty_print($json, $html_output=false)
	{
	  $spacer = '  ';
	  $level = 1;
	  $indent = 0; // current indentation level
	  $pretty_json = '';
	  $in_string = false;

	  $len = strlen($json);

	  for ($c = 0; $c < $len; $c++) {
	    $char = $json[$c];
	    switch ($char) {
	    case '{':
	    case '[':
	      if (!$in_string) {
	        $indent += $level;
	        $pretty_json .= $char . "\n" . str_repeat($spacer, $indent);
	      } else {
	        $pretty_json .= $char;
	      }
	      break;
	    case '}':
	    case ']':
	      if (!$in_string) {
	        $indent -= $level;
	        $pretty_json .= "\n" . str_repeat($spacer, $indent) . $char;
	      } else {
	        $pretty_json .= $char;
	      }
	      break;
	    case ',':
	      if (!$in_string) {
	        $pretty_json .= ",\n" . str_repeat($spacer, $indent);
	      } else {
	        $pretty_json .= $char;
	      }
	      break;
	    case ':':
	      if (!$in_string) {
	        $pretty_json .= ": ";
	      } else {
	        $pretty_json .= $char;
	      }
	      break;
	    case '"':
	      if ($c > 0 && $json[$c-1] != '\\') {
	        $in_string = !$in_string;
	      }
	    default:
	      $pretty_json .= $char;
	      break;
	    }
	  }

	  return ($html_output) ?
	    '<pre>' . htmlentities($pretty_json) . '</pre>' :
	    $pretty_json . "\n";
	}

	function callcontact_yahoo($consumer_key, $consumer_secret, $guid, $access_token, $access_token_secret, $usePost=false, $passOAuthInHeader=true)
	{
	  $retarr = array();  // return value
	  $response = array();
			
	  $url = 'https://social.yahooapis.com/v1/user/' . $guid . '/contacts;count=1000';
	  $params['format'] = 'json';
	  $params['view'] = 'compact';
	  $params['oauth_version'] = '1.0';
	  $params['oauth_nonce'] = mt_rand();
	  $params['oauth_timestamp'] = time();
	  $params['oauth_consumer_key'] = $consumer_key;
	  $params['oauth_token'] = $access_token;

	  // compute hmac-sha1 signature and add it to the params list
	  $params['oauth_signature_method'] = 'HMAC-SHA1';
	  $params['oauth_signature'] =$this->oauth_compute_hmac_sig($usePost? 'POST' : 'GET', $url, $params,
	                             $consumer_secret, $access_token_secret);

	  // Pass OAuth credentials in a separate header or in the query string
	  if ($passOAuthInHeader) {
	    $query_parameter_string = $this->oauth_http_build_query($params, true);
	    $header = $this->build_oauth_header($params, "yahooapis.com");
	    $headers[] = $header;
	  } else {
	    $query_parameter_string = $this->oauth_http_build_query($params);
	  }

	  // POST or GET the request
	  if ($usePost) {
	    $request_url = $url;
	    $this->logit("callcontact:INFO:request_url:$request_url");
	    $this->logit("callcontact:INFO:post_body:$query_parameter_string");
	    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
	    $response = $this->do_post($request_url, $query_parameter_string, 443, $headers);
	  } else {
	    $request_url = $url . ($query_parameter_string ?
	                           ('?' . $query_parameter_string) : '' );
	    $this->logit("callcontact:INFO:request_url:$request_url");
	    $response = $this->do_get($request_url, 443, $headers);
	  }
	  $result = array();
	  $yahoo_array = array();
	  if (! empty($response)) {
		  list($info, $header, $body) = $response;
		  if ($body) {
			  $yahoo_array = json_decode($body,true);
			  if(isset($yahoo_array['contacts']['contact']) && count($yahoo_array['contacts']['contact']) > 0){
			  		foreach($yahoo_array['contacts']['contact'] as $key => $values){
			  			if(isset($values['fields']) && count($values['fields']) > 0){
							$temp = array();
							foreach($values['fields'] as $keys => $values_sub){
								if(isset($values_sub['type'])){
									if($values_sub['type'] == 'name'){
										$temp['name'] = @$values_sub['value']['givenName'].' '.@$values_sub['value']['familyName'];
									}
									if($values_sub['type'] == 'email'){
										if(isset($values_sub['value']) && filter_var($values_sub['value'], FILTER_VALIDATE_EMAIL)){
											$temp['email'] = $values_sub['value'];
										}
									}
								}
							}
							if(isset($temp['email']) && $temp['email'] != null){
								$result[] = $temp;
							}
						}
					}
			  }
		  }
	  }

	  return $result;
	}
	function get_access_token_yahoo($consumer_key, $consumer_secret, $request_token, $request_token_secret, $oauth_verifier, $usePost=false, $useHmacSha1Sig=true, $passOAuthInHeader=true)
	{
	  $retarr = array();  // return value
	  $response = array();
	  $url = 'https://api.login.yahoo.com/oauth/v2/get_token';
	  $params['oauth_version'] = '1.0';
	  $params['oauth_nonce'] = mt_rand();
	  $params['oauth_timestamp'] = time();
	  $params['oauth_consumer_key'] = $consumer_key;
	  $params['oauth_token']= $request_token;
	  $params['oauth_verifier'] = $oauth_verifier;

	  // compute signature and add it to the params list
	  if ($useHmacSha1Sig) {
	    $params['oauth_signature_method'] = 'HMAC-SHA1';
	    $params['oauth_signature'] = $this->oauth_compute_hmac_sig($usePost? 'POST' : 'GET', $url, $params,
	                             $consumer_secret, $request_token_secret);
	  } else {
	    $params['oauth_signature_method'] = 'PLAINTEXT';
	    $params['oauth_signature'] = $this->oauth_compute_plaintext_sig($consumer_secret, $request_token_secret);
	  }

	  // Pass OAuth credentials in a separate header or in the query string
	  if ($passOAuthInHeader) {
	    $query_parameter_string = $this->oauth_http_build_query($params, false);
	    $header = $this->build_oauth_header($params, "yahooapis.com");
	    $headers[] = $header;
	  } else {
	    $query_parameter_string = $this->oauth_http_build_query($params);
	  }

	  // POST or GET the request
	  if ($usePost) {
	    $request_url = $url;
	    $this->logit("getacctok:INFO:request_url:$request_url");
	    $this->logit("getacctok:INFO:post_body:$query_parameter_string");
	    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
	    $response = $this->do_post($request_url, $query_parameter_string, 443, $headers);
	  } else {
	    $request_url = $url . ($query_parameter_string ?
	                           ('?' . $query_parameter_string) : '' );
	    $this->logit("getacctok:INFO:request_url:$request_url");
	    $response = $this->do_get($request_url, 443, $headers);
	  }

	  // extract successful response
	  if (! empty($response)) {
	    list($info, $header, $body) = $response;
	    $body_parsed = $this->oauth_parse_str($body);
	    if (! empty($body_parsed)) {
	      $this->logit("getacctok:INFO:response_body_parsed:");
	     // print_r($body_parsed);
	    }
	    $retarr = $response;
	    $retarr[] = $body_parsed;
	  }

	  return $retarr;
	}

	/* Function added for getting the request token */
	function get_request_token($consumer_key, $consumer_secret, $callback, $usePost=false, $useHmacSha1Sig=true, $passOAuthInHeader=false)
	{
	  $retarr = array();  // return value
	  $response = array();

	  $url = 'https://api.login.yahoo.com/oauth/v2/get_request_token';
	  $params['oauth_version'] = '1.0';
	  $params['oauth_nonce'] = mt_rand();
	  $params['oauth_timestamp'] = time();
	  $params['oauth_consumer_key'] = $consumer_key;
	  $params['oauth_callback'] = $callback;

	  // compute signature and add it to the params list
	  if ($useHmacSha1Sig) {
	    $params['oauth_signature_method'] = 'HMAC-SHA1';
	    $params['oauth_signature'] = $this->oauth_compute_hmac_sig($usePost? 'POST' : 'GET', $url, $params,
	                             $consumer_secret, null);
	  } else {
	    $params['oauth_signature_method'] = 'PLAINTEXT';
	    $params['oauth_signature'] = $this->oauth_compute_plaintext_sig($consumer_secret, null);
	  }

	  // Pass OAuth credentials in a separate header or in the query string
	  if ($passOAuthInHeader) {
	      
	    $query_parameter_string = $this->oauth_http_build_query($params, FALSE);
	    
	    $header = $this->build_oauth_header($params, "yahooapis.com");
	    $headers[] = $header;
	  } else {
	    $query_parameter_string = $this->oauth_http_build_query($params);
	  }
	 
	  // POST or GET the request
	  if ($usePost) {
	    $request_url = $url;
	    $this->logit("getreqtok:INFO:request_url:$request_url");
	    $this->logit("getreqtok:INFO:post_body:$query_parameter_string");
	    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
	    $response = $this->do_post($request_url, $query_parameter_string, 443, $headers);
	  } else {
	    $request_url = $url . ($query_parameter_string ?
	                           ('?' . $query_parameter_string) : '' );
	     
	    $this->logit("getreqtok:INFO:request_url:$request_url");
	    
	    $response = $this->do_get($request_url, 443, $headers);
	    
	  }
	  
	  // extract successful response
	  if (! empty($response)) {
	    list($info, $header, $body) = $response;
	    $body_parsed = $this->oauth_parse_str($body);
	    if (! empty($body_parsed)) {
	      $this->logit("getreqtok:INFO:response_body_parsed:");
	      //print_r($body_parsed);
	    }
	    $retarr = $response;
	    $retarr[] = $body_parsed;
	  }

	  return $retarr;
	}
}
