<!DOCTYPE html>
<html lang="ar" dir="rtl">
<?php
session_start();
include('conn.php');

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit;
}

$update_id = $_GET['id'];
$update_query = "SELECT * FROM location_add WHERE id = $update_id";
$select_datas = mysqli_query($conn, $update_query);
$data_select = mysqli_fetch_array($select_datas);

if (isset($_POST['submit'])) {
    if (!empty($_POST['location_name'])) {
        $location_name = $_POST["location_name"];
        $id = $_GET['id'];

        $update_data = "UPDATE location_add SET location_name = '$location_name' WHERE id = $id";
        mysqli_query($conn, $update_data);
        $conn->close();

        header('Location: location_add.php');
        exit();
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المكان</title>
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
            padding: 20px;
            text-align: start;

        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h3 {
            background-color: #0b998d;
            color: #fff;
            text-align: center;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 26px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .button {
            background-color: #0b998d;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .button:hover {
            background-color: #088e7e;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>تعديل معلومات الأماكن</h3>
        <form action="" method="POST" onsubmit="return confirmEdit();">
            <div class="form-group">
                <label for="location_name">اسم المكان:</label>
                <input type="text" id="location_name" name="location_name" placeholder="أدخل اسم المكان" value="<?php echo $data_select['location_name']; ?>" required>
            </div>
            <input type="submit" name="submit" class="button" value="تعديل البيانات">
        </form>
    </div>

    <script>
        function confirmEdit() {
            return confirm("هل أنت متأكد أنك تريد تعديل البيانات؟");
        }
    </script>
</body>
</html>
