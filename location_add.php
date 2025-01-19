<?php
include('conn.php');
session_start();

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php'); 
    exit;
}
$error_massage = " ";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['location_name'])) {
        if (!empty($_POST['location_name'])) {
            $location_name = $_POST["location_name"];

            $sql = "INSERT INTO location_add (location_name) VALUE ('$location_name')";
            if ($conn->query($sql) === TRUE) {
                echo "تم إضافة البيانات بنجاح!";
                header("Location: location_add.php");
                exit();
            } else {
                echo "خطأ في الإدخال: " . $conn->error;
            }
        }
    }
}
$sql_select = "SELECT * FROM location_add ORDER BY create_row DESC ";
$rows = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مكان جديد</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="heder-icon.png" type="image/png">

    <style>
        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
            text-align: start;

        }

        .container {
            max-width: 800px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            padding: 20px;
        }

        h3 {
            background-color: #0b998d;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .button {
            background-color: #0b998d;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #088e7e;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            text-align: center;
            align-items: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: rgb(11, 153, 141);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: rgba(11, 153, 141, 0.1);
        }

        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        a.get_home {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #0b998d;
            text-decoration: none;
            font-weight: bold;
        }

        a.get_home:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="POST" class="form-group">
            <h3>إضافة منطقة</h3>

            <div class="form-group">
                <label for="location_name">اكتب اسم المنطقة:</label>
                <input type="text" class="form-control" id="location_name" name="location_name" placeholder="اسم المنطقة" required>
            </div>

            <div class="text-center">
                <input type="submit" class="button" name="submit" value="إضافة البيانات">
            </div>

            <a href="info_add.php" class="get_home">الذهاب إلى الصفحة الرئيسية</a>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المنطقة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($rows->num_rows > 0) {
                            while ($row = $rows->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . $row['location_name'] . '</td>';
                                echo '<td>
                                        <a class="btn btn-primary" href="location_update.php?id=' . $row['id'] . '"><i class="bi bi-pencil-square"></i></a>
                                        <a class="btn btn-danger" href="location_delet.php?id=' . $row['id'] . '" onclick="return confirmDelete();"><i class="bi bi-trash"></i></a>
                                      </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="3">لا توجد بيانات</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script>
        function confirmDelete() {
            return confirm('هل أنت متأكد أنك تريد حذف هذا العنصر؟');
        }
    </script>
</body>

</html>