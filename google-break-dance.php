<?php
/*
Plugin Name: Google Break Dance
Plugin URI: http://wordpress.org/extend/plugins/google-break-dance/
Description: Redirect Visitor dari Google image ke langsung halaman Post dan menambahkan watermark di halaman Google Image Search. klo berguna, kapan2 jgn lupa cendolnya buat <strong><a href="http://www.cekpr.com">cekPR.com</a></strong> heheh...
Version: 0.90
Author: ewwink
Author URI: http://www.cekpr.com/
License: GPL2
*/
require_once( dirname (__FILE__) . '/admin.php' );
function cekpr_image_id($image_url) {
    global $wpdb;
    $prefix = $wpdb->prefix;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts WHERE guid=%s;", $image_url));
    if(!$attachment){
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='" . $image_url . "';"));
    }
    if(!$attachment){
      $tryImage = preg_replace('/(-[0-9]{1,3})x[0-9]{1,3}\.(jpe?g|gif|png)/i',".$2",$image_url);
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
<script language="JavaScript" type="text/javascript">var t=setTimeout(function(){window.location='http://'+window.location.hostname;},2000);</script>
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
function getMime($m){
  $n = getimagesize($m);
  $mime = $n['mime'];
  switch ($mime){
  case "image/jpeg":    $mimeType = 'jpeg'; break;
  case "image/gif":     $mimeType = 'gif';  break;
  case "image/png":     $mimeType = 'png';  break;
  default:              $mimeType = "jpeg";
  }
  return $mimeType;
}
function getHeader($header){
  $headeData = array();
  $headeData[] = header("content-type: image/$header");
  $headeData[] = header("Expires: 1 Jan 1990 00:00:00 GMT");
  $headeData[] = header("Pragma: no-cache");
  $headeData[] = header("Cache-control: no-cache");
  $headeData[] = header("Cache-control: no-store");
  $headeData[] = header("Cache-control: max-age=0, must-revalidate");
  $headeData[] = header("Cache-control: pre-check=0,post-check=0", false);
  return $headeData;
}
function gbdWatermark($fn){
  list($w, $h) = getimagesize($fn);
  $type = getMime($fn);
  $imageFrom = 'imagecreatefrom'.$type;
  $readIM =  'image'.$type;
  $newFN = basename($fn);
  $wmark = @imagecreatetruecolor($w, $h) or die('Cannot Initialize new GD image stream');
  $thumb = $imageFrom($fn);
  $watermark = imagecreatefromjpeg(dirname(__FILE__).'/w.jpg');
  $font = dirname(__FILE__).'/Dosis-ExtraBold.ttf';
  $color = ImageColorAllocate($wmark, 255, 255, 255);
  $text0 = get_option('gbd_text');
  $text1= site_url().'/'.cekpr_image_id(site_url().'/'.str_ireplace('/gbd_watermark?','',$_SERVER['REQUEST_URI']));

  $size0 = intval(get_option('gbd_text_size'));
  $size1 = intval(get_option('gbd_url_size'));

  $bbox0 = imagettfbbox($size0, 0, $font, $text0);
  $bbox1 = imagettfbbox($size1, 0, $font, $text1);

  // This is our cordinates for X and Y
  $x0 = $bbox0[0] + (imagesx($watermark) / 2) - ($bbox0[4] / 2);
  $y0 = $bbox0[1] + (imagesy($watermark)) * 0.68;

  $x1 = $bbox1[0] + (imagesx($watermark) / 2) - ($bbox1[4] / 2);
  $y1 = $bbox1[1] + imagesy($watermark) * 0.8;

  imagettftext($watermark, $size0, 0, $x0, $y0, $color, $font, $text0);
  if(get_option('gbd_url') === '1'){
    imagettftext($watermark, $size1, 0, $x1, $y1, $color, $font, $text1);
  }
  imagettftext($watermark, 11, 0, 330, 20, $color, $font, "Plugin by: cekPR.com/GBD");

  imagecopyresampled($wmark, $watermark, 0, 0, 0, 0, $w, $h, 500, 500);
  imagecopymerge($thumb, $wmark, 0, 0, 0, 0, $w, $h, 70);

  if (!is_dir(ABSPATH.'wp-content/gbd-cache')){mkdir((ABSPATH.'wp-content/gbd-cache'));}
  getHeader($type);
  if(is_dir(ABSPATH.'wp-content/gbd-cache') && is_writable(ABSPATH.'wp-content/gbd-cache/')){
    $readIM($thumb,ABSPATH.'wp-content/gbd-cache/'.$newFN);
    readfile(ABSPATH.'wp-content/gbd-cache/'.$newFN);
    imagedestroy($thumb);
    imagedestroy($wmark);
    imagedestroy($watermark);
    exit;
  }
  $readIM($thumb);
  imagedestroy($thumb);
  imagedestroy($wmark);
  imagedestroy($watermark);
  exit;
}

function Google_Image_Dance(){
  if(preg_match('/^\/\d+$/',$_SERVER['REQUEST_URI'])){
    preg_match('/\d+/',$_SERVER['REQUEST_URI'],$urlId);
    $aUrl = get_permalink($urlId[0]);
    $tmpUrl = get_post($urlId[0]);
    $pUrl = get_permalink($tmpUrl->post_parent);
    $oUrl = site_url().'/?p='.$urlId[0];
    if ($pUrl){
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: $pUrl");
      exit;
    }
    if ($aUrl){
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: $aUrl");
      exit;
    }
    header("Location: $oUrl");
    exit;
  }
  if(preg_match('/^\/gbd_watermark\?.*\.(jpe?g|gif|png)$/i',$_SERVER['REQUEST_URI'])){
    $wImage =  ABSPATH.str_ireplace('/gbd_watermark?','',$_SERVER['REQUEST_URI']);
    if (file_exists(ABSPATH.'wp-content/gbd-cache/'.basename($wImage))){
      $type = getMime(ABSPATH.'wp-content/gbd-cache/'.basename($wImage));
      getHeader($type);
      readfile(ABSPATH.'wp-content/gbd-cache/'.basename($wImage));
      exit;
    }
    gbdWatermark($wImage);
  }
  if(preg_match('/^\/get_posturl?.*\.(jpe?g|gif|png)$/i',$_SERVER['REQUEST_URI'])){
    $getImg = str_ireplace('get_posturl?','',$_SERVER['REQUEST_URI']);
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
    if($GattachId){
      header("HTTP/1.1 301 Moved Permanently");
      header("Location: $GattachId");
      exit;
      }
  }
  else{
    add_filter('wp_title', 'GID_not_found');
    meta_redir();
  }
 }
}

function gbd_activate(){
  if (!get_option( 'gbd_text' )) { update_option( 'gbd_text', 'Click here to view High Resolution image' ); }
	if (!get_option( 'gbd_text_size' )) { update_option( 'gbd_text_size', '20' ); }
	if (!get_option( 'gbd_url' )) { update_option( 'gbd_url', '1' ); }
	if (!get_option( 'gbd_url_size' )) { update_option( 'gbd_url_size', '22' ); }
  add_htaccess(get_option('gbd_htBackup'));
  if (!get_option( 'gbd_htBackup' )){
  $rules = array();
  $rules[] = 'RewriteEngine on';
  $rules[] = 'RewriteBase /';
  $rules[] = 'RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|png)$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_REFERER} .*/blank.html$ [NC,OR]';
  $rules[] = 'RewriteCond %{HTTP_REFERER} .*images.search.yahoo.com/.*$ [NC]';
  $rules[] = '#RewriteCond %{HTTP_REFERER} ^$ [NC]';
  $rules[] = '#RewriteCond %{HTTP_REFERER} !^'.site_url().'/.*$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]';
  $rules[] = 'RewriteRule ^(wp-content.*)$ /gbd_watermark?$1 [R=302,L]';
  $rules[] = '';
  $rules[] = 'RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|png)$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_REFERER} ^http://www.google.[a-z]{2,4}(.[a-z]{2,4})?/url\?.*$ [NC,OR]';
  $rules[] = 'RewriteCond %{HTTP_REFERER} ^http://www.bing.com/images/search?q=\?.*$ [NC]';
  $rules[] = '#RewriteCond %{HTTP_REFERER} ^$ [NC]';
  $rules[] = '#RewriteCond %{HTTP_REFERER} !^'.site_url().'/.*$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]';
  $rules[] = 'RewriteRule ^(wp-content.*)$ /get_posturl?$1 [R=302,L]';

  add_htaccess($rules);
  }
}

register_activation_hook( __FILE__, 'gbd_activate' );

function add_htaccess($rule) {
    $htaccess_file = ABSPATH.'.htaccess';
    return insert_with_markers($htaccess_file, 'Google Break Dance', (array) $rule);
}

register_deactivation_hook( __FILE__, 'gbd_deactivate' );

function gbd_deactivate() {
	$htaccess_file = ABSPATH.'.htaccess';
  $htBackup = extract_from_markers($htaccess_file, 'Google Break Dance');
  update_option( 'gbd_htBackup', $htBackup );
	insert_with_markers($htaccess_file, 'Google Break Dance', "");
}
function gbd_css(){
  echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'gbd.css" />';
}
function gbd_js(){
  echo '<script type="text/javascript" src="'.plugin_dir_url(__FILE__).'gbd.js"></script>';
}

if (is_admin()){
  if(isset($_POST['htaccess'])){
    $htFile = ABSPATH.'.htaccess';
    if (get_magic_quotes_gpc()){
      $htContent = stripslashes($_POST['htaccess']);
    }
    else{
      $htContent = $_POST['htaccess'];
    }
    $handle = fopen($htFile, 'w') or die('Cannot open file:  '.$htFile);
    fwrite($handle, $htContent);
    fclose($handle);
  }
  if(preg_match('/page=gbd-options&settings-updated=true/i',$_SERVER['REQUEST_URI'])){
    array_map('unlink', glob(ABSPATH."wp-content/gbd-cache/*"));
  }
}
add_action('admin_init', 'register_gbdsettings');
add_action('admin_menu', 'gbd_create_menu',10);
add_action('init','Google_Image_Dance',1);
add_action('wp_head', 'break_frames_js');
add_action('admin_head', 'gbd_css');
add_action('admin_head', 'gbd_js');

?>