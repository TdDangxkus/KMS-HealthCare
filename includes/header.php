<!-- Header / Navigation Bar -->
<style>
/* Dropdown Menu Styles */
.dropdown-menu {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-radius: 0.5rem;
    padding: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

/* Multi-level Dropdown */
.dropdown-submenu {
    position: relative;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-top: -0.5rem;
    margin-left: 0.1rem;
    display: none;
}

.dropdown-submenu:hover > .dropdown-menu {
    display: block;
}

.dropdown-submenu > a:after {
    display: block;
    content: " ";
    float: right;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
    border-width: 5px 0 5px 5px;
    border-left-color: #6c757d;
    margin-top: 5px;
    margin-right: -10px;
}

/* Search Box Styles */
.search-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(13, 110, 253, 0.2));
    backdrop-filter: blur(10px);
    z-index: 1000;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.search-overlay.active {
    opacity: 1;
}

.search-box {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    padding: 3rem 2.5rem;
    border-radius: 2rem;
    width: 90%;
    max-width: 750px;
    position: relative;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 
        0 30px 60px rgba(0, 0, 0, 0.2),
        0 0 0 1px rgba(255, 255, 255, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
    transform: scale(0.8) translateY(50px);
    transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.search-overlay.active .search-box {
    transform: scale(1) translateY(0);
}

.search-header {
    text-align: center;
    margin-bottom: 2rem;
}

.search-title {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.search-subtitle {
    color: #718096;
    font-size: 1rem;
}

.search-input-wrapper {
    position: relative;
    margin-bottom: 1.5rem;
}

.search-box input {
    width: 100%;
    padding: 1.5rem 4rem 1.5rem 3.5rem;
    border: 2px solid rgba(226, 232, 240, 0.8);
    border-radius: 1.25rem;
    font-size: 1.1rem;
    background: rgba(255, 255, 255, 0.9);
    color: #2d3748;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.search-box input:focus {
    outline: none;
    border-color: #667eea;
    background: rgba(255, 255, 255, 1);
    box-shadow: 
        0 0 0 4px rgba(102, 126, 234, 0.1),
        0 8px 25px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.search-box input::placeholder {
    color: #a0aec0;
    font-weight: 400;
}

.search-icon {
    position: absolute;
    left: 1.5rem;
    top: 50%;
    transform: translateY(-50%);
    color: #a0aec0;
    font-size: 1.2rem;
    pointer-events: none;
    transition: all 0.3s ease;
}

.search-box input:focus + .search-icon {
    color: #667eea;
    transform: translateY(-50%) scale(1.1);
}

.search-box .close-search {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #a0aec0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.search-box .close-search:hover {
    color: #e53e3e;
    background: rgba(229, 62, 62, 0.1);
    transform: scale(1.1) rotate(90deg);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Loading Animation */
.search-loading {
    display: none;
    position: absolute;
    right: 4rem;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
}

.search-loading.active {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255, 255, 255, 0.95);
    padding: 0.5rem 1rem;
    border-radius: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.search-loading .spinner {
    width: 18px;
    height: 18px;
    border: 2px solid #e2e8f0;
    border-top: 2px solid #667eea;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

.search-loading .text {
    font-size: 0.9rem;
    color: #4a5568;
    font-weight: 500;
    white-space: nowrap;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Search Results */
.search-results {
    display: none;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 1.25rem;
    max-height: 350px;
    overflow-y: auto;
    border: 1px solid rgba(226, 232, 240, 0.8);
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.search-results.active {
    display: block;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.search-results::-webkit-scrollbar {
    width: 6px;
}

.search-results::-webkit-scrollbar-track {
    background: transparent;
}

.search-results::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 3px;
}

.search-results::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a6fd8, #6a4190);
}

/* Search Suggestions */
.search-suggestions {
    padding: 1rem;
}

.suggestion-item {
    padding: 0.75rem 1rem;
    border-radius: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.5rem;
}

.suggestion-item:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateX(5px);
}

.suggestion-item i {
    color: #667eea;
    width: 20px;
}

.suggestion-text {
    color: #4a5568;
    font-weight: 500;
}

/* Additional styles for appointment button and user dropdown */
.clinic-appointment-btn.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.clinic-navbar-icons .dropdown-toggle {
    position: relative;
}

.clinic-navbar-icons .dropdown-toggle::after {
    display: none; /* Hide the default Bootstrap dropdown arrow */
}

.clinic-navbar-icons .dropdown-menu {
    min-width: 220px;
    margin-top: 0.5rem;
    border: none;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border-radius: 0.75rem;
    padding: 0.75rem;
}

.clinic-navbar-icons .dropdown-header {
    color: #667eea;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 0.5rem 0;
}

.clinic-navbar-icons .dropdown-item {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.clinic-navbar-icons .dropdown-item:hover {
    background-color: rgba(102, 126, 234, 0.1);
    color: #667eea;
    transform: translateX(5px);
}

.clinic-navbar-icons .dropdown-item i {
    width: 18px;
    text-align: center;
}

/* User icon button styling */
.clinic-navbar-icons .clinic-icon-btn.dropdown-toggle {
    position: relative;
}

.clinic-navbar-icons .clinic-icon-btn.dropdown-toggle:hover {
    background-color: rgba(102, 126, 234, 0.1);
    color: #667eea;
}

/* Login button styling */
.clinic-navbar-icons .btn-outline-primary.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-color: #667eea;
    color: #667eea;
    font-weight: 500;
}

.clinic-navbar-icons .btn-outline-primary.btn-sm:hover {
    background-color: #667eea;
    border-color: #667eea;
    color: white;
}
</style>

<nav class="navbar navbar-expand-lg navbar-light clinic-navbar py-3">
  <div class="container clinic-navbar-container mx-auto">
    <a class="navbar-brand d-flex flex-column align-items-start justify-content-center py-0" href="/">
      <img src="/assets/images/default-avatar.png" alt="Logo" width="48" height="48" class="mb-1 clinic-logo-img">
      <span class="clinic-logo-text">Qickmed<br><span class="clinic-logo-desc">MEDICAL & HEALTH CARE</span></span>
    </a>
    <button class="navbar-toggler clinic-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav mx-auto gap-4 align-items-center clinic-menu">
        <li class="nav-item"><a class="nav-link clinic-nav-link active" href="#home">Home</a></li>
        <li class="nav-item"><a class="nav-link clinic-nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link clinic-nav-link" href="#services">Services</a></li>
        <!-- Pages Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link clinic-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pages
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/pages/doctors.php">Đội ngũ bác sĩ</a></li>
            <li><a class="dropdown-item" href="/pages/departments.php">Chuyên khoa</a></li>
            <li><a class="dropdown-item" href="/pages/testimonials.php">Đánh giá</a></li>
            <li><a class="dropdown-item" href="/pages/faq.php">FAQ</a></li>
            <li><a class="dropdown-item" href="/pages/contact.php">Liên hệ</a></li>
          </ul>
        </li>
        <!-- Shop Dropdown with Level 3 -->
        <li class="nav-item dropdown">
          <a class="nav-link clinic-nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Shop
          </a>
          <ul class="dropdown-menu">
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#">Thực phẩm chức năng</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/shop/supplements/vitamins.php">Vitamin & Khoáng chất</a></li>
                <li><a class="dropdown-item" href="/shop/supplements/immune.php">Tăng cường miễn dịch</a></li>
                <li><a class="dropdown-item" href="/shop/supplements/beauty.php">Làm đẹp & Chống lão hóa</a></li>
                <li><a class="dropdown-item" href="/shop/supplements/weight.php">Hỗ trợ giảm cân</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#">Thuốc</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/shop/medicine/prescription.php">Thuốc kê đơn</a></li>
                <li><a class="dropdown-item" href="/shop/medicine/otc.php">Thuốc không kê đơn</a></li>
                <li><a class="dropdown-item" href="/shop/medicine/herbal.php">Thuốc thảo dược</a></li>
                <li><a class="dropdown-item" href="/shop/medicine/antibiotics.php">Kháng sinh</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#">Thiết bị y tế</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/shop/devices/diagnostic.php">Thiết bị chẩn đoán</a></li>
                <li><a class="dropdown-item" href="/shop/devices/monitoring.php">Thiết bị theo dõi</a></li>
                <li><a class="dropdown-item" href="/shop/devices/first-aid.php">Dụng cụ sơ cứu</a></li>
                <li><a class="dropdown-item" href="/shop/devices/mobility.php">Thiết bị hỗ trợ</a></li>
              </ul>
            </li>
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#">Dược phẩm</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/shop/pharma/generic.php">Thuốc generic</a></li>
                <li><a class="dropdown-item" href="/shop/pharma/branded.php">Thuốc biệt dược</a></li>
                <li><a class="dropdown-item" href="/shop/pharma/specialty.php">Thuốc đặc trị</a></li>
                <li><a class="dropdown-item" href="/shop/pharma/imported.php">Thuốc nhập khẩu</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link clinic-nav-link" href="#blog">Blog</a></li>
        <li class="nav-item"><a class="nav-link clinic-nav-link" href="#contact">Contact</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2 ms-lg-3 clinic-navbar-icons">
        <a href="#" class="clinic-icon-btn" id="searchToggle"><i class="fa-solid fa-magnifying-glass"></i></a>
        <a href="#" class="clinic-icon-btn"><i class="fa-solid fa-cart-shopping"></i></a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
        <!-- User is logged in - show user dropdown -->
        <div class="dropdown">
          <a href="#" class="clinic-icon-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="userDropdown">
            <i class="fa-solid fa-user"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><h6 class="dropdown-header">Xin chào, <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']) ?>!</h6></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/profile.php"><i class="fa-solid fa-user me-2"></i>Hồ sơ cá nhân</a></li>
            <li><a class="dropdown-item" href="/appointments.php"><i class="fa-solid fa-calendar-check me-2"></i>Lịch hẹn của tôi</a></li>
            <li><a class="dropdown-item" href="/medical-records.php"><i class="fa-solid fa-file-medical me-2"></i>Hồ sơ bệnh án</a></li>
            <?php if ($_SESSION['role_id'] == 1): // Admin ?>
            <li><a class="dropdown-item" href="/admin/dashboard.php"><i class="fa-solid fa-cogs me-2"></i>Quản trị</a></li>
            <?php endif; ?>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout.php"><i class="fa-solid fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
          </ul>
        </div>
        <?php else: ?>
        <!-- User is not logged in - show login button -->
        <a href="/login.php" class="btn btn-outline-primary btn-sm d-flex align-items-center">
          <i class="fa-solid fa-sign-in-alt me-1"></i>Đăng nhập
        </a>
        <?php endif; ?>
        
        <a href="#book" class="btn clinic-appointment-btn btn-sm d-none d-lg-inline-flex align-items-center">Make An Appointment <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i></a>
      </div>
    </div>
  </div>
</nav>

<!-- Search Overlay -->
<div class="search-overlay" id="searchOverlay">
    <div class="search-box">
        <button class="close-search" id="closeSearch">&times;</button>
        
        <div class="search-header">
            <h3 class="search-title">Tìm kiếm</h3>
            <p class="search-subtitle">Nhập từ khóa để tìm kiếm sản phẩm, dịch vụ...</p>
        </div>
        
        <div class="search-input-wrapper">
            <input type="text" placeholder="Nhập từ khóa tìm kiếm..." id="searchInput">
            <i class="fa-solid fa-magnifying-glass search-icon"></i>
            <div class="search-loading" id="searchLoading">
                <div class="spinner"></div>
                <span class="text">Đang tìm kiếm...</span>
            </div>
        </div>
        
        <div class="search-results" id="searchResults">
            <div class="search-suggestions">
                <div class="suggestion-item">
                    <i class="fa-solid fa-pills"></i>
                    <span class="suggestion-text">Thuốc kháng sinh</span>
                </div>
                <div class="suggestion-item">
                    <i class="fa-solid fa-heart-pulse"></i>
                    <span class="suggestion-text">Thiết bị đo huyết áp</span>
                </div>
                <div class="suggestion-item">
                    <i class="fa-solid fa-dna"></i>
                    <span class="suggestion-text">Vitamin tổng hợp</span>
                </div>
                <div class="suggestion-item">
                    <i class="fa-solid fa-user-doctor"></i>
                    <span class="suggestion-text">Bác sĩ tim mạch</span>
                </div>
                <div class="suggestion-item">
                    <i class="fa-solid fa-stethoscope"></i>
                    <span class="suggestion-text">Khám tổng quát</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchToggle = document.getElementById('searchToggle');
    const searchOverlay = document.getElementById('searchOverlay');
    const closeSearch = document.getElementById('closeSearch');
    const searchInput = document.getElementById('searchInput');
    const searchLoading = document.getElementById('searchLoading');
    const searchResults = document.getElementById('searchResults');
    let searchTimeout;

    searchToggle.addEventListener('click', function(e) {
        e.preventDefault();
        searchOverlay.style.display = 'flex';
        setTimeout(() => {
            searchOverlay.classList.add('active');
        }, 10);
        searchInput.focus();
    });

    function closeSearchOverlay() {
        searchOverlay.classList.remove('active');
        setTimeout(() => {
            searchOverlay.style.display = 'none';
            searchInput.value = '';
            searchLoading.classList.remove('active');
            searchResults.classList.remove('active');
        }, 300);
    }

    closeSearch.addEventListener('click', closeSearchOverlay);

    searchOverlay.addEventListener('click', function(e) {
        if (e.target === searchOverlay) {
            closeSearchOverlay();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchOverlay.style.display === 'flex') {
            closeSearchOverlay();
        }
    });

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        
        if (this.value.length > 0) {
            searchLoading.classList.add('active');
            searchResults.classList.add('active');
            
            // Simulate search delay
            searchTimeout = setTimeout(() => {
                searchLoading.classList.remove('active');
                // Here you would typically update search results
            }, 1000);
        } else {
            searchLoading.classList.remove('active');
            searchResults.classList.remove('active');
        }
    });
});
</script>


