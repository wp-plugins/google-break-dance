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
Plugin ini spesial pake pake telor buat <a href="http://www.ads-id.com">Komunitas Publisher Indonesia</a> dan siapapun hahaha....

Saat visitor klik link "Lihat Gambar Asli" di halaman Google search image maka URLnya akan dialihkan / Redirect langsung halaman Post dimana image tersebut berada.
sebelum menginstall plugin ini jangan lupa  masukan baris text berikut ke paling atas file <b>.htaccess</b>  : <br /><br />
= FITUR =
- Redirect otomatis gambar ukuran full, medium, smalll ke postingan
- Menambahkan Watermark dihalaman google image search
- Frame Breaker untuk Google Image Eropa
- GBD htaccess Editor
- Tidak Redirect image ke post jika yg akses adalah BOT (Googlebot, Bingbot, slurp, dll..) sehingga gambar bisa di index oleh Bot.
- Tidak redirect jika no Referer

= Perubahan terakhir =
= 0.8 =
- fitur baru, watermark dihalaman google image search
- Auto edit htaccess saat diaktifkan
- ditambahkan GBD htaccess Editor
- fix browser cache



= Instruksi singkat =
- Tidak perlu lagi mengedit file .htaccess karena sudah otomatis akan tetapi jika sudah pernah edit .htaccess sebelumnya maka pastikan harus seperti dibawah
<code>
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

# BEGIN Google Break Dance
RewriteEngine on
RewriteBase /
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|png)$ [NC]
RewriteCond %{HTTP_REFERER} ^http://www.google.[a-z]{2,4}(.[a-z]{2,4})?/blank.html$ [NC]
RewriteCond %{HTTP_REFERER} !^$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /gbd_watermark?$1 [R=302,L]

RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|png|ico)$ [NC]
RewriteCond %{HTTP_REFERER} !^$ [NC]
RewriteCond %{HTTP_REFERER} !^http://www.nama-domain-ente.com/.*$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /get_image?$1 [R=302,L]
# END Google Break Dance
</code>

- Klo ingin menambahkan lebih banyak bot yg tidak ingin diredirect ke post atau supaya image di index karena default hanya yg mengandung kata "bot" (Googlebot, Bingbot, dll...) dan yahoo Slurp edit baris <strong>!(.\*bot.\*|slurp)</strong> menjadi seperti <strong>!(.\*bot.\*|slurp|kamu|ente|maneh|anda|lu|sia)</strong>
- Untuk merubah .htaccess melalui Dashboard bisa pake pake plugin GBD Htaccess Editor

= SS =

/assets/screenshot-1.png
<br >* Tampilan di Google Image Search

/assets/screenshot-2.png
<br >* tampilan GBD .htaccess Editor

== Installation ==


1. Upload plugin ini`/wp-content/plugins/` directory, atau
2. Cari dan install di Dashboarf => Plugins => Add new
3. Activate
4. masukan baris text berikut ke <b>.htaccess</b> melalui ftp atau dengan menggunakan plugin htaccess editor <br />
<code>
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
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

- ganti <strong>cekpr.com<strong> dengan nama domain ente



== Frequently Asked Questions ==

= Bagaimana Cara mengetahui plugin ini berfungsi atau tidak =

di Google search ketik "<b>site:domain-punya-ente.com</b>" (tanpa tanda kutip) trus klik gambar dan klik lagi "Lihat Gamabar Asli" dan klo di <b>Redirect</b> ke halaman Post maka plugin ini berfungsi.

== Screenshots ==
/assets/screenshot-1.png
<br >* Tampilan di Google Image Search

/assets/screenshot-2.png
<br >* tampilan GBD .htaccess Editor

== Upgrade Notice ==
ganti semua filenya dengan yg terbaru.

== Changelog ==
= 0.8 =
- fitur baru, watermark dihalaman google image search
- Auto edit htaccess saat diaktifkan
- ditambahkan GBD .htaccess Editor
- fix browser cache
= 0.7 =
- ditambahkan Google Frame Breaker karena Gogle eropa masih menggunakan Layout lama
- fix header already sent, ada yg lupa kehapus saat proses debug hehe...
= 0.6 =
fix header already sent
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