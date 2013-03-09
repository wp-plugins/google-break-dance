<?php
function gbd_create_menu(){
  add_menu_page('GBD Settings', 'Google Break Dance', 'administrator', 'gbd-options', 'gbd_settings');
  add_submenu_page( 'gbd-options', 'GBD Settings', 'GBD Settings', 'administrator', 'gbd-options', 'gbd_settings');
  add_submenu_page( 'gbd-options', 'GBD htaccess Editor', 'GBD htaccess Editor', 'administrator', 'gbd-options-editor', 'gbd_editor');
}
function register_gbdsettings() {
  register_setting( 'gbd-settings', 'gbd_text');
  register_setting( 'gbd-settings', 'gbd_text_size');
  register_setting( 'gbd-settings', 'gbd_url');
  register_setting( 'gbd-settings', 'gbd_url_size');
}
function gbd_settings(){ ?>
<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>
<?php if( isset($_GET['settings-updated']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('GBD Settings saved.') ?></strong></p>
    </div>
<?php } ?>
<h2>Google Break Dance Settings</h2></div>
<div class="wrap" id="gbdwrap">
<div id="gbdform">
<form method="POST" action="options.php">
<?php settings_fields('gbd-settings'); ?>
<p>Text Watermark:<input type="text" name="gbd_text" value="<?php echo get_option('gbd_text'); ?>" size="60" /></p>
<p>Text Font Size:<input type="text" name="gbd_text_size" value="<?php echo get_option('gbd_text_size'); ?>" /></p>
<p><input type="checkbox" name="gbd_url" value="1" <?php checked( '1', get_option( 'gbd_url' ) ); ?> /> Activate Short URL on Watermark?</p>
<p>URL Font Size:<input type="text" name="gbd_url_size" value="<?php echo get_option('gbd_url_size'); ?>" /></p>
<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
</form>
</div>
<div id="gbdpreview">
<h3>Image Watermark Preview</h3>
<div id="gbdpreviewimage">
<div id="gbdpreviewtext">Click here to view High Resolution image</div>
<div id="gbdpreviewurl"><?php echo site_url().'/12345'; ?></div>
</div>
</div>
</div>
<?php }

function gbd_editor() {
$htaccess = ABSPATH.'.htaccess';
$handle = fopen($htaccess, 'r');
$data = fread($handle,filesize($htaccess));
?>
<div class="wrap">
<?php if( isset($_POST['htaccess']) ) { ?>
    <div id="message" class="updated">
        <p><strong><?php _e('.htaccess saved.') ?></strong></p>
    </div>
<?php } ?>
<h2>GBD .htaccess Editor</h2>
<?php if (!is_writable($htaccess)){
  echo '<p style="font-weight:bold;color:red;">Cannot edit .htaccess is not writable!</p>';
  }
  else{
    echo "be careful editing .htaccess can make your system error, use at your own risk.";
  }
?>
<form method="post" action="">
<textarea style="width: 650px; height: 500px;" name="htaccess" <?php if (!is_writable($htaccess)){echo 'disabled="disabled"';} ?>>
<?php echo $data; ?>
</textarea>
<?php if (is_writable($htaccess)){ ?>
    <p class="submit">
    <input type="submit" class="button-primary" value="Save Changes" />
    </p>
<?php } ?>
</form>

</div>

<?php }

?>