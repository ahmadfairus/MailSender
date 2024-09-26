<h1>Welcome to Mail Sender </h1><br>
Mail sender di desain menggunakan <b>SMTPAuth</b> dengan port 587 TLS secure. <br>
Mail sender hanya menyediakan akses dalam bentuk API (anda bisa menggunakan curl, postman, atau tools lainnya). <br>
Parameter pada Mail Sender adalah sebagi berikut : <br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>host</b> : host untuk mail server. <b>(required)</b><br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>username</b> : username atau email yang digunakan sebagai authentication.  <b>(required)</b><br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>password</b> : password email yang digunakan sebagai authentication.  <b>(required)</b><br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>mail_from</b> : tag from yang akan di terima oleh penerima email 'pastikan from ini terdaftar pada mail server'.  <b>(required)</b><br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>mail_fromname</b> : tag digunakan sebagai name pada from sebelumnya. <br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>subject</b> : sebagai subject email. <b>(required)</b><br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>to</b> : alamat email yang akan menerima. gunakan tanda (koma) untuk multiple address.<b>(required)</b><br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>cc</b> : alamat email yang akan menerima sebagai cc. gunakan tanda (koma) untuk multiple address.<br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>bcc</b> : alamat email yang akan menerima sebgai bcc. gunakan tanda (koma) untuk multiple address.<br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>body</b> : isi dari body email. <br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>body_file</b> : apabila body mengambil isi dari file. <br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>bodyHTML</b> : <i>true</i> apabila ingin format body html true, <i>false</i> apabila ingin format body html false. default value = false. <br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>attachment</b> : Apabila ingin menambahkan attachment file. <br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <b>source</b> : Isikan dari sumber pengirim email agar mudah dalam melakukan trace. <br><br>
Example : <br><br>
curl -X POST  -F 'host=mail.infinetworks.com' -F 'username=infra@infinetworks.com' -F 'password=PASSXXXX' -F 'mail_from=support@infinetworks.com' -F 'mail_fromname=SUPPORT NOTIF' -F 'subject=Subjec Email' -F 'to=ops@infinetworks.com' -F 'cc=infra@infinetworks.com' -F 'bcc=ahmad.fairus@infinetworks.com' -F 'body_file=@file_body.txt' -F 'bodyHTML=true' -F 'attachment=@file_attachment.zip' -F 'source=10.x.x.x' http://10.102.5.16:8085/send_mail.php

<br><br><br><br>
Created by Ahmad Fairus Nofianto
