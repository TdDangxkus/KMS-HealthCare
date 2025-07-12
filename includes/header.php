<?php
// Bắt đầu output buffering và session trước khi có bất kỳ output nào
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determine current page for active navigation
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
    /* Body padding to prevent content being hidden behind fixed header */
    body {
        padding-top: 140px; /* Adjust based on header height */
    }

    /* Two-Tier Medical Header Styles */
    .medical-header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 999990;
        width: 100%;
        box-shadow: 0 4px 20px rgba(25, 118, 210, 0.1);
        background: white;
        transition: top 0.3s ease-in-out; /*  hiệu ứng scolll */
    }

    /* Enhanced scrolled state */
    .medical-header.scrolled {
        box-shadow: 0 8px 30px rgba(25, 118, 210, 0.2);
    }

    .medical-header.scrolled .top-bar {
        background: linear-gradient(135deg, #1565c0 0%, #1976d2 100%);
    }

    /* Ensure header is always on top */
    .medical-header * {
        position: relative;
        z-index: inherit;
    }

    /* Top Bar */
    .top-bar {
        background: linear-gradient(135deg, #1976d2 0%, #1e88e5 100%);
        color: white;
        padding: 0.6rem 0;
        font-size: 0.85rem;
    }

    .top-bar-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 100%;
        padding: 0 2rem;
        margin: 0;
    }

    .top-bar-left {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .top-bar-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .top-bar-item:hover {
        color: white;
        transform: translateY(-1px);
    }

    .top-bar-item i {
        font-size: 0.9rem;
    }

    .top-bar-right {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .download-app {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.15);
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .download-app:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-1px);
    }

    /* Main Header */
    .main-header {
        background: #ffffff;
        border-bottom: 1px solid #e3f2fd;
        padding: 1rem 0;
    }

    .main-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 100%;
        padding: 0 2rem;
        margin: 0;
    }

    /* Logo Section */
    .logo-section {
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .logo-section:hover {
        transform: translateY(-2px);
    }

    .logo-image {
        width: 55px;
        height: 55px;
        margin-right: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(25, 118, 210, 0.2);
        transition: all 0.3s ease;
    }

    .logo-section:hover .logo-image {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(25, 118, 210, 0.3);
    }

    .logo-text {
        display: flex;
        flex-direction: column;
    }

    .logo-name {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1976d2;
        line-height: 1.1;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .logo-subtitle {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64b5f6;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin: 0;
    }

    /* Search Bar */
    .search-bar {
        flex: 1;
        max-width: 700px;
        margin: 0 2rem;
        position: relative;
    }

    .search-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input {
        width: 100%;
        padding: 0.8rem 3.5rem 0.8rem 1rem;
        border: 2px solid #e3f2fd;
        border-radius: 25px;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.3s ease;
        background: #f8faff;
    }

    .search-input:focus {
        border-color: #1976d2;
        background: white;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
    }

    .search-input::placeholder {
        color: #90a4ae;
    }

    .search-btn {
        position: absolute;
        right: 8px;
        background: #1976d2;
        border: none;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: #1565c0;
        transform: scale(1.05);
    }

    .search-suggestions {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    }

    .suggestion-tag {
        background: #e3f2fd;
        color: #1976d2;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .suggestion-tag:hover {
        background: #1976d2;
        color: white;
        transform: translateY(-1px);
    }

    /* Action Area */
    .action-area {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .action-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f8faff;
        border: 2px solid #e3f2fd;
        color: #1976d2;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        font-size: 1.1rem;
    }

    .action-icon:hover {
        background: #e3f2fd;
        border-color: #bbdefb;
        color: #1565c0;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(25, 118, 210, 0.2);
    }

    /* Cart with Badge */
    .cart-icon {
        position: relative;
    }

    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: linear-gradient(135deg, #f44336, #e53935);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        border: 2px solid white;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* User Account */
    .user-account {
        position: relative;
        z-index: 100000;
    }

    .user-btn {
        position: relative;
        z-index: 999999;
        display: flex;
        align-items: center;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        background: #f8faff;
        border: 2px solid #e3f2fd;
        color: #37474f;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        cursor: pointer;
    }

    .user-btn:hover {
        background: #e3f2fd;
        border-color: #bbdefb;
        color: #1976d2;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(25, 118, 210, 0.15);
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        background: linear-gradient(135deg, #1976d2, #42a5f5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        margin-right: 0.7rem;
        font-size: 0.95rem;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .user-name {
        font-size: 0.95rem;
        font-weight: 600;
        line-height: 1.2;
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .user-role {
        font-size: 0.75rem;
        color: #64b5f6;
        line-height: 1;
    }

    /* Auth Buttons */
    .auth-btn {
        display: flex;
        align-items: center;
        padding: 0.7rem 1.3rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .login-btn {
        background: #f8faff;
        border: 2px solid #1976d2;
        color: #1976d2;
    }

    .login-btn:hover {
        background: #1976d2;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(25, 118, 210, 0.3);
    }

    .appointment-btn {
        background: linear-gradient(135deg, #4caf50, #66bb6a);
        color: white;
        border: 2px solid transparent;
        margin-left: 0.5rem;
    }

    .appointment-btn:hover {
        background: linear-gradient(135deg, #43a047, #5cb85c);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(76, 175, 80, 0.3);
    }

    /* Navigation Bar */
    .nav-bar {
        background: #ffffff;
        border-top: 1px solid #e3f2fd;
        padding: 0.8rem 0;
        position: relative;
        z-index: 9999;
    }

    .nav-content {
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 100%;
        padding: 0 2rem;
        margin: 0;
    }

    .main-nav {
        display: flex;
        align-items: center;
        gap: 3rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-item {
        position: relative;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 0.6rem 1rem;
        font-weight: 500;
        font-size: 0.95rem;
        color: #37474f;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link:hover {
        color: #1976d2;
        background: rgba(25, 118, 210, 0.08);
    }

    .nav-link.active {
        color: #1976d2;
        background: rgba(25, 118, 210, 0.12);
        font-weight: 600;
    }

    .nav-link i {
        margin-right: 0.5rem;
        width: 16px;
        text-align: center;
        font-size: 0.9rem;
    }

    /* Navigation dropdown */
    .dropdown-menu {
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        min-width: 250px;
        padding: 0.5rem;
        margin: 0 !important;
        background: #ffffff;
        border: 1px solid #e3f2fd;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 10px 30px rgba(25, 118, 210, 0.15);
        z-index: 10000 !important;
        display: none;
        animation: dropdownFadeIn 0.2s ease;
        transform: none !important;
    }

    .dropdown-menu.show {
        display: block;
        transform: none !important;
    }

    /* Ghi đè style của Bootstrap dropdown */
    .dropdown-menu[data-bs-popper] {
        transform: none !important;
        top: 100% !important;
        margin-top: 0 !important;
        z-index: 10000 !important;
    }

    /* User account dropdown */
    .user-account .dropdown-menu {
        right: 0 !important;
        left: auto !important;
        top: calc(100% - 2px) !important; /* Dính liền với button */
        border-radius: 0 0 10px 10px;
       
    }

    .dropdown-item {
        position: relative;
        z-index: 100003;
        padding: 0.7rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        color: #37474f;
        transition: background-color 0.2s ease;
        display: flex;
        align-items: center;
        margin-bottom: 0.2rem;
        text-decoration: none;
    }

    .dropdown-item:hover {
        background-color: rgba(25, 118, 210, 0.08);
        color: #1976d2;
    }

    .dropdown-item i {
        width: 18px;
        margin-right: 0.7rem;
        color: #64b5f6;
        font-size: 0.9rem;
        transition: color 0.2s ease;
    }

    .dropdown-item:hover i {
        color: #1976d2;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px); /* Giảm khoảng cách animation */
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* =====================================================
       MOBILE RESPONSIVE DESIGN - CLEAN & MODERN
       ===================================================== */

    @media (max-width: 991.98px) {
        /* Reset body padding for mobile */
        body {
            padding-top: 120px !important;
        }
        
        /* Hide top bar completely on mobile */
        .top-bar {
            display: none !important;
        }
        
        /* Mobile header container */
        .medical-header {
            box-shadow: 0 2px 15px rgba(25, 118, 210, 0.1) !important;
        }
        
        /* Clean mobile header */
        .main-header {
            padding: 1rem 0 !important;
            background: #ffffff !important;
            border-bottom: 1px solid #e3f2fd !important;
        }
        
        .main-header-content {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 0 1rem !important;
            gap: 1rem !important;
            flex-wrap: nowrap !important;
        }
        
        /* Mobile hamburger menu - moved to left */
        .mobile-toggle {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            width: 45px !important;
            height: 45px !important;
            background: #f8faff !important;
            border: 2px solid #e3f2fd !important;
            border-radius: 12px !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            gap: 3px !important;
            order: 1 !important; /* Place menu button first (left) */
        }
        
        .mobile-toggle:hover {
            background: #e3f2fd !important;
        }
        
        .mobile-toggle.active {
            background: #1976d2 !important;
            border-color: #1976d2 !important;
        }
        
        .toggle-line {
            width: 20px !important;
            height: 2px !important;
            background: #1976d2 !important;
            border-radius: 1px !important;
            transition: all 0.3s ease !important;
        }
        
        .mobile-toggle.active .toggle-line {
            background: white !important;
        }
        
        .mobile-toggle.active .toggle-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px) !important;
        }
        
        .mobile-toggle.active .toggle-line:nth-child(2) {
            opacity: 0 !important;
        }
        
        .mobile-toggle.active .toggle-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px) !important;
        }
        
        /* Logo section - centered on mobile */
        .logo-section {
            flex: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            order: 2 !important; /* Place logo in center */
        }
        
        .logo-image {
            width: 45px !important;
            height: 45px !important;
            margin-right: 12px !important;
        }
        
        .logo-name {
            font-size: 1.4rem !important;
        }
        
        .logo-subtitle {
            font-size: 0.7rem !important;
        }
        
        /* Desktop search bar - hide on mobile */
        .search-bar {
            display: none !important;
        }
        
        /* Mobile search bar */
        .mobile-search-overlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            background: rgba(0, 0, 0, 0.5) !important;
            z-index: 999999 !important;
            display: none !important;
            opacity: 0 !important;
            transition: opacity 0.3s ease !important;
        }
        
        .mobile-search-overlay.active {
            display: flex !important;
            opacity: 1 !important;
            align-items: flex-start !important;
            justify-content: center !important;
            padding-top: 120px !important;
        }
        
        .mobile-search-container {
            background: white !important;
            margin: 0 1rem !important;
            border-radius: 15px !important;
            padding: 1.5rem !important;
            width: 100% !important;
            max-width: 700px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
            transform: translateY(-20px) !important;
            transition: transform 0.3s ease !important;
        }
        
        .mobile-search-overlay.active .mobile-search-container {
            transform: translateY(0) !important;
        }
        
        .mobile-search-form {
            display: flex !important;
            gap: 0.5rem !important;
        }
        
        .mobile-search-input {
            flex: 1 !important;
            padding: 0.875rem 1rem !important;
            border: 2px solid #e3f2fd !important;
            border-radius: 12px !important;
            font-size: 1rem !important;
            outline: none !important;
        }
        
        .mobile-search-input:focus {
            border-color: #1976d2 !important;
        }
        
        .mobile-search-btn {
            padding: 0.875rem 1.5rem !important;
            background: #1976d2 !important;
            color: white !important;
            border: none !important;
            border-radius: 12px !important;
            cursor: pointer !important;
        }
        
        .mobile-search-close {
            position: absolute !important;
            top: 1rem !important;
            right: 1rem !important;
            background: #f5f5f5 !important;
            border: none !important;
            width: 35px !important;
            height: 35px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
        }
        
        /* Mobile action area - placed on right */
        .action-area {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            flex-shrink: 0 !important;
            order: 3 !important; /* Place actions last (right) */
        }
        
        /* Search toggle button */
        .search-toggle-btn {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 45px !important;
            height: 45px !important;
            border: 2px solid #e3f2fd !important;
            border-radius: 12px !important;
            background: #f8faff !important;
            color: #1976d2 !important;
            font-size: 1.2rem !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
        }
        
        .search-toggle-btn:hover,
        .search-toggle-btn.active {
            background: #1976d2 !important;
            border-color: #1976d2 !important;
            color: white !important;
        }
        
        /* Mobile buttons - enhanced visibility */
        .action-icon,
        .custom-dropdown-btn,
        .auth-btn {
            width: 45px !important;
            height: 45px !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            transition: all 0.3s ease !important;
        }
        
        .action-icon {
            background: #f8faff !important;
            border: 2px solid #e3f2fd !important;
            color: #1976d2 !important;
            font-size: 1.2rem !important;
        }
        
        .action-icon:hover {
            background: #e3f2fd !important;
            border-color: #bbdefb !important;
        }
        
        /* Enhanced icon visibility */
        .action-icon i,
        .search-toggle-btn i,
        .mobile-toggle i,
        .nav-link i,
        .dropdown-item i {
            font-size: 1.2rem !important;
            font-weight: 900 !important;
            display: inline-block !important;
            visibility: visible !important;
            opacity: 1 !important;
            line-height: 1 !important;
        }
        
        /* Cart count on mobile */
        .cart-count {
            position: absolute !important;
            top: -5px !important;
            right: -5px !important;
            background: #f44336 !important;
            color: white !important;
            font-size: 0.7rem !important;
            font-weight: 700 !important;
            width: 18px !important;
            height: 18px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: 2px solid white !important;
        }
        
        /* User account button mobile */
        .custom-dropdown-btn {
            padding: 0.25rem !important;
            width: auto !important;
            min-width: 45px !important;
            background: #f8faff !important;
            border: 2px solid #e3f2fd !important;
        }
        
        .custom-dropdown-btn:hover {
            background: #e3f2fd !important;
        }
        
        /* Hide user info text on mobile */
        .user-info {
            display: none !important;
        }
        
        /* Mobile user avatar */
        .user-avatar {
            width: 32px !important;
            height: 32px !important;
            border-radius: 8px !important;
            margin: 0 !important;
            font-size: 0.9rem !important;
        }
        
        /* Login button mobile */
        .auth-btn {
            background: #f8faff !important;
            border: 2px solid #1976d2 !important;
            color: #1976d2 !important;
            padding: 0 !important;
            font-size: 1.1rem !important;
            width: 45px !important;
            height: 45px !important;
            border-radius: 12px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .auth-btn:hover {
            background: #1976d2 !important;
            color: white !important;
        }
        
        .auth-btn i {
            font-size: 1.2rem !important;
            font-weight: 900 !important;
        }
        
        /* Hide appointment button on mobile */
        .appointment-btn {
            display: none !important;
        }
        
        /* Mobile hamburger menu - styles already defined above */
        
        /* Mobile navigation */
        .nav-bar {
            display: none !important;
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            right: 0 !important;
            background: white !important;
            border-top: 1px solid #e3f2fd !important;
            box-shadow: 0 5px 15px rgba(25, 118, 210, 0.1) !important;
            z-index: 9998 !important;
        }
        
        .nav-bar.show {
            display: block !important;
            animation: slideDown 0.3s ease !important;
        }
        
        .main-nav {
            flex-direction: column !important;
            gap: 0 !important;
            padding: 1rem !important;
        }
        
        .nav-item {
            width: 100% !important;
        }
        
        .nav-link {
            display: flex !important;
            align-items: center !important;
            padding: 1rem !important;
            color: #37474f !important;
            text-decoration: none !important;
            border-radius: 8px !important;
            margin-bottom: 0.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }
        
        .nav-link:hover,
        .nav-link.active {
            background: #e3f2fd !important;
            color: #1976d2 !important;
        }
        
        .nav-link i {
            margin-right: 0.75rem !important;
            width: 20px !important;
            text-align: center !important;
            font-size: 1.1rem !important;
            font-weight: 900 !important;
        }
        
        /* Mobile dropdown menus - only for mobile */
        .dropdown-menu {
            position: static !important;
            background: #f8faff !important;
            border: none !important;
            box-shadow: none !important;
            margin: 0.25rem 0 0 2rem !important;
            padding: 0.5rem !important;
            border-radius: 6px !important;
            display: block !important;
        }
        
        .dropdown-item {
            padding: 0.5rem 0.75rem !important;
            color: #64b5f6 !important;
            border-radius: 4px !important;
            font-size: 0.9rem !important;
        }
        
        .dropdown-item:hover {
            background: #e3f2fd !important;
            color: #1976d2 !important;
        }
        
        .dropdown-item i {
            font-size: 0.9rem !important;
            font-weight: 900 !important;
            margin-right: 0.5rem !important;
        }
    }

    /* Tablet specific optimizations */
    @media (max-width: 768px) {
        body {
            padding-top: 115px !important;
        }
        
        .main-header {
            padding: 0.875rem 0 !important;
        }
        
        .main-header-content {
            padding: 0 0.875rem !important;
            gap: 0.875rem !important;
        }
        
        .logo-image {
            width: 42px !important;
            height: 42px !important;
            margin-right: 10px !important;
        }
        
        .logo-name {
            font-size: 1.3rem !important;
        }
        
        .logo-subtitle {
            font-size: 0.65rem !important;
        }
        
        .action-area {
            gap: 0.5rem !important;
        }
        
        .action-icon,
        .custom-dropdown-btn,
        .auth-btn,
        .mobile-toggle,
        .search-toggle-btn {
            width: 42px !important;
            height: 42px !important;
            font-size: 1rem !important;
        }
        
        .user-avatar {
            width: 30px !important;
            height: 30px !important;
            font-size: 0.8rem !important;
        }
        
        .cart-count {
            width: 18px !important;
            height: 18px !important;
            font-size: 0.7rem !important;
            top: -5px !important;
            right: -5px !important;
        }
        
        /* Mobile search overlay for tablets */
        .mobile-search-overlay.active {
            padding-top: 115px !important;
        }
    }

    /* Small phone optimizations */
    @media (max-width: 576px) {
        body {
            padding-top: 110px !important;
        }
        
        .main-header {
            padding: 0.75rem 0 !important;
        }
        
        .main-header-content {
            padding: 0 0.75rem !important;
            gap: 0.75rem !important;
        }
        
        .logo-image {
            width: 38px !important;
            height: 38px !important;
            margin-right: 8px !important;
        }
        
        .logo-name {
            font-size: 1.2rem !important;
        }
        
        .logo-subtitle {
            font-size: 0.6rem !important;
        }
        
        .action-area {
            gap: 0.425rem !important;
        }
        
        .action-icon,
        .custom-dropdown-btn,
        .auth-btn,
        .mobile-toggle,
        .search-toggle-btn {
            width: 40px !important;
            height: 40px !important;
            font-size: 0.9rem !important;
            border-radius: 10px !important;
        }
        
        .user-avatar {
            width: 28px !important;
            height: 28px !important;
            font-size: 0.75rem !important;
        }
        
        .cart-count {
            width: 16px !important;
            height: 16px !important;
            font-size: 0.65rem !important;
            top: -4px !important;
            right: -4px !important;
        }
        
        .toggle-line {
            width: 16px !important;
        }
        
        .main-nav {
            padding: 1.25rem 0.75rem 1.75rem !important;
        }
        
        .nav-link {
            padding: 0.875rem 1rem !important;
            font-size: 0.9rem !important;
        }
        
        /* Mobile search overlay for small phones */
        .mobile-search-overlay.active {
            padding-top: 110px !important;
        }
        
        .mobile-search-container {
            margin: 0 0.75rem !important;
            padding: 1.25rem !important;
        }
        
        .mobile-search-input {
            padding: 0.75rem 1rem !important;
            font-size: 0.95rem !important;
        }
        
        .mobile-search-btn {
            padding: 0.75rem 1.25rem !important;
        }
    }

    /* Animations */
    .medical-header {
        animation: slideDown 0.6s ease;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Smooth scrolling */
    * {
        scroll-behavior: smooth;
    }

    /* Custom Dropdown Styles */
    .custom-dropdown {
        position: relative;
        display: inline-block;
    }

    .custom-dropdown-btn {
        display: flex;
        align-items: center;
        padding: 8px 16px;
        background: #f8faff;
        border: 2px solid #e3f2fd;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-dropdown-btn:hover {
        background: #e3f2fd;
        border-color: #bbdefb;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        background: linear-gradient(135deg, #1976d2, #42a5f5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        margin-right: 12px;
    }

    .user-info {
        text-align: left;
    }

    .user-name {
        font-weight: 600;
        color: #37474f;
        margin-bottom: 2px;
        font-size: 0.95rem;
    }

    .user-role {
        color: #64b5f6;
        font-size: 0.75rem;
    }

    .custom-dropdown-menu {
        position: absolute !important;
        top: calc(100% + 12px) !important;
        right: 0 !important;
        width: 280px;
        background: #ffffff !important;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.15), 0 4px 16px rgba(0, 0, 0, 0.08) !important;
        border: 1px solid rgba(102, 126, 234, 0.1);
        padding: 12px;
        display: none !important;
        z-index: 100001 !important;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-15px) scale(0.95);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .custom-dropdown-menu::before {
        content: '';
        position: absolute;
        top: -8px;
        right: 20px;
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-bottom: 8px solid #ffffff;
        filter: drop-shadow(0 -2px 4px rgba(102, 126, 234, 0.1));
    }

    .custom-dropdown-menu.active {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) scale(1) !important;
    }

    .menu-item {
        margin: 2px 0;
        position: relative;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .menu-item a {
        display: flex !important;
        align-items: center;
        padding: 14px 18px;
        color: #2c3e50 !important;
        text-decoration: none !important;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 100%;
        box-sizing: border-box;
        font-weight: 500;
        font-size: 14px;
        position: relative;
        overflow: hidden;
    }

    .menu-item a:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white !important;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .menu-item a:hover i {
        color: white !important;
        transform: scale(1.1);
    }

    .menu-item i {
        width: 20px;
        margin-right: 14px;
        color: #667eea;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .menu-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.2), transparent);
        margin: 12px 16px;
        border: none;
    }

    .menu-item.logout a {
        color: #e74c3c !important;
    }

    .menu-item.logout a:hover {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%) !important;
        color: white !important;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }

    .menu-item.logout i {
        color: #e74c3c !important;
    }

    .menu-item.logout a:hover i {
        color: white !important;
    }

    @keyframes menuFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Force visibility for all menu items including admin menu */
    .custom-dropdown-menu .menu-item,
    .custom-dropdown-menu .menu-item a,
    .custom-dropdown-menu .menu-item span,
    .custom-dropdown-menu .menu-item i {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        color: #37474f !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }
    
    .custom-dropdown-menu .menu-item a {
        padding: 0.75rem 1rem !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.75rem !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    
    .custom-dropdown-menu .menu-item a:hover {
        background: rgba(25, 118, 210, 0.08) !important;
        color: #1976d2 !important;
    }
    
    .custom-dropdown-menu .menu-item i {
        width: 18px !important;
        text-align: center !important;
        color: #64b5f6 !important;
        flex-shrink: 0 !important;
    }
    
    .custom-dropdown-menu .menu-item a:hover i {
        color: #1976d2 !important;
    }
    
    .custom-dropdown-menu .menu-divider {
        height: 1px !important;
        background: #e3f2fd !important;
        margin: 0.5rem 0 !important;
    }
    
    /* Admin menu specific styling */
    .custom-dropdown-menu .menu-item:has([href*="admin"]),
    .custom-dropdown-menu .admin-menu-item {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        background: rgba(25, 118, 210, 0.02) !important;
        border-left: 3px solid #1976d2 !important;
        margin: 0.25rem 0 !important;
    }
    
    .custom-dropdown-menu .menu-item:has([href*="admin"]) a,
    .custom-dropdown-menu .admin-menu-item a {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        font-weight: 600 !important;
    }
    
    /* Force show admin menu items with highest specificity */
    .custom-dropdown-menu .admin-menu-item {
        display: block !important;
    }
    
    .custom-dropdown-menu .admin-menu-item a {
        display: flex !important;
    }
    
    .custom-dropdown-menu .admin-menu-item i,
    .custom-dropdown-menu .admin-menu-item span {
        display: inline !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    /* Override any conflicting styles */
    .custom-dropdown {
        position: static !important;
        z-index: 999999 !important;
    }

    .custom-dropdown .custom-dropdown-menu {
        position: absolute !important;
        z-index: 999999 !important;
        top: calc(100% + 8px) !important;
        right: 0 !important;
        pointer-events: auto !important;
    }

    .custom-dropdown .custom-dropdown-menu.active {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
        animation: userMenuFadeIn 0.3s ease-out !important;
    }
    
    @keyframes userMenuFadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    /* User menu backdrop */
    .user-menu-backdrop {
        animation: backdropFadeIn 0.3s ease-out;
    }
    
    @keyframes backdropFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .custom-dropdown-menu {
            position: fixed !important;
            top: auto !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            border-radius: 20px 20px 0 0 !important;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.1) !important;
            padding: 1rem !important;
            background: white !important;
            z-index: 999999 !important;
            max-height: 60vh !important;
            overflow-y: auto !important;
        }

        .custom-dropdown-menu .menu-item a {
            padding: 1rem !important;
            font-size: 1rem !important;
            border-radius: 12px !important;
            margin-bottom: 0.5rem !important;
        }
        
        .custom-dropdown-menu .menu-item i {
            font-size: 1.1rem !important;
            width: 20px !important;
        }
        
        /* Better mobile admin menu styling */
        .custom-dropdown-menu .menu-item:has([href*="admin"]),
        .custom-dropdown-menu .admin-menu-item {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            background: rgba(25, 118, 210, 0.05) !important;
            border-left: 4px solid #1976d2 !important;
            border-radius: 8px !important;
        }
        
        .custom-dropdown-menu .admin-menu-item a {
            display: flex !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        .custom-dropdown-menu .admin-menu-item i,
        .custom-dropdown-menu .admin-menu-item span {
            display: inline !important;
            visibility: visible !important;
            opacity: 1 !important;
        }
        
        /* Force hide ALL navigation dropdowns on mobile */
        .nav-bar .dropdown-menu,
        .dropdown-menu {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
            height: 0 !important;
            overflow: hidden !important;
        }
        
        .nav-bar .dropdown-menu.show,
        .dropdown-menu.show {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
        }
        
        /* Disable dropdown toggle functionality on mobile */
        .nav-bar .dropdown-toggle::after {
            display: none !important;
        }
        
        .nav-bar .dropdown-toggle {
            cursor: default !important;
        }
        
        .nav-bar .dropdown-toggle:hover {
            color: inherit !important;
        }
    }

    /* Mobile Toggle Button */
    .mobile-toggle {
        display: none;
        background: transparent;
        border: none;
        padding: 10px;
        cursor: pointer;
        position: relative;
        z-index: 2000;
        width: 45px;
        height: 45px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .mobile-toggle:hover {
        background: rgba(25, 118, 210, 0.08);
    }

    .mobile-toggle .toggle-line {
        width: 24px;
        height: 2px;
        background: #1976d2;
        display: block;
        margin: 5px auto;
        position: relative;
        transition: all 0.3s ease-in-out;
        border-radius: 2px;
    }

    .mobile-toggle.active {
        background: rgba(25, 118, 210, 0.12);
    }

    .mobile-toggle.active .toggle-line:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .mobile-toggle.active .toggle-line:nth-child(2) {
        opacity: 0;
        transform: translateX(-10px);
    }

    .mobile-toggle.active .toggle-line:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }

    /* Desktop styles - hide mobile elements */
    @media (min-width: 992px) {
        /* Hide search toggle button on desktop */
        .search-toggle-btn {
            display: none !important;
        }
        
        /* Show desktop search bar */
        .search-bar {
            display: flex !important;
        }
        
        /* Hide mobile toggle on desktop */
        .mobile-toggle {
            display: none !important;
        }
        
        /* Hide mobile search overlay on desktop */
        .mobile-search-overlay {
            display: none !important;
        }
        
        /* Ensure desktop dropdown functionality works */
        .dropdown-menu {
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            z-index: 10000 !important;
            display: none !important;
            min-width: 250px !important;
            padding: 0.5rem !important;
            margin: 0 !important;
            background: #ffffff !important;
            border: 1px solid #e3f2fd !important;
            border-radius: 0 0 10px 10px !important;
            box-shadow: 0 10px 30px rgba(25, 118, 210, 0.15) !important;
            animation: dropdownFadeIn 0.2s ease !important;
        }
        
        .dropdown-menu.show {
            display: block !important;
        }
        
        /* Desktop dropdown items */
        .dropdown-item {
            padding: 0.7rem 1rem !important;
            color: #37474f !important;
            font-size: 0.95rem !important;
            font-weight: 500 !important;
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
            border-radius: 6px !important;
            margin-bottom: 0.2rem !important;
            transition: all 0.2s ease !important;
        }
        
        .dropdown-item:hover {
            background: rgba(25, 118, 210, 0.08) !important;
            color: #1976d2 !important;
        }
        
        .dropdown-item i {
            width: 18px !important;
            margin-right: 0.7rem !important;
            color: #64b5f6 !important;
            font-size: 0.9rem !important;
        }
        
        .dropdown-item:hover i {
            color: #1976d2 !important;
        }
        
        /* Reset mobile navigation styles for desktop */
        .nav-bar {
            display: block !important;
            position: relative !important;
            background: #ffffff !important;
            border-top: 1px solid #e3f2fd !important;
            padding: 0.8rem 0 !important;
            box-shadow: none !important;
        }
        
        .main-nav {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 3rem !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
            flex-direction: row !important;
        }
        
        .nav-item {
            position: relative !important;
            width: auto !important;
        }
        
        .nav-link {
            display: flex !important;
            align-items: center !important;
            padding: 0.6rem 1rem !important;
            font-weight: 500 !important;
            font-size: 0.95rem !important;
            color: #37474f !important;
            text-decoration: none !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin-bottom: 0 !important;
        }
        
        .nav-link:hover {
            color: #1976d2 !important;
            background: rgba(25, 118, 210, 0.08) !important;
        }
        
        .nav-link.active {
            color: #1976d2 !important;
            background: rgba(25, 118, 210, 0.12) !important;
            font-weight: 600 !important;
        }
        
        .nav-link i {
            margin-right: 0.5rem !important;
            width: 16px !important;
            text-align: center !important;
            font-size: 0.9rem !important;
        }
    }

    /* Font Awesome fallback and icon fixes */
    .fas, .far, .fab {
        font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 5 Free", "Font Awesome 5 Pro", FontAwesome !important;
        font-weight: 900 !important;
        -webkit-font-smoothing: antialiased;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }

    .far {
        font-weight: 400 !important;
    }

    /* Ensure icons are visible */
    .action-icon i,
    .search-btn i,
    .search-toggle-btn i,
    .mobile-search-btn i,
    .mobile-search-close i,
    .mobile-toggle i,
    .nav-link i,
    .dropdown-item i,
    .menu-item i,
    .user-btn i,
    .auth-btn i {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        font-size: inherit !important;
        width: auto !important;
        height: auto !important;
        line-height: 1 !important;
    }

    /* Fix z-index issues */
    .medical-header {
        z-index: 999999 !important;
    }

    .mobile-search-overlay {
        z-index: 999998 !important;
    }

    .custom-dropdown-menu {
        z-index: 999997 !important;
    }

    .nav-bar {
        z-index: 999996 !important;
    }
    </style>
</head>
<body>
    <!-- Two-Tier Medical Header -->
    <header class="medical-header">
        <!-- Top Bar -->
        <!-- <div class="top-bar">
            <div class="container-fluid top-bar-content">
                <div class="top-bar-left">
                    <a href="#" class="top-bar-item">
                        <i class="fas fa-search"></i>
                        <span>Tra thuốc chính hãng</span>
                        <strong>Kiểm tra ngay</strong>
                    </a>
                    <a href="tel:18006928" class="top-bar-item">
                        <i class="fas fa-phone"></i>
                        <span>Tư vấn ngay: Dalziel Đẹp Trai</span>
                    </a>
                </div>
                <div class="top-bar-right">
                    <a href="#" class="download-app">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Tải ứng dụng</span>
                    </a>
                </div>
            </div>
        </div> -->

        <!-- Main Header -->
        <div class="main-header">
            <div class="container-fluid main-header-content">
                <!-- Logo Section -->
                <a href="/index.php" class="logo-section">
                    <img src="/assets/images/default-avatar.png" alt="Qickmed" class="logo-image">
                    <div class="logo-text">
                        <h1 class="logo-name">MediSync</h1>
                        <p class="logo-subtitle">Medical & Healthcare</p>
                </div>
                </a>

                <!-- Search Bar -->
                <div class="search-bar">
                    <form action="/search.php" method="GET" class="search-input-group">
                        <input type="text" name="q" class="search-input" placeholder="Tìm thuốc, thực phẩm chức năng, thiết bị y tế..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    <!-- <div class="search-suggestions">
                        <span class="suggestion-tag">Omega 3</span>
                        <span class="suggestion-tag">Canxi</span>
                        <span class="suggestion-tag">Vitamin</span>
                        <span class="suggestion-tag">Máy đo huyết áp</span>
                    </div> -->
                </div>

                <!-- Mobile Search Overlay -->
                <div class="mobile-search-overlay" id="mobileSearchOverlay">
                    <div class="mobile-search-container">
                        <button class="mobile-search-close" onclick="closeMobileSearch()">
                            <i class="fas fa-times"></i>
                        </button>
                        <form action="/search.php" method="GET" class="mobile-search-form">
                            <input type="text" name="q" class="mobile-search-input" placeholder="Tìm kiếm sản phẩm..." autocomplete="off" id="mobileSearchInput">
                            <button type="submit" class="mobile-search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Toggle -->
                <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
                    <span class="toggle-line"></span>
                    <span class="toggle-line"></span>
                    <span class="toggle-line"></span>
                </button>

                <!-- Action Area -->
                <div class="action-area">
                    <!-- Search Toggle for Mobile -->
                    <button class="search-toggle-btn" title="Tìm kiếm" onclick="toggleMobileSearch()">
                        <i class="fas fa-search"></i>
                    </button>
                    
                    <!-- Cart -->
                    <a href="/cart.php" class="action-icon cart-icon" title="Giỏ hàng">
                        <i class="fas fa-shopping-cart"></i>
                        <?php
                        $cart_count = 0;
                        if (isset($_SESSION['user_id'])) {
                            $cart_sql = "
                                SELECT SUM(oi.quantity) as total_quantity
                                FROM order_items oi
                                JOIN orders o ON oi.order_id = o.order_id
                                WHERE o.user_id = ? AND o.status = 'cart'
                            ";
                            $cart_stmt = $conn->prepare($cart_sql);
                            $cart_stmt->bind_param('i', $_SESSION['user_id']);
                            $cart_stmt->execute();
                            $cart_result = $cart_stmt->get_result()->fetch_assoc();
                            $cart_count = $cart_result['total_quantity'] ?? 0;
                        }
                        ?>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    </a>

                    <!-- User Account -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="custom-dropdown">
                        <button class="custom-dropdown-btn" onclick="toggleUserMenu(event)">
                            <div class="user-avatar">
                                <?= strtoupper(substr($_SESSION['full_name'] ?? $_SESSION['username'], 0, 1)) ?>
                            </div>
                            <div class="user-info d-none d-md-block">
                                <div class="user-name">
                                    <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username']) ?>
                                </div>
                                <div class="user-role">
                                    <?php 
                                    $role_names = ["admin" => 'Quản trị viên', "patient" => 'Bệnh nhân', "doctor" => 'Bác sĩ'];
                                    echo $role_names[$_SESSION['role_name']] ?? 'Người dùng';
                                    ?>
                                </div>
                            </div>
                        </button>
                        <div class="custom-dropdown-menu" id="userMenu">
                            <div class="menu-item">
                                <a href="/profile.php">
                                    <i class="fas fa-user"></i>
                                    <span>Hồ sơ cá nhân</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a href="/appointments.php">
                                    <i class="fas fa-calendar-check"></i>
                                    <span>Lịch hẹn</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a href="/medical-records.php">
                                    <i class="fas fa-file-medical"></i>
                                    <span>Hồ sơ bệnh án</span>
                                </a>
                            </div>
                            <div class="menu-item">
                                <a href="/orders.php">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span>Đơn hàng</span>
                                </a>
                            </div>
                            
                            <?php 
                            // Check multiple conditions for admin access
                            $is_admin = false;
                            $debug_info = '';
                            
                            if (isset($_SESSION['role_name'])) {
                                $debug_info = "Role: " . $_SESSION['role_name'];
                                if ($_SESSION['role_name'] === 'admin' || $_SESSION['role_name'] === 'Admin') {
                                    $is_admin = true;
                                }
                            } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                $is_admin = true;
                                $debug_info = "Role (alt): " . $_SESSION['role'];
                            } elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                                $is_admin = true;
                                $debug_info = "User Role: " . $_SESSION['user_role'];
                            } else {
                                $debug_info = "No admin role found";
                            }
                            
                            if ($is_admin): ?>
                            <div class="menu-divider"></div>
                            <div class="menu-item admin-menu-item" style="display: block !important; visibility: visible !important;">
                                <a href="/admin/dashboard.php" style="display: flex !important; visibility: visible !important;">
                                    <i class="fas fa-cogs" style="display: inline !important;"></i>
                                    <span style="display: inline !important;">Quản trị</span>
                                </a>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Temporary debug info (remove after testing) -->
                            <?php if (isset($_GET['debug']) && $_GET['debug'] == '1'): ?>
                            <div class="menu-item" style="color: #666; font-size: 11px; padding: 5px; background: #f5f5f5;">
                                Debug: <?php echo htmlspecialchars($debug_info); ?>
                                <br>All session keys: <?php echo implode(', ', array_keys($_SESSION ?? [])); ?>
                            </div>
                            <?php endif; ?>
                            <div class="menu-divider"></div>
                            <div class="menu-item logout">
                                <a href="#" onclick="showLogoutModal(); return false;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Đăng xuất</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <a href="/login.php" class="auth-btn login-btn">
                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                    </a>
                    <?php endif; ?>
                    
                    <!-- Appointment Button -->
                    <button type="button" class="auth-btn appointment-btn d-none d-lg-flex" onclick="openAppointmentModal()">
                        <i class="fas fa-calendar-plus me-2"></i>Đặt lịch khám
                    </button>
          </div>
            </div>
        </div>

        <!-- Navigation Bar -->
        <div class="nav-bar" id="navBar">
            <div class="container-fluid nav-content">
                <nav class="main-nav">
                    <div class="nav-item">
                        <a href="/index.php" class="nav-link <?= ($current_page == 'index') ? 'active' : '' ?>">
                            <i class="fas fa-home"></i>Trang chủ
                        </a>
                    </div>
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?= ($current_page == 'services') ? 'active' : '' ?>" data-bs-toggle="dropdown">
                            <i class="fas fa-stethoscope"></i>Dịch vụ khám
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/services.php"><i class="fas fa-list"></i>Tất cả dịch vụ</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/services/cardiology.php"><i class="fas fa-heartbeat"></i>Tim mạch</a></li>
                            <li><a class="dropdown-item" href="/services/orthopedics.php"><i class="fas fa-bone"></i>Chỉnh hình</a></li>
                            <li><a class="dropdown-item" href="/services/gynecology.php"><i class="fas fa-person-pregnant"></i>Sản phụ khoa</a></li>
                            <li><a class="dropdown-item" href="/services/pediatrics.php"><i class="fas fa-baby"></i>Nhi khoa</a></li>
                        </ul>
            </div>
            
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?= ($current_page == 'doctors') ? 'active' : '' ?>" data-bs-toggle="dropdown">
                            <i class="fas fa-user-md"></i>Đội ngũ bác sĩ
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/doctors.php"><i class="fas fa-users"></i>Tất cả bác sĩ</a></li>
                            <li><a class="dropdown-item" href="/appointments.php"><i class="fas fa-calendar-plus"></i>Đặt lịch khám</a></li>
                        </ul>
                </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle <?= ($current_page == 'shop') ? 'active' : '' ?>" data-bs-toggle="dropdown">
                            <i class="fas fa-store"></i>Cửa hàng
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/shop.php"><i class="fas fa-pills"></i>Tất cả sản phẩm</a></li>
                            <li><a class="dropdown-item" href="/shop.php?cat=medicine"><i class="fas fa-capsules"></i>Thuốc</a></li>
                            <li><a class="dropdown-item" href="/shop.php?cat=supplements"><i class="fas fa-leaf"></i>Thực phẩm chức năng</a></li>
                            <li><a class="dropdown-item" href="/shop.php?cat=devices"><i class="fas fa-heartbeat"></i>Thiết bị y tế</a></li>
                            <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item" href="/orders.php"><i class="fas fa-shopping-bag"></i>Đơn hàng của tôi</a></li>
                        </ul>
            </div>
            
                    <div class="nav-item">
                        <a href="/about.php" class="nav-link <?= ($current_page == 'about') ? 'active' : '' ?>">
                            <i class="fas fa-info-circle"></i>Giới thiệu
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="/blog.php" class="nav-link <?= ($current_page == 'blog') ? 'active' : '' ?>">
                            <i class="fas fa-newspaper"></i>Tin tức
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="/contact.php" class="nav-link <?= ($current_page == 'contact') ? 'active' : '' ?>">
                            <i class="fas fa-phone"></i>Liên hệ
                        </a>
                    </div>
                </nav>
                    </div>
                    </div>
    </header>

    <?php if (isset($_SESSION['user_id'])): ?>
        <?php include __DIR__ . '/logout_modal.php'; ?>
        <script src="/assets/js/logout.js"></script>
    <?php endif; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add header class to body for styling reference
        document.body.classList.add('has-fixed-header');
        
        // Mobile menu and search state
        const mobileToggle = document.getElementById('mobileToggle');
        const navBar = document.getElementById('navBar');
        const searchToggleBtn = document.querySelector('.search-toggle-btn');
        const searchBar = document.querySelector('.search-bar');
        let isMenuOpen = false;
        let isSearchOpen = false;
        
        // Mobile menu toggle
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function() {
                isMenuOpen = !isMenuOpen;
                navBar.classList.toggle('show');
                this.classList.toggle('active');
                
                // Close search if open
                if (isSearchOpen && searchBar && searchToggleBtn) {
                    isSearchOpen = false;
                    searchBar.classList.remove('mobile-active');
                    searchToggleBtn.classList.remove('active');
                }
            });
        }
        
        // Mobile search toggle
        if (searchToggleBtn) {
            searchToggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close menu if open
                if (isMenuOpen && navBar && mobileToggle) {
                    isMenuOpen = false;
                    navBar.classList.remove('show');
                    mobileToggle.classList.remove('active');
                }
                
                // Open mobile search overlay
                toggleMobileSearch();
            });
        }

        // Search functionality
        const searchForm = document.querySelector('.search-bar form');
        const searchInput = document.querySelector('.search-input');
        
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                const query = searchInput.value.trim();
                if (!query) {
                    e.preventDefault();
                    searchInput.focus();
                }
            });
        }

        // Suggestion tags
        document.querySelectorAll('.suggestion-tag').forEach(tag => {
            tag.addEventListener('click', function() {
                const query = this.textContent.trim();
                searchInput.value = query;
                searchForm.submit();
            });
        });

        // Initialize dropdown functionality
        function initializeDropdowns() {
            // Always remove ALL dropdown event listeners first
            document.querySelectorAll('.dropdown-toggle').forEach(function(dropdownToggle) {
                dropdownToggle.removeEventListener('click', handleDropdownClick);
            });
            document.removeEventListener('click', handleDropdownOutsideClick);
            
            // Force close all dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
            
            if (window.innerWidth >= 992) {
                // Enable Bootstrap dropdowns ONLY on desktop
                document.querySelectorAll('.dropdown-toggle').forEach(function(dropdownToggle) {
                    dropdownToggle.addEventListener('click', handleDropdownClick);
                });
                
                // Add global click listener for closing dropdowns
                document.addEventListener('click', handleDropdownOutsideClick);
                
                console.log('Desktop dropdowns initialized');
            } else {
                console.log('Mobile mode - dropdowns disabled');
            }
        }
        
        // Handle dropdown toggle clicks
        function handleDropdownClick(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const dropdownMenu = this.nextElementSibling;
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                if (menu !== dropdownMenu) {
                    menu.classList.remove('show');
                }
            });
            
            // Toggle current dropdown
            dropdownMenu.classList.toggle('show');
        }
        
        // Handle clicks outside dropdowns
        function handleDropdownOutsideClick(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            }
        }
        
        // Initialize dropdowns on page load
        initializeDropdowns();
        
        // Force close all dropdowns on initial load (prevent auto-opening)
        setTimeout(function() {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
                menu.style.display = 'none';
            });
            document.querySelectorAll('.custom-dropdown-menu').forEach(function(menu) {
                menu.classList.remove('active');
            });
            console.log('All dropdowns force closed on page load');
        }, 100);
        
        // Additional safety check after full page load
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    menu.classList.remove('show');
                    menu.style.display = 'none';
                });
                console.log('All dropdowns force closed after page load');
            }, 200);
        });
        
        // Close menus when clicking outside (mobile only)
        document.addEventListener('click', function(e) {
            let shouldClose = false;
            
            if (!e.target.closest('.mobile-toggle') && 
                !e.target.closest('.nav-bar') && 
                !e.target.closest('.search-toggle-btn') && 
                !e.target.closest('.search-bar') &&
                !e.target.closest('.mobile-search-container') &&
                !e.target.closest('.custom-dropdown')) {
                shouldClose = true;
            }
            
            if (shouldClose && window.innerWidth < 992) {
                if (isMenuOpen && navBar && mobileToggle) {
                    isMenuOpen = false;
                    navBar.classList.remove('show');
                    mobileToggle.classList.remove('active');
                }
                
                // Close mobile search if open
                const mobileSearchOverlay = document.getElementById('mobileSearchOverlay');
                if (mobileSearchOverlay && mobileSearchOverlay.classList.contains('active')) {
                    closeMobileSearch();
                }
            }
        });

        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                if (window.innerWidth > 991) {
                    // Reset mobile states on desktop
                    if (mobileToggle) mobileToggle.classList.remove('active');
                    if (navBar) navBar.classList.remove('show');
                    if (searchToggleBtn) searchToggleBtn.classList.remove('active');
                    
                    // Close mobile search overlay
                    const mobileSearchOverlay = document.getElementById('mobileSearchOverlay');
                    if (mobileSearchOverlay) {
                        mobileSearchOverlay.classList.remove('active');
                    }
                    
                    // Close any open dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        menu.classList.remove('show');
                        menu.style.display = 'none';
                    });
                    
                    // Reinitialize dropdown functionality for desktop
                    initializeDropdowns();
                    
                    // Remove mobile backdrop if exists
                    const backdrop = document.querySelector('.user-menu-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }
                    
                    isMenuOpen = false;
                    isSearchOpen = false;
                    console.log('Switched to desktop mode');
                } else {
                    // Mobile mode - force close and disable ALL dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                        menu.classList.remove('show');
                        menu.style.display = 'none';
                    });
                    
                    // Remove ALL dropdown event listeners
                    document.querySelectorAll('.dropdown-toggle').forEach(function(dropdownToggle) {
                        dropdownToggle.removeEventListener('click', handleDropdownClick);
                    });
                    document.removeEventListener('click', handleDropdownOutsideClick);
                    
                    console.log('Switched to mobile mode - dropdowns disabled');
                }
            }, 100);
        });
    });

    // Mobile search functions
    function toggleMobileSearch() {
        const overlay = document.getElementById('mobileSearchOverlay');
        const input = document.getElementById('mobileSearchInput');
        const searchToggleBtn = document.querySelector('.search-toggle-btn');
        
        if (overlay) {
            overlay.classList.add('active');
            searchToggleBtn?.classList.add('active');
            
            // Focus input after animation
            setTimeout(() => {
                if (input) {
                    input.focus();
                }
            }, 300);
        }
    }

    function closeMobileSearch() {
        const overlay = document.getElementById('mobileSearchOverlay');
        const searchToggleBtn = document.querySelector('.search-toggle-btn');
        
        if (overlay) {
            overlay.classList.remove('active');
            searchToggleBtn?.classList.remove('active');
        }
    }

    // Close mobile search when clicking overlay
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('mobileSearchOverlay');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    closeMobileSearch();
                }
            });
        }
    });

    function toggleUserMenu(event) {
        event.stopPropagation();
        event.preventDefault();
        
        const menu = document.getElementById('userMenu');
        if (!menu) return;
        
        const isActive = menu.classList.contains('active');
        
        // Close all other dropdowns first (including Bootstrap dropdowns)
        document.querySelectorAll('.custom-dropdown-menu').forEach(m => {
            m.classList.remove('active');
        });
        document.querySelectorAll('.dropdown-menu').forEach(m => {
            m.classList.remove('show');
        });
        
        // Toggle current menu
        if (!isActive) {
            menu.classList.add('active');
            
            // Add backdrop for mobile
            if (window.innerWidth <= 768) {
                const backdrop = document.createElement('div');
                backdrop.className = 'user-menu-backdrop';
                backdrop.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 999998;
                `;
                document.body.appendChild(backdrop);
                
                backdrop.addEventListener('click', function() {
                    menu.classList.remove('active');
                    backdrop.remove();
                });
            }
        }
        
        // Close when clicking outside
        function closeMenu(e) {
            if (!e.target.closest('.custom-dropdown')) {
                menu.classList.remove('active');
                document.removeEventListener('click', closeMenu);
                
                // Remove backdrop if exists
                const backdrop = document.querySelector('.user-menu-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }
        }
        
        document.addEventListener('click', closeMenu);
        
        // Close with escape key
        function closeWithEscape(e) {
            if (e.key === 'Escape') {
                menu.classList.remove('active');
                document.removeEventListener('keydown', closeWithEscape);
                document.removeEventListener('click', closeMenu);
                
                const backdrop = document.querySelector('.user-menu-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            }
        }
        
        document.addEventListener('keydown', closeWithEscape);
    }

    let lastScrollTop = 0;
      const header = document.querySelector(".medical-header");

      window.addEventListener("scroll", function () {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        if (currentScroll > lastScrollTop && currentScroll > 100) {
          // Cuộn xuống
          header.style.top = "-140px"; // Ẩn đi
        } else {
          // Cuộn lên
          header.style.top = "0"; // Hiện lại
        }

        lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Prevent negative
      });



      document.getElementById("logout").addEventListener("click", async () => {
      try {
        // Gọi logout.php để server logout
        const response = await fetch("logout.php", {
          method: "POST",
          credentials: "include" // giữ cookie/session
        });

        if (!response.ok) throw new Error("Logout không thành công");

        // Xóa localStorage
        localStorage.removeItem("userInfo");

        // Redirect về trang login
        window.location.href = "login.php";
      } catch (err) {
        alert("Có lỗi khi logout: " + err.message);
      }
    });


    </script>



