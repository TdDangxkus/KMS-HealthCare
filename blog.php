<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Qickmed Medical & Health Care</title>
    <meta name="description" content="Đọc những bài viết y khoa mới nhất, mẹo chăm sóc sức khỏe và tin tức y tế từ các chuyên gia tại Qickmed.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/blog.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-8 mx-auto text-center">
                        <div class="hero-content">
                            <h1 class="hero-title">Blog Y Khoa</h1>
                            <p class="hero-subtitle">
                                Khám phá kiến thức y khoa hữu ích, mẹo chăm sóc sức khỏe và 
                                những thông tin mới nhất từ giới y tế
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Posts -->
        <section class="blog-section py-5">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <div class="row g-4">
                            <!-- Featured Post -->
                            <div class="col-12">
                                <article class="blog-post featured">
                                    <div class="post-image">
                                        <img src="/assets/images/blog-featured.jpg" alt="Bài viết nổi bật" class="img-fluid">
                                        <div class="post-badge">Nổi bật</div>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-category">Chăm sóc sức khỏe</span>
                                            <span class="post-date">15/12/2024</span>
                                        </div>
                                        <h2>10 Cách Tăng Cường Hệ Miễn Dịch Tự Nhiên</h2>
                                        <p>Khám phá những phương pháp đơn giản nhưng hiệu quả để tăng cường hệ miễn dịch của bạn thông qua chế độ ăn uống, lối sống và các hoạt động hàng ngày...</p>
                                        <div class="post-footer">
                                            <div class="post-author">
                                                <img src="/assets/images/author-1.jpg" alt="BS. Nguyễn Văn A">
                                                <span>BS. Nguyễn Văn A</span>
                                            </div>
                                            <a href="#" class="read-more">Đọc tiếp <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <!-- Regular Posts -->
                            <div class="col-md-6">
                                <article class="blog-post">
                                    <div class="post-image">
                                        <img src="/assets/images/blog-1.jpg" alt="Dinh dưỡng" class="img-fluid">
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-category">Dinh dưỡng</span>
                                            <span class="post-date">12/12/2024</span>
                                        </div>
                                        <h3>Chế Độ Ăn Uống Lành Mạnh Cho Tim Mạch</h3>
                                        <p>Tìm hiểu về những thực phẩm tốt cho tim mạch và cách xây dựng chế độ ăn uống khoa học...</p>
                                        <div class="post-footer">
                                            <div class="post-author">
                                                <img src="/assets/images/author-2.jpg" alt="BS. Trần Thị B">
                                                <span>BS. Trần Thị B</span>
                                            </div>
                                            <a href="#" class="read-more">Đọc tiếp</a>
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <div class="col-md-6">
                                <article class="blog-post">
                                    <div class="post-image">
                                        <img src="/assets/images/blog-2.jpg" alt="Tập thể dục" class="img-fluid">
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-category">Thể dục</span>
                                            <span class="post-date">10/12/2024</span>
                                        </div>
                                        <h3>Lợi Ích Của Việc Tập Thể Dục Đều Đặn</h3>
                                        <p>Khám phá những lợi ích tuyệt vời của việc duy trì thói quen tập luyện thể dục hàng ngày...</p>
                                        <div class="post-footer">
                                            <div class="post-author">
                                                <img src="/assets/images/author-3.jpg" alt="BS. Lê Văn C">
                                                <span>BS. Lê Văn C</span>
                                            </div>
                                            <a href="#" class="read-more">Đọc tiếp</a>
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <div class="col-md-6">
                                <article class="blog-post">
                                    <div class="post-image">
                                        <img src="/assets/images/blog-3.jpg" alt="Giấc ngủ" class="img-fluid">
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-category">Giấc ngủ</span>
                                            <span class="post-date">08/12/2024</span>
                                        </div>
                                        <h3>Tầm Quan Trọng Của Giấc Ngủ Chất Lượng</h3>
                                        <p>Hiểu rõ về tác động của giấc ngủ đến sức khỏe và cách cải thiện chất lượng giấc ngủ...</p>
                                        <div class="post-footer">
                                            <div class="post-author">
                                                <img src="/assets/images/author-4.jpg" alt="BS. Phạm Thị D">
                                                <span>BS. Phạm Thị D</span>
                                            </div>
                                            <a href="#" class="read-more">Đọc tiếp</a>
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <div class="col-md-6">
                                <article class="blog-post">
                                    <div class="post-image">
                                        <img src="/assets/images/blog-4.jpg" alt="Stress" class="img-fluid">
                                    </div>
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-category">Tâm lý</span>
                                            <span class="post-date">05/12/2024</span>
                                        </div>
                                        <h3>Quản Lý Stress Hiệu Quả Trong Cuộc Sống</h3>
                                        <p>Học cách nhận biết và quản lý stress để duy trì sức khỏe tinh thần tốt...</p>
                                        <div class="post-footer">
                                            <div class="post-author">
                                                <img src="/assets/images/author-5.jpg" alt="ThS. Hoàng Văn E">
                                                <span>ThS. Hoàng Văn E</span>
                                            </div>
                                            <a href="#" class="read-more">Đọc tiếp</a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <nav class="blog-pagination mt-5">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Trước</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Sau</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <div class="blog-sidebar">
                            <!-- Search -->
                            <div class="sidebar-widget">
                                <h4>Tìm kiếm</h4>
                                <div class="search-box">
                                    <input type="text" placeholder="Tìm kiếm bài viết..." class="form-control">
                                    <button class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Categories -->
                            <div class="sidebar-widget">
                                <h4>Danh mục</h4>
                                <ul class="category-list">
                                    <li><a href="#">Chăm sóc sức khỏe <span>(15)</span></a></li>
                                    <li><a href="#">Dinh dưỡng <span>(12)</span></a></li>
                                    <li><a href="#">Thể dục <span>(8)</span></a></li>
                                    <li><a href="#">Giấc ngủ <span>(6)</span></a></li>
                                    <li><a href="#">Tâm lý <span>(10)</span></a></li>
                                    <li><a href="#">Y học <span>(20)</span></a></li>
                                </ul>
                            </div>

                            <!-- Recent Posts -->
                            <div class="sidebar-widget">
                                <h4>Bài viết mới nhất</h4>
                                <div class="recent-posts">
                                    <div class="recent-post">
                                        <img src="/assets/images/recent-1.jpg" alt="Bài viết">
                                        <div class="recent-post-content">
                                            <h6>Cách Phòng Ngừa Cảm Cúm Mùa Đông</h6>
                                            <span class="date">18/12/2024</span>
                                        </div>
                                    </div>
                                    <div class="recent-post">
                                        <img src="/assets/images/recent-2.jpg" alt="Bài viết">
                                        <div class="recent-post-content">
                                            <h6>Vitamin D: Tầm Quan Trọng Và Nguồn Cung Cấp</h6>
                                            <span class="date">16/12/2024</span>
                                        </div>
                                    </div>
                                    <div class="recent-post">
                                        <img src="/assets/images/recent-3.jpg" alt="Bài viết">
                                        <div class="recent-post-content">
                                            <h6>Bài Tập Yoga Đơn Giản Tại Nhà</h6>
                                            <span class="date">14/12/2024</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Newsletter -->
                            <div class="sidebar-widget newsletter">
                                <h4>Đăng ký nhận tin</h4>
                                <p>Nhận thông tin y khoa mới nhất qua email</p>
                                <form class="newsletter-form">
                                    <input type="email" placeholder="Email của bạn" class="form-control">
                                    <button type="submit" class="btn btn-primary">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/assets/js/blog.js"></script>
</body>
</html> 