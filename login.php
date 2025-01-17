<?php
include('conn.php');
session_start();

$error_massage = " ";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['user_name'];
    $password = $_POST['password'];
    if (!empty($name) && !empty($password)) {
        $query = "SELECT id, user_name, password FROM users WHERE user_name = ? AND password = ?";

        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ss", $name, $password);

            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION['is_admin'] = true;
                header("Location: info_add.php");
                exit;
            } else {
                $error_massage = "كلمة المرور أو اسم المستخدم غير صحيح";
            }

            $stmt->close();
        } else {
            $error_massage = "فشل في تجهيز الاستعلام.";
        }
    } else {
        $error_massage = "يرجى ملء جميع الحقول.";
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نموذج تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="heder-icon.png"
        type="image/png">

    <style>
        .forgot-password {
            text-decoration: none;
            color: red;
            display: block;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        body {
            direction: rtl;
            text-align: right;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        input.form-control {
            border: 1.5px solid #333;
        }

        label.form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h3 class="text-center mb-4">تسجيل الدخول</h3>
        <form action="" method="POST">
            <!-- رسالة الخطأ -->
            <?php if (!empty($error_massage)) { ?>
                <div class="text-danger text-center fw-bold mb-3">
                    <?php echo $error_massage; ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label for="username" class="form-label">اسم المستخدم</label>
                <input type="username" class="form-control" id="username" name="user_name" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success w-100" style="background-color: rgb(11, 163, 151);">تسجيل الدخول</button>
            <a href="https://t.me/m/THsU-_qcOTg0" class="forgot-password"> لقد نسيت كلمة المرور </a>
        </form>
    </div>
</body>

</html>