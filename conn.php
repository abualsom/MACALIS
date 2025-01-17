<?php

// تحقق من تسجيل الدخول
/* if (!isset($_SESSION['id'])) {
  header("Location: login.php"); // إعادة التوجيه إلى صفحة تسجيل الدخول إذا لم يكن هناك جلسة
  exit();} */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "macales-hair";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
?>