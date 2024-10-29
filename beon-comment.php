<?php
/**
 * @package Beon_blocking comment
 * @version 1.1
 */
/*
Plugin Name: Beon Blocking Comment
Plugin URI: http://beon.co.id
Description: This plugin will make your wordpress more secure on comment
Author: Beon Intermedia
Version: 1.1
*/

	function curl_stopforumspam(){
		
		$IP = "http://api.stopforumspam.org/api?ip=".$_SERVER['REMOTE_ADDR'];
		$ch = curl_init(); 
		// set url 
		curl_setopt($ch, CURLOPT_URL, $IP); 
		//return the transfer as a string 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		// $output contains the output string 
		$output = curl_exec($ch); 
		// close curl resource to free up system resources 
		curl_close($ch); 
		
		$explode = explode(PHP_EOL, $output);
		
		return $explode;

	}
	
	//fungsi buat check gravatar
	function validate_gravatar($email) {
		// Craft a potential url and test its headers
		$hash = md5(strtolower(trim($email)));
		$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
		$headers = @get_headers($uri);
		if (!preg_match("|200|", $headers[0])) {
			$has_valid_avatar = FALSE;
		} else {
			$has_valid_avatar = TRUE;
		}
		return $has_valid_avatar;
	}
	
	//fungsi aprof commentar
	function approve_comment($gravatar, $ip, $blacklist){
	
		$options = get_option('beon-comment');
		if($gravatar == TRUE && $stopforumspam[2] == "no" && $blacklist == 0 ){
			$approved = $options['select_one'];
		}elseif($gravatar == TRUE && $stopforumspam[2] == "no" && $blacklist == 1 ){
			$approved = $options['select_two'];
		}elseif($gravatar == TRUE && $stopforumspam[2] == "yes" && $blacklist == 0 ){
			$approved = $options['select_three'];
		}elseif($gravatar == TRUE && $stopforumspam[2] == "yes" && $blacklist == 1 ){
			$approved = $options['select_four'];
		}elseif($gravatar == FALSE && $stopforumspam[2] == "no" && $blacklist == 0 ){
			$approved = $options['select_five'];
		}elseif($gravatar == FALSE && $stopforumspam[2] == "no" && $blacklist == 1 ){
			$approved = $options['select_six'];
		}elseif($gravatar == FALSE && $stopforumspam[2] == "yes" && $blacklist == 0 ){
			$approved = $options['select_seven'];
		}elseif($gravatar == FALSE && $stopforumspam[2] == "yes" && $blacklist == 1 ){
			$approved = $options['select_eight'];
		}else{
			$approved = 'spam';
		}
		return $approved;
	}

	//fungsi buat mendapatkan comment saat itu juga, jadi saat di submit langsung di baca oleh fungsi ini
	function preprocess_comment_remove_url( $commentdata ) {
		
		$author = $commentdata['comment_author'];
		$email = $commentdata['comment_author_email'];
		$url = $commentdata['comment_author_url'];
		$user_ip = $_SERVER['REMOTE_ADDR'];
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		
		//check comment yang masuk di wordpress, checking by fungsi internal wordpress
		if(do_action( 'wp_blacklist_check', $author, $email, $url, $comment, $user_ip, $user_agent ) == true){
			$do_action = 1;
		}elseif(do_action( 'wp_blacklist_check', $author, $email, $url, $comment, $user_ip, $user_agent ) == false){
			$do_action = 0;
		}else{
			$do_action = "script_salah";
		}
		
		//debug di rubah url post comment-nya pakek $do_action
		//unset($commentdata['comment_author_url']);
		//$commentdata['comment_author_url'] = $do_action;
		
		//set status comment, fungsi check spam di wordpress tidak berjalan hanya berjalan di fungsi ini
		function filter_handler( $approved , $commentdata )
		{
			$gravatar = validate_gravatar($commentdata['comment_author_email']);
			$stopforumspam = curl_stopforumspam();
			
			// inspect $commentdata to determine approval, disapproval, or spam status
			$check_app = approve_comment($gravatar, $stopforumspam[2], $do_action);
			$approved = $check_app;
			return $approved;
		}
		add_filter( 'pre_comment_approved' , 'filter_handler' , '99', 2 );
		
		return $commentdata;
		
	}
	//ikutkan fungsi preprocess_comment_remove_url di fungsi preprocess_comment
	add_filter( 'preprocess_comment' , 'preprocess_comment_remove_url' ); 

	function correction_date_plugin(){

	  $result = 0;
	  $value_engin = value_engin();
	  $get_date_engin = $value_engin[1];
	  
	  //get tanggal update plugin
	  $update_sd = get_option( 'update_secure_discussion');
	  
	  //check apakah ada tanggal update plugin
	  //kalau gak ada di tambahkan
	  if(empty($update_sd)){
		add_option( 'update_secure_discussion', '0000-00-00 00:00:00');
		$result = 1;
	  }
	  
	  //apakah sama tanggal di plugin sama dengan engin
	  //kalau beda statusnya "harus update"
	  if($result == 0){
		if($update_sd != $get_date_engin){
		  $result = 1;
		}
	  }
	  
	  return $result;
	  
	}

	function value_engin(){

	  $ch = curl_init(); 
	  // set url 
	  curl_setopt($ch, CURLOPT_URL, "plugin.beon.co.id"); 
	  //return the transfer as a string 
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	  // $output contains the output string 
	  $output = curl_exec($ch); 
	  // close curl resource to free up system resources 
	  curl_close($ch); 

	  $explode = explode(PHP_EOL, $output);
	  
	  return $explode;

	}

	function update_plugin(){
	  
	  $value_engin = value_engin();
	  $max_comm_link = $value_engin[0];
	  $date_engin = $value_engin[1];
	  
	  $comm_max_link = get_option('comment_max_links');
	  $update_sd = get_option('update_secure_discussion');
	  $blacklist_keys = get_option('blacklist_keys');
	  $explode_blacklist_keys = explode(PHP_EOL, $blacklist_keys);
	  
	  //check comment max link, kalau gak sama update dari engin
	  if($max_comm_link != $comm_max_link){
		update_option('comment_max_links', $max_comm_link);
	  }
	  
	  //check date plugin, kalau gak sama update dari engin
	  if($date_engin != $update_sd){
		update_option('update_secure_discussion', $date_engin);
		//echo "update date gak dulu ya lagi belum selese";
	  }
	  
	  //check jumlah list yang di block di plugin, kalau gak sama update dari engin
	  $count_array_engin = count($value_engin) - 2;
	  $count_array_plugin = count($explode_blacklist_keys);
	  
	  if($count_array_engin != $count_array_plugin){
		//for dari 2 dikarenakan 0(buat max limit) dan 1(buat tanggal) jadi dari 2
		$black = "";
		for($x = 2; $x <= $count_array_engin; $x++){
		  if($x != $count_array_engin){$PHP_EOL = PHP_EOL;}else{$PHP_EOL="selese";}
		  $black .= $value_engin[$x].$PHP_EOL;
		}
		update_option('blacklist_keys', $black);
		/*
		echo "<pre>";
		print_r($black);
		echo "</pre>";
		*/
	  }
	  
	}

	$check_date = correction_date_plugin();
	if($check_date == 1){
	  update_plugin();
	}
	
	//debug isi option yang di pililh
	//$options = get_option('beon-comment');
	//print_r($options);
	
	//awal semua berada
	define('BEON_COMMENT_FILE', __FILE__);
	define('BEON_COMMENT_PATH', plugin_dir_path(__FILE__));
	require BEON_COMMENT_PATH . 'beonComment.php';
	
	new beonComment();