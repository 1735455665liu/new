<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>注册</h1>
<form action="regdo" method="post">
    @csrf
    用户名<input type="text" name="name"><br>
    密码<input type="password" name="pass"><br>
    邮箱<input type="text" name="email"><br>
    <input type="submit" value="注册">
</form>


</body>
</html>