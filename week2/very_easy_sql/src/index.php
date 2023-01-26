<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>非常简单的sql注入</title>
</head>

<body>
  <p>请简单学习一些sql注入的原理以及简单的操作，然后用最简单的姿势就能拿到flag，加油！</p>
  <br>
  <h1>留言板登录界面</h1>
  <form action="index.php" method="post">
    <p>用户名：<input type="text" name="username" placeholder="请输入用户名"></p>
    <p>密码：<input type="password" name="password" placeholder="请输入密码"></p>
    <p><input type="submit" value="登录"></p>
  </form>
</body>

</html>

<?php
$username = $_POST['username'];
$password = $_POST['password'];
session_start();
$conn = mysqli_connect("127.0.0.1", "root", "root", "ez_sql");
if ($conn->connect_error) {
    die("环境出错了，请联系群管理" . $conn->connect_error);
}

if ($username == "" || $password == "") {
    echo "用户名或密码不能为空！";
    exit;
} else {
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    // echo $sql . "<br>";
    // echo serialize(mysqli_query($conn, $sql)) . "<br>";
    if ($result = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_row($result);
        if ($row) {
            echo "用户：" . $row[1] . " 欢迎登录！" . "<br>";
        } else {
            echo "用户: " . $username . " 不存在或密码错误！";
        }
    } else {
        echo "啊哦，出错了！";
    }
}
?>