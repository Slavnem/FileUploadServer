<!-- Başklık -->
# 🚀 Main File Upload Server [Devel]

<!-- Gerekenler -->
# Requirements
<pre>
Debian/Gnu +12
Nginx
Php +8.3
Mysql +8
Composer
Curl
SSL Certificate
</pre>

<!-- Mikro Servis Komutları -->
# Micro Service | Auth
<pre>
Method: FETCH, CREATE, UPDATE, DELETE
Request: curl -i -X FETCH http://localhost:3000 --data '{"username":"<username>","email":"<email>","password":"<password>"}'
</pre>

# Micro Service | Session
<pre>
Method: FETCH, CREATE, UPDATE, DELETE
Request: curl -i -X CREATE http://localhost:3100 --data '{"username":"<username>","email":"<email>","password":"<password>"}'
</pre>

# Micro Service | File
<pre>
Method: FETCH, UPLOAD, DELETE
</pre>