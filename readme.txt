=== Plugin Name ===
Contributors: ewwink
Donate link: http://www.prpagerank.com/
Tags: redirect,google,image,frame,frame breaker,redirect google image
Requires at least: 3.0.1
Tested up to: 3.5.1
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Redirect Visitor dari Google image ke langsung halaman Post.

== Description ==

Saat visitor klik link "Lihat Gambar Asli" di halaman Google search image maka URLnya akan dialihkan / Redirect langsung halaman Post dimana image tersebut berada.
sebelum menginstall plugin ini jangan lupa  masukan baris text berikut ke paling atas file <b>.htaccess</b>  : <br /><br />
<strong>
RewriteEngine On  <br />
RewriteBase /    <br />
RewriteCond %{REQUEST_URI} wp-content/uploads/.\*\\.(gif|jpg|jpeg|png|ico)$ [NC]  <br />
RewriteCond %{HTTP_REFERER} !^$ <br />
RewriteCond %{HTTP_REFERER} !^http://(www.)?cekpr.com/.\*$ [NC]   <br />
RewriteRule ^(.*)$ /get_image?$1 [R=302,L]    <br /><br />
</strong>
*<i>ganti cekpr.com dengan nama domain ente</i>
== Installation ==


1. Upload plugin ini`/wp-content/plugins/` directory
2. Activate
3. masukan baris text berikut di paling atas file <b>.htaccess</b> <br /><br />
<strong>
RewriteEngine On           <br />
RewriteBase /        <br />
RewriteCond %{REQUEST_URI} wp-content/uploads/.\*\\.(gif|jpg|jpeg|png|ico)$ [NC]   <br />
RewriteCond %{HTTP_REFERER} !^$ <br />
RewriteCond %{HTTP_REFERER} !^http://(www.)?cekpr.com/.\*$ [NC]  <br />
RewriteRule ^(.*)$ /get_image?$1 [R=302,L]       <br /><br />
</strong>
*<i>ganti cekpr.com dengan nama domain ente</i>
== Frequently Asked Questions ==

= Bagaimana Cara mengetahui plugin ini berfungsi atau tidak =

di Google search ketik "<b>site:domain-punya-ente.com</b>" (tanpa tanda kutip) trus klik gambar dan klik lagi "Lihat Gamabar Asli" dan klo di <b>Redirect</b> ke halaman Post maka plugin ini berfungsi.

== Screenshots ==

nda ada
== Upgrade Notice ==
n/a

== Changelog ==

= 0.1 =
test release