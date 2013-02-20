<?php
/*
Plugin Name: Google Break Dance
Plugin URI: http://wordpress.org/extend/plugins/google-break-dance/
Description: Image tidak lagi terindek Google? <a href="http://wordpress.org/extend/plugins/google-break-dance/" target="_blank">EDIT .htaccess menjadi seperti ini</a>. Redirect Visitor dari Google image ke langsung halaman Post, jangan lupa edit file <b>.htaccess</b> sebelum menggunakan Plugin ini. Oh iya klo berguna, kapan2 jgn lupa cendolnya buat <strong><a href="http://www.cekpr.com">cekPR.com</a></strong> heheh...
Version: 0.4
Author: ewwink
Author URI: http://www.cekpr.com/
License: GPL2
*/

function cekpr_image_id($image_url) {
    global $wpdb;
    $prefix = $wpdb->prefix;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts WHERE guid=%s;", $image_url));
    if(!$attachment){
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='" . $image_url . "';"));
    }
    return $attachment[0];
}
function Google_Image_Dance(){
 if(preg_match('/get_image?.*\.(jpe?g|gif|png|ico)$/i',$_SERVER['REQUEST_URI'])){
  $getImg = str_ireplace('get_image?','',$_SERVER['REQUEST_URI']);
  if(cekpr_image_id(get_site_url().$getImg)){
    $GattachId = get_permalink(cekpr_image_id(get_site_url().$getImg));
    $GoriUrl = get_site_url().$getImg;
    $GpId = cekpr_image_id(get_site_url().$getImg);
    $GaUrl = get_post($GpId);
    $GPostId = get_permalink($GaUrl->post_parent);
    if($GPostId){
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: $GPostId");
      exit;
    }
    else{
      if($GattachId){
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $GattachId");
        exit;
      }
      else{
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $GoriUrl");
        exit;
      }
    }
  }
}
}  
add_action('init','Google_Image_Dance',1);


?>