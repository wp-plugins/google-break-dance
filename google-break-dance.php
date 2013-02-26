<?php
/*
Plugin Name: Google Break Dance
Plugin URI: http://wordpress.org/extend/plugins/google-break-dance/
Description: Image tidak lagi terindek Google? <a href="http://wordpress.org/extend/plugins/google-break-dance/" target="_blank">EDIT .htaccess menjadi seperti ini</a>. Redirect Visitor dari Google image ke langsung halaman Post, jangan lupa edit file <b>.htaccess</b> sebelum menggunakan Plugin ini. Oh iya klo berguna, kapan2 jgn lupa cendolnya buat <strong><a href="http://www.cekpr.com">cekPR.com</a></strong> heheh...
Version: 0.7
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
    if(!$attachment){
      $tryImage = preg_replace('/(-[0-9]{1,3})x[0-9]{1,3}\.(jpe?g|gif|png|ico)/i',".$2",$image_url);
      $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts WHERE guid=%s;", $tryImage));
      if(!$attachment){
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='" . $tryImage . "';"));
      }
    }
    return $attachment[0];
}
function meta_redir(){
print <<<HTML
<meta http-equiv="refresh" content="2;url=/">
<script language="JavaScript" type="text/javascript">var t=setTimeout(function(){window.location=window.location.href.replace('get_image?','');},2000);</script>
HTML;
}

function break_frames_js(){
print <<<JS
<script language="JavaScript" type="text/javascript">if (top.location != self.location) top.location.replace(self.location);</script>
JS;
}

function GID_not_found($title){
  $title = "Image / Media Not Found, Redirecting to original location.....";
  return $title;
}
function Google_Image_Dance(){
 if(preg_match('/get_image?.*\.(jpe?g|gif|png|ico)$/i',$_SERVER['REQUEST_URI'])){
   $getImg = str_ireplace('get_image?','',$_SERVER['REQUEST_URI']);
  if(cekpr_image_id(get_site_url().$getImg)){
    $GpId = cekpr_image_id(get_site_url().$getImg);
    $GaUrl = get_post($GpId);
    $GPostId = get_permalink($GaUrl->post_parent);
    if(isset($GPostId)){
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: $GPostId");
      exit;
    }
  }
    else{
      add_filter('wp_title', 'GID_not_found');
      meta_redir();
    }
  }
}
add_action('init','Google_Image_Dance',1);
add_action('wp_head', 'break_frames_js');


?>