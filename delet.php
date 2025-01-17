<?php
include('conn.php');
if (isset($_GET['id'])) {
    $delet_id = intval($_GET['id']); // تأكد من أن id هو رقم صحيح
    $query = "DELETE FROM macales WHERE id = ?";

    // استخدام Prepared Statements للحماية من SQL Injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $delet_id);

    if ($stmt->execute()) {
        header('Location: info_add.php');
        exit;
    } else {
        echo "حدث خطأ أثناء الحذف!";
    }

    $stmt->close();
} else {
    echo "المعرف غير موجود!";
}

$conn->close();
?>