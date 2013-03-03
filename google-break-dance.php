<?php
/*
Plugin Name: Google Break Dance
Plugin URI: http://wordpress.org/extend/plugins/google-break-dance/
Description: Redirect Visitor dari Google image ke langsung halaman Post dan menambahkan watermark di halaman Google Image Search. Oh iya klo berguna, kapan2 jgn lupa cendolnya buat <strong><a href="http://www.cekpr.com">cekPR.com</a></strong> heheh...
Version: 0.8
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
function gbdWatermark($fn){
  $m = getimagesize($fn);
  $mime = $m['mime'];
  $watermark = imagecreatefrompng(dirname(__FILE__).'/w.png');
  list($w, $h) = getimagesize($fn);

  switch ($mime){
  case "image/jpeg":    $type = 'jpeg'; break;
  case "image/gif":     $type = 'gif';  break;
  case "image/png":     $type = 'png';  break;
  default:              $type = "jpeg";
  }
  $imageFrom = 'imagecreatefrom'.$type;
  $thumb = $imageFrom($fn)
  or die('Cannot Initialize new GD image stream');


  $createIM = 'imagecreatefrom'.$type;
  $readIM =  'image'.$type;
  $source = $createIM($fn);
  $newFN = basename($fn);
  $wmark = $createIM($fn);
  header("content-type: image/$type");
  header("Expires: 1 Jan 1990 00:00:00 GMT");
  header("Pragma: no-cache");
  header("Cache-control: no-cache");
  header("Cache-control: no-store");
  header("Cache-control: max-age=0, must-revalidate");
  header("Cache-control: pre-check=0,post-check=0", false);
  imagecopyresampled($wmark, $watermark, 0, 0, 0, 0, $w, $h, 400, 400);
  imagecopymerge($thumb, $wmark, 0, 0, 0, 0, $w, $h, 60);
  //$readIM($thumb,ABSPATH.'wp-content/gbd_cache/'.basename($fn));
  $readIM($thumb);
  imagedestroy($thumb);
  imagedestroy($wmark);
  imagedestroy($watermark);
 exit;
  //readfile(ABSPATH.'wp-content/gbd_cache/'.basename($fn));

}

function Google_Image_Dance(){
  if(preg_match('/gbd_watermark\?.*\.(jpe?g|gif|png)$/i',$_SERVER['REQUEST_URI'])){
    if (!is_dir(ABSPATH.'wp-content/gbd_cache')){mkdir((ABSPATH.'wp-content/gbd_cache'));}
    $wImage =  ABSPATH.str_ireplace('/gbd_watermark?','',$_SERVER['REQUEST_URI']);
    gbdWatermark($wImage);
  }
   if(preg_match('/get_image?.*\.(jpe?g|gif|png)$/i',$_SERVER['REQUEST_URI'])){
  $getImg = str_ireplace('wp2/get_image?','',$_SERVER['REQUEST_URI']);
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
function gbd_create_menu() {
  add_menu_page('GBD htaccess Editor', 'GBD htaccess Editor', 'administrator', __FILE__, 'gbd_editor', '');
}
function gbd_activate(){
  $rules = array();
  $rules[] = 'RewriteEngine on';
  $rules[] = 'RewriteBase /';
  $rules[] = 'RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|png)$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_REFERER} ^http://www.google.[a-z]{2,4}(.[a-z]{2,4})?/blank.html$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_REFERER} !^$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]';
  $rules[] = 'RewriteRule ^(wp-content.*)$ /gbd_watermark?$1 [R=302,L]';
  $rules[] = '';
  $rules[] = 'RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|png)$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_REFERER} !^$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_REFERER} !^'.site_url().'/.*$ [NC]';
  $rules[] = 'RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]';
  $rules[] = 'RewriteRule ^(wp-content.*)$ /get_image?$1 [R=302,L]';

  add_htaccess($rules);
}

register_activation_hook( __FILE__, 'gbd_activate' );

function add_htaccess($rule) {
    $htaccess_file = ABSPATH.'.htaccess';
    return insert_with_markers($htaccess_file, 'Google Break Dance', (array) $rule);
}

register_deactivation_hook( __FILE__, 'gbd_deactivate' );

function gbd_deactivate() {
	$htaccess_file = ABSPATH.'.htaccess';
	insert_with_markers($htaccess_file, 'Google Break Dance', "");
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
}

function gbd_editor() {
$htaccess = ABSPATH.'.htaccess';
$handle = fopen($htaccess, 'r');
$data = fread($handle,filesize($htaccess));
?>
<div class="wrap">
<h2>GBD .htaccess Editor</h2>
<?php if (!is_writable($htaccess)){
  echo '<p style="font-weight:bold;color:red;">.htaccess is not writable!</p>';
  }
  else{
    echo "be careful editing .htaccess can make your system error, use at your own risk.";
  }
?>
<form method="post" action="">
<textarea style="width: 650px; height: 450px;" name="htaccess" <?php if (!is_writable($htaccess)){echo 'disabled="disabled"';} ?>>
<?php echo $data; ?>
</textarea>
    <p class="submit">
    <input type="submit" class="button-primary" value="Save Changes" />
    </p>
</form>

</div>

<?php }
add_action('admin_menu', 'gbd_create_menu');
add_action('init','Google_Image_Dance');
add_action('wp_head', 'break_frames_js');

?>