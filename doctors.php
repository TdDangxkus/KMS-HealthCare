<?php

include 'dump_data.php';

$perPage = 8; // số bác sĩ trên 1 trang
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Tính offset
$offset = ($page - 1) * $perPage;

// Tính tổng số trang
$totalDoctors = count($doctors);
$totalPages = ceil($totalDoctors / $perPage);

// Lấy bác sĩ cho trang hiện tại bằng hàm array_slice
$offset = ($page - 1) * $perPage;
$doctors = array_slice($doctors, $offset, $perPage);
// Lấy tổng số bác sĩ
// $result = $conn->query("SELECT COUNT(*) as total FROM doctors");
// $row = $result->fetch_assoc();
// $totalDoctors = $row['total'];

// // Tính tổng số trang
// $totalPages = ceil($totalDoctors / $perPage);

// // Lấy bác sĩ theo trang
// $sql = "SELECT * FROM doctors LIMIT $perPage OFFSET $offset";
// $doctors = $conn->query($sql);


$keyword = $_GET['keyword'] ?? '';
$facility = $_GET['facility'] ?? '';
$specialty = $_GET['specialty'] ?? '';

// Lọc dữ liệu từ mảng giả
$results = array_filter($doctors, function ($doctor) use ($keyword, $facility, $specialty) {
    // So sánh không phân biệt hoa thường
    $matchKeyword = empty($keyword) || stripos($doctor['name'], $keyword) !== false || stripos($doctor['specialty'], $keyword) !== false;
    $matchFacility = empty($facility) || $doctor['facility'] === $facility;
    $matchSpecialty = empty($specialty) || $doctor['specialty'] === $specialty;

    return $matchKeyword && $matchFacility && $matchSpecialty;
});
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bác sĩ - Qickmed Medical & Health Care</title>
    <meta name="description" content="Gặp gỡ đội ngũ bác sĩ chuyên nghiệp tại Qickmed, tận tâm khám chữa với trang thiết bị hiện đại, mang lại chăm sóc y tế toàn diện và hiệu quả.">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/css/team.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <section class="page-banner-area bg-3 pt-100">
            <div class="container">
                <div class="page-banner-content">

                    <h2>Tìm bác sĩ</h2>
                    <ol class="breadcrumb p-3 bg-body-tertiary rounded-3">
                        <li class="breadcrumb-item"> <a class="link-body-emphasis" href="./index.php"><i class="fas fa-home"></i> <span class="visually-hidden">Home</span> </a> </li>
                        <li class="breadcrumb-item"> <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Đội ngũ bác sĩ</a> </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Bác sĩ
                        </li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="find-doctor-area pt-5">
            <div class="container">
                <!-- Tiêu đề tìm bác sĩ -->
                <div class="find-doctor-title text-center">
                    <h2 class="section-title">Tìm bác sĩ</h2>
                    <p class="section-description">Tìm chuyên gia y tế tại bệnh viện QickMed</p>
                </div>

                <!-- Form tìm kiếm bác sĩ -->
                <form class="find-doctors">
                    <div class="row">

                        <!-- Tìm kiếm từ khóa -->
                        <div class="col-lg-12 ">
                            <label>TÌM KIẾM THEO:</label>
                            <div class="form-group ">
                                <input type="text" class="form-control src pe-5" placeholder="Tìm theo chuyên khoa, tình trạng hoặc tên bác sĩ">
                                <button type="submit" class="search-icon-btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Chọn cơ sở -->
                        <div class="col-lg-6">
                            <label>CƠ SỞ</label>
                            <div class="form-group">
                                <select class="form-select form-control" aria-label="Chọn cơ sở">
                                    <option selected>Tất cả cơ sở qickmed</option>
                                    <option value="1">Cơ sở qickmed</option>
                                    <option value="1">Cơ sở qickmed</option>
                                    <option value="1">Cơ sở qickmed</option>


                                </select>
                            </div>
                        </div>
                        <!-- Chọn chuyên khoa -->
                        <div class="col-lg-6 ">
                            <label>CHUYÊN KHOA</label>
                            <div class="form-group">
                                <select class="form-select form-control" aria-label="Chọn chuyên khoa">
                                    <option selected>Chọn chuyên khoa</option>
                                    <option value="Tim Mạch">Chuyên khoa Tim Mạch</option>
                                    <option value="Nội Khoa">Chuyên khoa Nội Khoa</option>
                                    <option value="Ngoại Khoa">Chuyên khoa Ngoại Khoa</option>
                                    <option value="Sản Khoa">Chuyên khoa Sản Khoa</option>
                                    <option value="Nhi Khoa">Chuyên khoa Nhi Khoa</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nút tìm kiếm -->
                        <div class="col-lg-12 ">
                            <button type="submit" class="btn btn-submit w-100">Tìm kiếm</button>
                        </div>

                    </div>
                </form>
            </div>
        </section>

        <section class="list-doctors ptb-100">
            <div class="container text-center">
                <h2 class="section-title">CHUYÊN GIA CỦA CHÚNG TÔI</h2>
                <p class="section-description">Chúng tôi có tất cả các chuyên gia chuyên nghiệp trong bệnh viện của chúng tôi</p>
                <div class="row g-4 mt-4">
                    <?php if (!empty($doctors)): ?>
                        <?php foreach ($doctors as $index => $doctor): ?>
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="card team-card h-100">
                                    <div class="team-image">
                                        <img src="<?= $doctor['photo'] ?>" class="card-img-top" alt="Doctor">
                                    </div>
                                    <div class="team-content">
                                        <h4 class="card-title"><?= $doctor['name'] ?></h4>
                                        <p class="team-specialty "><?= $doctor['specialty'] ?></p>
                                        <div class="team-social">
                                            <a href="#"><i class="fab fa-facebook"></i></a>
                                            <a href="#"><i class="fab fa-linkedin"></i></a>
                                            <a href="#"><i class="fas fa-envelope"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No doctors available at the moment.</p>
                    <?php endif; ?>
                </div>
                <!-- Pagination tương tự như trước -->
                <div class="col-lg-12">
                    <div class="pagination">
                        <div class=" page-numbers  page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                                <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <div class="page-item page-numbers <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </div>
                        <?php endfor; ?>

                        <div class="page-item page-numbers <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>


        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/assets/js/services.js"></script>
</body>

</html>