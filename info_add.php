<?php

session_start();
include('conn.php');
// تحقق من تسجيل الدخول


if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
  header('Location: login.php'); // إعادة التوجيه لصفحة تسجيل الدخول
  exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submit'])) {
    if (!empty($_POST['location']) && !empty($_POST['day']) && !empty($_POST['book']) && !empty($_POST['teacher'])) {
      $location = $_POST["location"];
      $day = $_POST['day']; // ستكون مصفوفة
      $day_string = implode(' - ', $day);
      $book = $_POST["book"];
      $teacher = $_POST["teacher"];
      $notes = $_POST["notes"];
      $ders_tame = $_POST['ders_tame'];
      $adres = $_POST['adres'];
      // استعلام لإدخال البيانات
      $sql = "INSERT INTO macales (location, day , book , teacher , notes , ders_tame , adres) VALUES ('$location' , '$day_string', '$book' , '$teacher' , '$notes', '$ders_tame' , '$adres')";
      if ($conn->query($sql) === TRUE) {
        #echo "تم إضافة البيانات بنجاح!";
        header("Location: info_add.php");
        exit();
      } else {
        echo "خطأ في الإدخال: " .
          $conn->error;
      }
    }
  }
}
$sql_select = "SELECT * FROM macales ORDER BY  create_row DESC ";
$rows = $conn->query($sql_select);

$sql_select_1 = "SELECT * FROM location_add ORDER BY  create_row DESC ";
$rows_1 = $conn->query($sql_select_1);


?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet" />
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap"
    rel="stylesheet" />
  <link rel="icon" href="heder-icon.png"
    type="image/png">
  <!-- إضافة CSS الخاص بـ Select2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />

  <!-- إضافة JavaScript الخاص بـ Select2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <title>إضافة معلومات الدروس</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Noto Kufi Arabic', serif;

      background-color: #f5f5f5;
      margin: 0px 2px 8px;
      padding: 20px;
      direction: rtl;
      text-align: start;
    }

    .container {
      max-width: 1199px;
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
      background-color: rgb(11, 153, 141);
      font-size: 16px;
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
      background: #fff;
      /* خلفية الجدول مثل النموذج */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      /* ظل مشابه للنموذج */
      border-radius: 10px;
      /* الزوايا الدائرية */
      overflow: hidden;
      /* منع العناصر من الخروج خارج الحواف */
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
      /* تأثير عند التمرير */
    }

    .update {
      margin: 3px;
    }

    .get_serch,
    .get_location {
      text-decoration: none;
      color: rgb(11, 153, 141);
      display: block;
      text-align: center;
      margin-top: 15px;
      font-weight: 600;
      letter-spacing: -1px;
      word-spacing: -0.10cap;
    }
     .select2-selection.select2-selection--single,
         .select2-selection__rendered,
         .select2-selection__arrow {
            height: 48px !important;
        }

         .select2-selection__rendered,
         .select2-selection__arrow {
            line-height: 48px !important;
        }  
        
        .table-container {
            max-height: 400px;
            overflow-y: auto;
        }
        .table{
          width: 1000px;

        }
::-webkit-scrollbar {
  width:5px;
  height: 5px;
  border-radius: 20px;
  overflow: hidden;
}
::-webkit-scrollbar-track {
  background-color: rgba(11, 153, 141, 0.29);
  border-radius: 20px;

}
::-webkit-scrollbar-thumb {
  background-color: rgb(11, 153, 141);;
  border-radius: 20px;

}
.t-head {
  background-color: rgb(11, 153, 141);
  color: white;
  border-radius: 15px;
  padding: 15px 7px;
}

.t-head > h6:first-child ,
.t-body  h6:first-child {
  width: 24px !important;
}
.t-body  h6 ,
.t-head > h6,
.t-body  .actions{
  width: calc(100% / 7);
  text-align: center;
  flex-shrink: 0;
  margin-bottom: 0;
}
.head {
  position: sticky;
  padding-bottom: 10px;
  top: 0;
}

.t-body > div {
  padding: 15px 7px;
  border-radius: 15px;
}
.t-body > div:nth-child(even) {
  background-color: rgba(11, 153, 141, 0.3);
}
.t-body > div:nth-child(odd) {
  background-color: rgba(11, 153, 141, 0.1);
}
.t-body  h6 {
  font-size: 14px;
}
.t-body {
  margin-top: 10px;;
}
.t-body > div:not(:last-child) {
  margin-bottom: 10px;
}
  </style>
</head>

<body>
  <div class="container">
    <h2>إضافة معلومات الدروس</h2>

    <!-- نموذج إضافة معلومات الدرس -->
    <form action="" method="POST">
      <div class="form-group">
        <label for="location">المنطقة:</label>
        <select class="form-control select2" id="location" name="location" required>
          <option value="" disabled selected>اختر المنطقة</option>
          <?php
          if ($rows_1->num_rows > 0) {
            while ($row_1 = $rows_1->fetch_assoc()) {
              echo '<option value="' . $row_1['location_name'] . '">' . $row_1['location_name'] . '</option>';
            }
          } else {
            echo '<option value="" disabled>لا توجد أماكن مضافة</option>';
          }
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="day" style="position: relative; top: -4px;">اليوم:</label>
        <select multiple  class="form-control" id="day" name="day[]" required style="line-height: 2; padding-top: 2px;">
          <option value="الجمعة">الجمعة</option>
          <option value="السبت">السبت</option>
          <option value="الأحد">الأحد</option>
          <option value="الإثنين">الإثنين</option>
          <option value="الثلاثاء">الثلاثاء</option>
          <option value="الأربعاء">الأربعاء</option>
          <option value="الخميس">الخميس</option>
        </select>
      </div>
      <div class="form-group">
        <label for="ders_tame">وقت الدرس:</label>
        <input
          type="text"
          id="ders_tame"
          placeholder="أدخل وقت الدرس"
          name="ders_tame"
          required />
      </div>

      <div class="form-group">
        <label for="book">اسم الكتاب:</label>
        <input
          type="text"
          id="book"
          placeholder="أدخل اسم الكتاب"
          name="book" />
      </div>
      <div class="form-group">
        <label for="teacher">اسم الشيخ:</label>
        <input
          type="text"
          id="teacher"
          placeholder="أدخل اسم الشيخ"
          name="teacher" />
      </div>
      <div class="form-group">
        <label for="adres">موقع الدرس على الخرائط:</label>
        <input
          type="url"
          id="adres"
          placeholder="أدخل موقع الدرس (ملاحظة: ينبغي أن يكون موقع الدرس على شكل رابط ليتم فتحه عند المستخدم)"
          name="adres" />
      </div>
      <div class="form-group">
        <label for="notes">الملاحظات:</label>
        <textarea
          class="form-control"
          id="notes"
          placeholder="أدخل الملاحظات"
          name="notes"
          rows="6"
          style="width: 100%"></textarea>
      </div>
      <div class="d-flex justify-content-center">
        <input
          class="button btn btn-success"
          type="submit"
          name="submit"
          value="إضافة البيانات" />
      </div>
      <a href="serch.php" class="get_serch">الذهاب إلى صفحة البحث</a>
      <a href="location_add.php" class="get_location">الذهاب لإضافة مكان جديد</a>


    </form>


    <div class="table-container">
      <div class="table flex-column p-2 d-flex aliicn-items-center rounded mt-4" id="lessons-table">
        <h5 class="my-3 flex-grow-1 text-center">قائمة المعلومات</h5>
        <div class="head bg-white">
        <div class="t-head d-flex align-items-center">
          <h6>#</h6>
          <h6>المنطقة</h6>
          <h6>اليوم</h6>
          <h6>وقت الدرس</h6>
          <h6>اسم الكتاب</h6>
          <h6>اسم الشيخ</h6>
          <h6>الملاحظات</h6>
          <h6>الإجراءات</h6>
        </div>
        </div>
        <div class="t-body">
        <?php
          if ($rows->num_rows > 0) {
            while ($row = $rows->fetch_assoc()) {
              echo '
              <div class="d-flex align-items-center">
                  <h6>' . $row['id'] . '</h6>
                  <h6>' . $row['location'] . '</h6>
                  <h6>' . $row['day'] . '</h6>
                  <h6>' . $row['ders_tame'] . '</h6>
                  <h6>' . $row['book'] . '</h6>
                  <h6>' . $row['teacher'] . '</h6>
                  <h6>' . $row['notes'] . '</h6>
                  <div class="actions">
                      <div class="d-flex justify-content-center gap-2 align-items-center">
                          <a class="btn px-2 btn-primary update" href="update.php?id=' . $row['id'] . '">
                              <i class="bi bi-pencil-square"></i>
                          </a>
                          <a class="btn px-2 btn-danger" href="delet.php?id=' . $row['id'] . '" onclick="return confirmDelete();">
                              <i class="bi bi-trash"></i>
                          </a>
                      </div>
                  </div>
              </div>
              ';
            }
          } else {
            echo '
            <tr>
              <td colspan="8">لا توجد بيانات</td>
            </tr>
            ';
          } ?>
        </div>
      </div>
    </div>
    <script>
      function confirmDelete() {
        return confirm('هل أنت متأكد أنك تريد حذف هذا العنصر؟');
      }
    </script>
    <script>
      $(document).ready(function() {

        $('.select2').select2({
          placeholder: "اختر المنطقة",
          allowClear: true,
          width: '100%'
        });
      });
    </script>


</body>

</html>

<?php
$conn->close();
?>