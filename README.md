<!-- Başklık -->
# 🚀 File Upload Server v1.0

<!-- Gerekenler -->
# Requirements
<pre>
Debian/Gnu 12
Nginx
Php 8.3
Mysql
Composer
Curl
SSL Certificate
</pre>

<!-- Özellikler -->
# Features
+ [Secure] HTTP 2.0
+ [Secure] User: Auth/Create/Update/Fetch/Delete
+ [Secure] Session: Create/Update/Fetch/Delete
+ [Secure] File: Upload/Fetch/Delete/Update
+ [Secure] Page: Login/Logout/Files
+ [Auto] Theme: Dark/Light

<!-- Mikro Servis Komutları -->
# Micro Service | Auth
<pre>
Method: FETCH, CREATE, UPDATE, DELETE
Request: curl -i -X FETCH http://localhost/api/auth --data '{"username":"<username>","email":"<email>","password":"<password>"}'
</pre>

# Micro Service | Session
<pre>
Method: FETCH, CREATE, UPDATE, DELETE
Request: curl -i -X CREATE http://localhost/api/session --data '{"username":"<username>" "email":"<email>","password":"<password>"}'
</pre>

# Micro Service | File
<pre>
Method: FETCH, POST, DELETE
Request: curl -i -X FETCH https://localhost/api/file --data '{"filename":["test.c","bla.php"]}'
</pre>