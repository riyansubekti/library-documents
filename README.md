# library-documents
Website library document adalah website untuk menyimpan file document

Langkah - langkah instalasi
1. Import database dengan nama file library_doc.db (menggunakan db MySQL)
2. Upload file ke htdocs atau ke file directory php
3. Ubah file application/config/config.php sesuai konfigurasi website kalian.
	- Contoh code yang harus di ubah dalam config.php. Ubah base_url
4. Ubah file application/config/database.php sesuai konfigurasi website kalian.
	- Contoh code yang harus di ubah dalam database.php. Ubah hostname, username, password dan nama database
	
Instalasi selesai silahkan jalankan websitenya

Login 

Username : riyan

Password : riyan123

Fitur

Memiliki 2 hak akses user :
1. Admin
	- admin dapat melihat semua document user
	- CRUD semua document user
2. User
	- user tidak bisa melihat document user lainnya
	- CRUD sesuai document user
