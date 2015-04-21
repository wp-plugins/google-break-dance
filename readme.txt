=== Plugin Name ===
Contributors: ewwink
Donate link: http://goo.gl/1zeKU
Tags: redirect,google,image,frame,frame breaker,redirect google image
Requires at least: 3.0.1
Tested up to: 4.2
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Redirect Visitor dari Google images ke langsung halaman Post dengan Plugin Google Break Dance.

== Description ==
Plugin ini spesial pake pake telor buat <a href="http://ads.id">Komunitas Publisher Indonesia</a> dan siapapun hahaha....

= upgrade ke versi 0.91 =
di htaccess ubah <strong>get_image</strong> jadi <strong>get_posturl</strong>

Redirect visitor saat link "Lihat Gambar Asli" di halaman Google image search maka URL gambarnya akan dialihkan / Redirect langsung halaman Post dimana image tersebut berada.
selain itu dengan plugin ini otomatis image di halaman Google image search akan ter-watermark  : <br /><br />
= FITUR =
- Redirect otomatis gambar ukuran full, medium, smalll ke postingan
- Menambahkan Watermark dihalaman google image search (<a href="http://wordpress.org/extend/plugins/google-break-dance/screenshots/">lihat</a>)
- custom text watermark + Editor (<a href="http://wordpress.org/extend/plugins/google-break-dance/screenshots/">lihat</a>)
- url shortener di watermark
- cache watermark image untuk meminimalkan cpu usage (lokasi: /wp-content/gbd_cache)
- Frame Breaker untuk Google Image Eropa
- GBD htaccess Editor ( <a href="http://wordpress.org/extend/plugins/google-break-dance/screenshots/">lihat</a>)
- Tidak Redirect image ke post jika yg akses adalah BOT (Googlebot, Bingbot, slurp, dll..) sehingga gambar bisa di index oleh Bot.
- Tidak redirect jika no Referer

= Redirect VS Watermark =
Pada versi 0.90 default konfigurasi .htaccess untuk meminimalkan penggunaan CPU maka yg di redirect dan di watermark adalah sebagai berikut

- Redirect dari halaman Google Image Search
- Redirect dari Bing Image Search
- Watermark di halaman Google Image Search
- Watermark di halaman Yahoo Image search

untuk penggunaan lainnya konfigurasi .htacess lainnya bisa lihat dibawah

= Pengguna Nginx Server =
Convert .htaccess ke konfigurasi Nginx lewat www.anilcetin.com/convert-apache-htaccess-to-nginx/

= Instruksi singkat =
- Tidak perlu lagi mengedit file .htaccess karena sudah otomatis akan tetapi jika sudah pernah edit .htaccess sebelumnya maka pastikan harus seperti dibawah (default)
<code>
# BEGIN Google Break Dance
RewriteEngine on
RewriteBase /

### Awal Watermark ###
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_REFERER} .*/blank.html$ [NC,OR]
RewriteCond %{HTTP_REFERER} .*images.search.yahoo.com/.*$ [NC]
#RewriteCond %{HTTP_REFERER} ^$ [NC]
#RewriteCond %{HTTP_REFERER} !^http://www.nama-domain-ente.com/.*$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /gbd_watermark?$1 [R=302,L]
### Akhir Watermark ###

### Awal Redirect ###
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_REFERER} ^http://www.google.[a-z]{2,4}(.[a-z]{2,4})?/url\?.*$ [NC,OR]
RewriteCond %{HTTP_REFERER} ^http://www.bing.com/images/search?q=\?.*$ [NC]
#RewriteCond %{HTTP_REFERER} ^$ [NC]
#RewriteCond %{HTTP_REFERER} !^http://www.nama-domain-ente.com/.*$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /get_posturl?$1 [R=302,L]
### Akhir Redirect ###

# END Google Break Dance
</code>
* sesuaikan <strong>www.nama-domain-ente.com</strong> dengan domain yg ente punya
- Klo ingin menambahkan lebih banyak bot yg tidak ingin diredirect ke post atau supaya image di index karena default hanya yg mengandung kata "bot" (Googlebot, Bingbot, dll...) dan yahoo Slurp edit baris <strong>!(.\*bot.\*|slurp)</strong> menjadi seperti <strong>!(.\*bot.\*|slurp|semoga|sukses|dengan|bloggingnya|salam)</strong>
- Untuk merubah .htaccess melalui Dashboard bisa melaui <strong>GBD Htaccess Editor</strong> yg sudah disertakan diplugin ini

= cara edit .htaccess: untuk mengaktifkan hapus tanda pagar '#" dan untuk menonaktifkan beri tanda pagar '#' dibaris yg di inginkan =

= Kostum .htaccess 1 =
- Redirect dari halaman Google Image Search
- Redirect dari Bing Image Search
- <strong>Redirect jika Referer kosong</strong>
- Watermark di halaman Google Image Search
- Watermark di halaman Yahoo Image search
- <strong>Watermark semua gambar jika referer bukan dari situs ente</strong>
<code>
# BEGIN Google Break Dance
RewriteEngine on
RewriteBase /

### Awal Watermark ###
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_REFERER} .*/blank.html$ [NC,OR]
RewriteCond %{HTTP_REFERER} .*images.search.yahoo.com/.*$ [NC,OR]
RewriteCond %{HTTP_REFERER} !^http://www.nama-domain-ente.com/.*$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /gbd_watermark?$1 [R=302,L]
### Akhir Watermark ###

### Awal Redirect ###
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_REFERER} ^http://www.google.[a-z]{2,4}(.[a-z]{2,4})?/url\?.*$ [NC,OR]
RewriteCond %{HTTP_REFERER} ^http://www.bing.com/images/search?q=\?.*$ [NC,OR]
RewriteCond %{HTTP_REFERER} ^$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /get_posturl?$1 [R=302,L]
### Akhir Redirect ###

# END Google Break Dance
</code>

= Kostum .htaccess 2 =
- Redirect dari halaman Google Image Search
- Redirect dari Bing Image Search
- <strong>Redirect semua gambar jika referer bukan dari situs ente</strong>
- Watermark di halaman Google Image Search
- Watermark di halaman Yahoo Image search
- <strong>Watermark jika Referer kosong</strong>
<code>
# BEGIN Google Break Dance
RewriteEngine on
RewriteBase /

### Awal Watermark ###
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_REFERER} .*/blank.html$ [NC,OR]
RewriteCond %{HTTP_REFERER} .*images.search.yahoo.com/.*$ [NC,OR]
RewriteCond %{HTTP_REFERER} ^$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /gbd_watermark?$1 [R=302,L]
### Akhir Watermark ###

### Awal Redirect ###
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_REFERER} ^http://www.google.[a-z]{2,4}(.[a-z]{2,4})?/url\?.*$ [NC,OR]
RewriteCond %{HTTP_REFERER} ^http://www.bing.com/images/search?q=\?.*$ [NC,OR]
RewriteCond %{HTTP_REFERER} !^http://www.nama-domain-ente.com/.*$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /get_posturl?$1 [R=302,L]
### Akhir Redirect ###

# END Google Break Dance
</code>

= Kostum .htaccess 3 =
- tambahkan watermark jika referer dari pinterest
<code>
### Awal Watermark ###
RewriteCond %{REQUEST_URI} wp-content/uploads/.*\.(gif|jpg|jpeg|png)$ [NC]
RewriteCond %{HTTP_REFERER} .*/blank.html$ [NC,OR]
RewriteCond %{HTTP_REFERER} .*images.search.yahoo.com/.*$ [NC,OR]
RewriteCond %{HTTP_REFERER} .*pinterest.*$ [NC]
#RewriteCond %{HTTP_REFERER} ^$ [NC]
#RewriteCond %{HTTP_REFERER} !^http://www.nama-domain-ente.com/.*$ [NC]
RewriteCond %{HTTP_USER_AGENT} !(.*bot.*|slurp) [NC]
RewriteRule ^(wp-content.*)$ /gbd_watermark?$1 [R=302,L]
### Akhir Watermark ###
</code>

= TIPS lain Meminimalkan CPU Usage = 
1. Block robot yg tidak mendatangkan trafik tetapi membuat CPU usage dan pemakaian bandwitdh jadi tinggi, tambahkan di Robots.txt
<code>
user-agent: AhrefsBot
disallow: /

user-agent: MJ12bot
disallow: /

user-agent: Seomozbot
disallow: /

</code>

= Perubahan terakhir =
= 0.91 =
salah ketik di readme.txt, di htaccess ubah <strong>get_image</strong> jadi <strong>get_posturl</strong>
= 0.90 =
- penambahan halaman GBD Settings
- tambahan custom text watermark
- tambahan url shortener di watermark
- redirect atau watermark hanya dari referer yg di ketahui
= 0.82 =
- Penambahan cache watermark image untuk meminimalkan cpu usage
= 0.8 =
- fitur baru, watermark dihalaman google image search
- Auto edit htaccess saat diaktifkan
- ditambahkan GBD htaccess Editor
- fix browser cache

== Installation ==


1. Upload plugin ini`/wp-content/plugins/` directory, atau
2. Cari dan install di Dashboard => Plugins => Add new
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
RewriteRule ^(.*)$ /get_posturl?$1 [R=302,L]

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


plugin by <a href="http://www.cekpr.com">check pagerank</a>

== Frequently Asked Questions ==

= Bagaimana Cara mengetahui plugin ini berfungsi atau tidak =

di Google search ketik "<b>site:domain-punya-ente.com</b>" (tanpa tanda kutip) trus klik gambar dan klik lagi "Lihat Gamabar Asli" dan klo di <b>Redirect</b> ke halaman Post maka plugin ini berfungsi.

== Screenshots ==
1. Tampilan di Google Image Search

2. tampilan GBD .htaccess Editor

3. GBD Settings + Text watermark Editor

== Upgrade Notice ==
ganti semua filenya dengan yg terbaru.

== Changelog ==
= Perubahan terakhir =
= 0.91 =
salah ketik di htaccess di readme.txt, ubah <strong>get_image</strong> jadi <strong>get_posturl</strong>
= 0.90 =
- penambahan halaman GBD Settings
- tambahan custom text watermark
- tambahan url shortener di watermark
- redirect atau watermark hanya dari referer yg di ketahui
= 0.82 =
- Penambahan cache untuk image watermark untuk meminimalkan cpu usage
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