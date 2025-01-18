<!DOCTYPE html>
<html lang="ar" dir="rtl">
<?php
include('conn.php');
session_start();

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>عرض أماكن الدروس</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100..900&display=swap"
        rel="stylesheet" />
    <link rel="icon" href="heder-icon.png"
        type="image/png">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: right;
            background-color: rgb(255, 255, 255);
            font-family: 'Noto Kufi Arabic', serif;
            margin: 0px 2px 14px;
        }

        .container {
            margin-top: 30px;
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
            line-height: 55px;
        }

        h4 {
            font-size: 14.5px;
            display: flex;
            /* استخدام flexbox */
            justify-content: center;
            /* محاذاة النص أفقيًا */
            align-items: center;
            /* محاذاة النص عموديًا */
            height: 45px;
            border-radius: 5px;
            background-color: rgb(153, 11, 11);
            color: rgb(255, 255, 255);
            font-weight: bold;
            text-align: center;
            margin-bottom: 25px;
            /* مسافة أسفل العنصر */
            padding: 0;
        }

        /* التنسيق الخاص بالشاشات الكبيرة (لابتوب وأجهزة أكبر) */
        @media (min-width: 768px) {
            h4 {
                width: 50%;
                /* عرض المربع يصبح نصف عرض الصفحة */
                max-width: 600px;
                /* حد أقصى للعرض */
                min-width: 300px;
                /* حد أدنى للعرض */
                margin: 0 auto 23px;
                /* يضع العنصر في منتصف الصفحة ويضيف مسافة إضافية أسفل العنصر */
                font-size: 22px;
            }
        }


        .btn-primary {
            background-color: rgb(11, 153, 141);
            border-color: rgb(17, 118, 119);
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
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

        .form-control {
            margin-bottom: 10px;
        }

        .form-group {
            width: 100%;
        }

        @media (min-width: 991px) {
            .form-group:not(:last-child) {
                padding-inline-end: 10px;
            }

            .form-group {
                width: 50%;
            }
        }

        @media (min-width: 1200px) {
            .form-group {
                width: 33.3%;
            }
        }

        .form-group label {
            font-weight: bold;
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

        .get_whatsapp {
            text-decoration: none;
            color: rgb(11, 153, 141);
            display: block;
            text-align: center;
            margin-top: 15px;
            font-weight: 600;
            letter-spacing: -1px;
            word-spacing: -0.10cap;
        }

        .link-icon {
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .link-icon:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="container bg-white p-3 rounded shadow">
        <h2 class="text-center"> أماكن مجالس العلم والخير</h2>
        <h4>يمكنك البحث باستخدام أحد هذه الخيارات أو كلها </h4>
        <form action="" method="GET" class="needs-validation" novalidate>
            <div class="d-flex flex-wrap">
                <div class="form-group d-flex flex-column">
                    <!-- <label for="location">اختر المنطقة:</label> -->
                    <select
                        id="location"
                        name="location"
                        class="form-control mx-auto"
                        required>
                        <option value="">اختر المنطقة</option>
                        <?php
                        $location_query = "SELECT DISTINCT location FROM macales";
                        $location_result = $conn->query($location_query);
                        while ($row = $location_result->fetch_assoc()) {
                            echo '
              <option value="' . htmlspecialchars($row['location']) . '">
                ' . htmlspecialchars($row['location']) . '
              </option>
              ';
                        } ?>
                    </select>
                </div>

                <div class="form-group d-flex flex-column">
                    <!-- <label for="day">اختر اليوم:</label> -->
                    <select id="day" name="day" class="form-control mx-auto" required>
                        <option value="">اختر اليوم </option>
                        <option value="الجمعة">الجمعة</option>
                        <option value="السبت">السبت</option>
                        <option value="الأحد">الأحد</option>
                        <option value="الإثنين">الإثنين</option>
                        <option value="الثلاثاء">الثلاثاء</option>
                        <option value="الأربعاء">الأربعاء</option>
                        <option value="الخميس">الخميس</option>

                    </select>

                </div>
                <div class="form-group d-flex flex-column">
                    <!-- <label for="teacher">اختر الشيخ:</label> -->
                    <select
                        id="teacher"
                        name="teacher"
                        class="form-control mx-auto"
                        required>
                        <option value="">اختر الشيخ</option>
                        <?php
                        $teacher_query = "SELECT DISTINCT teacher FROM macales";
                        $teacher_result = $conn->query($teacher_query);
                        while ($row
                            = $teacher_result->fetch_assoc()
                        ) {
                            echo '
              <option value="' . htmlspecialchars($row['teacher']) . '">
                ' . htmlspecialchars($row['teacher']) . '
              </option>
              ';
                        } ?>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" name="submit" class="btn btn-primary px-5 py-2">
                    ابحث
                </button>
            </div>


            <?php if (!$is_admin): ?>
                <a href="https://wa.me/905527999985" class="get_whatsapp">تواصل معنا لإضافة الدروس أو تعديلها</a>
            <?php endif; ?>
        </form>

        <?php if ($is_admin): ?>
            <div class="text-center mt-3">
                <a href="info_add.php" class="get_whatsapp">إضافة بيانات جديدة</a>
            </div>
        <?php endif; ?>

        <div class="w-100 overflow-auto mt-4" style="max-height: 500px">
            <table class="table table-bordered table-striped table-hover">
                <thead class="sticky-top bg-light">
                    <tr>
                        <th>#</th>
                        <th>المنطقة</th>
                        <th>اليوم</th>
                        <th>وقت الدرس</th>
                        <th>اسم الكتاب</th>
                        <th>اسم الشيخ</th>
                        <th>الملاحظات</th>
                        <th>الموقع</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                        if (isset($_GET['submit'])) {
                            $conditions = [];

                            if (!empty($_GET['location'])) {
                                $location = trim($_GET['location']);
                                $conditions[] = "location = '$location'";
                            }

                            if (!empty($_GET['ders_tame'])) {
                                $ders_tame = trim($_GET['ders_tame']);
                                $conditions[] = "ders_tame = '$ders_tame'";
                            }

                            if (!empty($_GET['day'])) {
                                $day = trim($_GET['day']);
                                $conditions[] = "day LIKE '%$day%'";
                            }

                            if (!empty($_GET['teacher'])) {
                                $teacher = trim($_GET['teacher']);
                                $conditions[] = "teacher = '$teacher'";
                            }

                            if (count($conditions) > 0) {
                                $sql_select = "SELECT * FROM macales WHERE " . implode(" AND ", $conditions) . " ORDER BY create_row DESC";
                                $rows = $conn->query($sql_select);
                            } else {
                                echo '
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            يرجى تحديد على الأقل قيمة واحدة للبحث.
                                        </td>
                                    </tr>
                                ';
                            }
                        }
                    }

                    if (isset($_GET['submit'])) {
                        if (!empty($rows)) {
                            if ($rows->num_rows > 0) {
                                while ($row = $rows->fetch_assoc()) {
                                    echo '
                                        <tr>
                                            <td>' . $row['id'] . '</td>
                                            <td>' . $row['location'] . '</td>
                                            <td>' . $row['day'] . '</td>
                                            <td>' . $row['ders_tame'] . '</td>
                                            <td>' . $row['book'] . '</td>
                                            <td>' . $row['teacher'] . '</td>
                                            <td>' . $row['notes'] . '</td>
                                    ';
                                    echo '
                                        <td>
                                            <div class="d-flex justify-content-center gap-2 align-items-center">
                                                <a class="py-2 btn btn-warning update" href="' . $row['adres'] . '">
                                                    <i class="bi bi-cursor" id="icon" data-link=""></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    ';
                                }
                            } else {
                                echo '
                                    <tr>
                                        <td colspan="8" class="text-center">لا توجد بيانات</td>
                                    </tr>
                                ';
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#location').select2();
        $('#teacher').select2();
        $('#day').select2();
    });
</script>



</body>

</html>

</body>

</html>