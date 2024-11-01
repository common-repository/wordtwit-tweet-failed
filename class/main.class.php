<?
class WordTwit_Error_Log{
	
	function __construct(){
		$this->WordTwit_Error_Log();
	}
	
	function WordTwit_Error_Log(){
		add_filter('wordtwit_tweet_log_error', array(&$this, 'fix_wt_log'), 99); // Must be last
		add_action('admin_init', array(&$this, 'register_admin'));
		add_action('admin_print_scripts', array(&$this, 'print_admin_deps'));	
	}
	
	function sidebar_content(){
		
		return '';
	}
	
	function register_admin(){
		wp_register_style('wtel_css', plugins_url('css/wtel.css', dirname(__FILE__)), '', '1.0');
		wp_register_script('wtel_js', plugins_url('js/wtel.js', dirname(__FILE__)), array('jquery'), '1.0');
	}
	
	function print_admin_deps(){
		wp_enqueue_script('wtel_js');
		wp_enqueue_style('wtel_css');
	}
	
	function fix_wt_log($r){
		global $wordtwit_tweet_log_entry;
	
		if(!empty($r)) return $r;
	
		$tweet_result = get_post_meta( $wordtwit_tweet_log_entry->ID, 'wordtwit_result', true );
		$output .= "<span class='jw_wt_errors'>";
		switch($tweet_result->code){
			case "304": 
				$output .= '<span class="error_tooltip">'.__("304: Not Modified", 'wtel').'</span>';
				$output .= '<span class="wt_log_tip">'.__('There was no new data to return.','wtel').'</span>';
				break;
			case "400": 
				$output .= __("400: Bad Request", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('The request was invalid. An accompanying error message will explain why. This is the status code will be returned during version 1.0 rate limiting. In API v1.1, a request without authentication is considered invalid and you will get this response.','wtel').'<br /><a href="https://dev.twitter.com/pages/rate-limiting" title="'.__('Twitter Docs on Rate Limiting', 'wtel').'">'.__('More information', 'wtel').'&raquo;</a></span>';
				break;
			case "401": 
				$output .= __("401: Unauthorized", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('Authentication credentials were missing or incorrect.','wtel').'<br /><a href="https://dev.twitter.com/pages/auth" target="_blank" title="'.__('Twitter Docs on Authentication Credentials', 'wtel').'">'.__('More information', 'wtel').'&raquo;</a></span>';
				break;
			case "403": 
				$output .= __("403: Forbidden", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('The request is understood, but it has been refused or access is not allowed. An accompanying error message will explain why. This code is used when requests are being denied due to update limits.','wtel').'<br /><a href="https://support.twitter.com/articles/15364-about-twitter-limits-update-api-dm-and-following" target="_blank" title="'.__('Twitter Docs on Update Limits', 'wtel').'">'.__('More information', 'wtel').'&raquo;</a></span>';
				break;
			case "404": 
				$output .= __("404: Not Found", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('The URI requested is invalid or the resource requested, such as a user, does not exists. Also returned when the requested format is not supported by the requested method.','wtel').'<br /><a href="https://dev.twitter.com/docs/error-codes-responses" target="_blank" title="'.__('Twitter Docs on Error Codes', 'wtel').'">'.__('More information', 'wtel').'&raquo;</a></span>';
				break;
			case "420": 
				$output .= __("420: Rate Limited", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('Returned by the version 1 Search and Trends APIs when you are being rate limited.','wtel').'<br /><a href="https://dev.twitter.com/docs/error-codes-responses" target="_blank" title="'.__('Twitter Docs on Error Codes', 'wtel').'">'.__('More information', 'wtel').'&raquo;</a></span>';
				break;
			case "429": 
				$output .= __("429: Rate Limited", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('Returned in API v1.1 when a request cannot be served due to the application\'s rate limit having been exhausted for the resource.','wtel').'<br /><a href="https://dev.twitter.com/docs/rate-limiting/1.1" target="_blank" title="'.__('Twitter Docs on Rate Limiting in API v1.1', 'wtel').'">'.__('More information', 'wtel').'&raquo;</a></span>';
				break;
			case "500": 
				$output .= __("500: Internal Server Error", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('Something is broken on Twitter\'s end, there is nothing you can do except wait.','wtel').'</span>';
				break;
			case "503": 
				$output .= __("503: Service Unavailable", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('The Twitter servers are up, but overloaded with requests. Try again later.','wtel').'</span>';
				break;
			case "504": 
				$output .= __("504: Twitter Gateway Down", 'wtel');
				$output .= '<span class="wt_log_tip">'.__('The Twitter servers are up, but the request couldn\'t be serviced due to some failure within our stack. Try again later.','wtel').'</span>';
				break;
			default: 
				$output .= sprintf(__("Error %s Unknown", 'wtel'), $tweet_result->code);
				$output .= '<span class="wt_log_tip">'.__('This status code is not documented by Twitter','wtel').'</span>';
				break;
		}
		$output .= "</span>";
		return $output;
		
	}
}
?>