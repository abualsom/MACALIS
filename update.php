<!DOCTYPE html>
<html lang="ar" dir="rtl">
<?php
session_start();
include('conn.php');

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php'); 
    exit;
}
$update_id = $_GET['id'];
$update_query = "SELECT * FROM macales WHERE id = $update_id";

$select_datas = mysqli_query($conn, $update_query);
$data_select = mysqli_fetch_array($select_datas);

if (isset($_POST['submit'])) {
    if (!empty($_POST['location']) && !empty($_POST['day']) && !empty($_POST['book']) && !empty($_POST['teacher']) && !empty($_POST['ders_tame'])) {
        $location = $_POST["location"];
        $day = $_POST["day"];
        $book = $_POST["book"];
        $teacher = $_POST["teacher"];
        $notes = $_POST["notes"];
        $ders_tame = $_POST['ders_tame'];
        $adres = $_POST['adres'];
        $id = $_GET['id'];

        $update_data = "UPDATE macales SET 
                    location = '$location',
                    day = '$day',
                    book = '$book', 
                    teacher='$teacher',
                    notes = '$notes',
                    ders_tame = '$ders_tame',
                    adres = '$adres' where id = $id";

        mysqli_query($conn, $update_data);
        $conn->close();

        header('location: info_add.php');
        exit();
    }
}
?>

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap" rel="stylesheet" />

    <link rel="icon" href="heder-icon.png" type="image/png">

    <title>update_info</title>
    <style>
        * {
            box-sizing: border-box;

        }

        body {
            font-family: 'Noto Kufi Arabic', serif;

            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            text-align: right;

        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            font-size: 25px;
            display: block;
            height: 55px;
            border-radius: 9px;
            background-color: rgb(11, 153, 141);
            color: rgb(255, 255, 255);
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            /* لجعل النص في المنتصف أفقيًا */
            line-height: 55px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: rgb(11, 163, 151);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: center;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>تعديل معلومات الدروس</h2>
        <form action="" method="POST" onsubmit="return confirmEdit();">

            <div class="form-group">
                <label for="location">المكان:</label>
                <input
                    type="text"
                    id="location"
                    name="location"
                    placeholder="أدخل المكان"
                    value="<?php echo $data_select['location']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="day">اليوم:</label>
                <input
                    type="text"
                    id="day"
                    name="day"
                    placeholder="أدخل اليوم"
                    value="<?php echo $data_select['day']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="ders_tame">وقت الدرس:</label>
                <input
                    type="text"
                    id="ders_tame"
                    name="ders_tame"
                    placeholder="أدخل وقت الدرس"
                    value="<?php echo $data_select['ders_tame']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="book">اسم الكتاب:</label>
                <input
                    type="text"
                    id="book"
                    name="book"
                    placeholder="أدخل اسم الكتاب"
                    value="<?php echo $data_select['book']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="teacher">اسم الشيخ:</label>
                <input
                    type="text"
                    id="teacher"
                    name="teacher"
                    placeholder="أدخل اسم الشيخ"
                    value="<?php echo $data_select['teacher']; ?>">
            </div>

            <div class="form-group">
                <label for="adres">موقع الدرس:</label>
                <input
                    type="url"
                    id="adres"
                    name="adres"
                    placeholder="أدخل موقع الدرس (ملاحظة: ينبغي أن يكون موقع الدرس على شكل رابط ليتم فتحه عند المستخدم)"
                    value="<?php echo $data_select['adres']; ?>">
            </div>

            <div class="form-group">
                <label for="notes">الملاحظات:</label>
                <input
                    type="text"
                    id="notes"
                    name="notes"
                    placeholder="أدخل الملاحظات"
                    value="<?php echo $data_select['notes']; ?>">
            </div>

            <input
                class="button"
                type="submit"
                name="submit"
                value="تعديل البيانات">
        </form>


    </div>

    <script>
        function confirmEdit() {
            return confirm("هل أنت متأكد من أنك تريد تعديل البيانات؟");
        }
    </script>
</body>

</html>