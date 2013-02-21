=== Plugin Name ===
Contributors: ewwink
Donate link: http://www.prpagerank.com/
Tags: redirect,google,image,frame,frame breaker,redirect google image
Requires at least: 3.0.1
Tested up to: 3.5.1
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Redirect Visitor dari Google images ke langsung halaman Post dengan Plugin Google Break Dance.

== Description ==
Plugin ini spesial pake pake telor buat <a href="http://www.ads-id.com">Komunitas Publisher Indonesia</a> dan orang indonesia hahaha....

Saat visitor klik link "Lihat Gambar Asli" di halaman Google search image maka URLnya akan dialihkan / Redirect langsung halaman Post dimana image tersebut berada.
sebelum menginstall plugin ini jangan lupa  masukan baris text berikut ke paling atas file <b>.htaccess</b>  : <br /><br />
= v 0.5 =
- fix no referer, no redirect.
- tidak redirect thumbnail dihalaman google search
- fix redirect untuk gambar yg non full size seperti, http://blog/uploads/image-100x100.png

= *** Penting: untuk v 0.5 edit lagi .htaccess menjadi seperti dibawah =

<code>
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_USER_AGENT} !.*bot.* [NC]
RewriteCond %{HTTP_REFERER} !^$ [NC]
RewriteCond %{HTTP_REFERER} !^http://www.google.[a-z]{2,4}(.[a-z]{2,4})?/blank.html$ [NC]
RewriteCond %{HTTP_REFERER} !^http://(www.)?cekpr.com/.*$ [NC]
RewriteRule ^(.*)$ /get_image?$1 [R=302,L]

# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
</code>

*<i>ganti cekpr.com dengan nama domain ente</i>
== Installation ==


1. Upload plugin ini`/wp-content/plugins/` directory, atau
2. Cari dan install di Dashboarf => Plugins => Add new
3. Activate
4. masukan baris text berikut ke <b>.htaccess</b> melalui ftp atau dengan menggunakan plugin htaccess editor <br />
<code>
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_USER_AGENT} !.*bot.* [NC]
RewriteCond %{HTTP_REFERER} !^$ [NC]
RewriteCond %{HTTP_REFERER} !^http://www.google.[a-z]{2,4}(.[a-z]{2,4})?/blank.html$ [NC]
RewriteCond %{HTTP_REFERER} !^http://(www.)?cekpr.com/.*$ [NC]
RewriteRule ^(.*)$ /get_image?$1 [R=302,L]

# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
</code>

*<i>ganti cekpr.com dengan nama domain ente</i>


== Frequently Asked Questions ==

= Bagaimana Cara mengetahui plugin ini berfungsi atau tidak =

di Google search ketik "<b>site:domain-punya-ente.com</b>" (tanpa tanda kutip) trus klik gambar dan klik lagi "Lihat Gamabar Asli" dan klo di <b>Redirect</b> ke halaman Post maka plugin ini berfungsi.

== Screenshots ==

nda ada
== Upgrade Notice ==
ganti semua filenya dengan yg terbaru.

== Changelog ==
= 0.5 =
- fix no referer, no redirect
- tidak redirect thumbnail dihalaman google search
- fix redirect untuk gambar yg non full size seperti, http://blog/uploads/image-100x100.png
= 0.4 =
perubahan pada .htaccess supaya jangan redirect Bot Bot ke post, tambahkan <br  />
<strong>RewriteCond %{HTTP_USER_AGENT} !.\*bot.\* [NC]</strong>
= 0.3 =
Fix $wpdb Compability
= 0.2 =
fix $wpdb
= 0.1 =
test release