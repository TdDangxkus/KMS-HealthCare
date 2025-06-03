// Blog Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations
    initializeAnimations();
    
    // Initialize blog post interactions
    initializeBlogPosts();
    
    // Initialize sidebar functionality
    initializeSidebar();
    
    // Initialize search functionality
    initializeSearch();
    
    // Initialize scroll animations
    initializeScrollAnimations();
});

// Initialize scroll-triggered animations
function initializeAnimations() {
    // Animate hero content on load
    const heroContent = document.querySelector('.hero-content');
    
    if (heroContent) {
        heroContent.style.opacity = '0';
        heroContent.style.transform = 'translateY(50px)';
        
        setTimeout(() => {
            heroContent.style.transition = 'all 1s ease';
            heroContent.style.opacity = '1';
            heroContent.style.transform = 'translateY(0)';
        }, 300);
    }
}

// Blog post interactions
function initializeBlogPosts() {
    const blogPosts = document.querySelectorAll('.blog-post');
    
    blogPosts.forEach(post => {
        const image = post.querySelector('.post-image img');
        const readMore = post.querySelector('.read-more');
        const category = post.querySelector('.post-category');
        
        post.addEventListener('mouseenter', () => {
            // Add glow effect
            post.style.transform = 'translateY(-5px)';
            post.style.boxShadow = '0 15px 35px rgba(102, 126, 234, 0.2)';
            
            // Animate category
            if (category) {
                category.style.transform = 'translateX(5px)';
                category.style.background = '#667eea';
                category.style.color = 'white';
            }
            
            // Animate read more
            if (readMore) {
                readMore.style.transform = 'translateX(10px)';
            }
        });
        
        post.addEventListener('mouseleave', () => {
            // Remove glow effect
            post.style.transform = 'translateY(0)';
            post.style.boxShadow = '';
            
            // Reset category
            if (category) {
                category.style.transform = 'translateX(0)';
                category.style.background = '';
                category.style.color = '';
            }
            
            // Reset read more
            if (readMore) {
                readMore.style.transform = 'translateX(0)';
            }
        });
        
        // Click to read functionality
        post.addEventListener('click', (e) => {
            if (e.target.tagName !== 'A') {
                const readMoreLink = post.querySelector('.read-more');
                if (readMoreLink) {
                    readMoreLink.click();
                }
            }
        });
    });
    
    // Featured post special interactions
    const featuredPost = document.querySelector('.blog-post.featured');
    if (featuredPost) {
        const badge = featuredPost.querySelector('.post-badge');
        
        featuredPost.addEventListener('mouseenter', () => {
            if (badge) {
                badge.style.transform = 'scale(1.1) rotate(5deg)';
            }
        });
        
        featuredPost.addEventListener('mouseleave', () => {
            if (badge) {
                badge.style.transform = 'scale(1) rotate(0deg)';
            }
        });
    }
}

// Sidebar functionality
function initializeSidebar() {
    // Category list interactions
    const categoryItems = document.querySelectorAll('.category-list a');
    categoryItems.forEach(item => {
        const count = item.querySelector('.category-count');
        
        item.addEventListener('mouseenter', () => {
            if (count) {
                count.style.background = '#667eea';
                count.style.color = 'white';
                count.style.transform = 'scale(1.1)';
            }
        });
        
        item.addEventListener('mouseleave', () => {
            if (count) {
                count.style.background = '';
                count.style.color = '';
                count.style.transform = 'scale(1)';
            }
        });
    });
    
    // Recent post interactions
    const recentPosts = document.querySelectorAll('.recent-post');
    recentPosts.forEach(post => {
        const image = post.querySelector('.recent-post-image img');
        
        post.addEventListener('mouseenter', () => {
            post.style.background = 'rgba(102, 126, 234, 0.05)';
            post.style.borderRadius = '10px';
            post.style.padding = '0.75rem';
            post.style.margin = '0 -0.75rem';
            
            if (image) {
                image.style.transform = 'scale(1.05)';
            }
        });
        
        post.addEventListener('mouseleave', () => {
            post.style.background = '';
            post.style.borderRadius = '';
            post.style.padding = '';
            post.style.margin = '';
            
            if (image) {
                image.style.transform = 'scale(1)';
            }
        });
    });
    
    // Newsletter form
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = newsletterForm.querySelector('input[type="email"]').value;
            handleNewsletterSignup(email);
        });
    }
}

// Handle newsletter signup
function handleNewsletterSignup(email) {
    if (!email) return;
    
    const button = document.querySelector('.newsletter-form button');
    const originalText = button.textContent;
    
    // Show loading
    button.innerHTML = '<div class="loading"></div>';
    button.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        button.innerHTML = '<i class="fas fa-check"></i> Đã đăng ký';
        button.style.background = '#28a745';
        
        showNotification('Đăng ký nhận tin thành công!', 'success');
        
        // Reset after 3 seconds
        setTimeout(() => {
            button.textContent = originalText;
            button.style.background = '';
            button.disabled = false;
            document.querySelector('.newsletter-form input').value = '';
        }, 3000);
    }, 1500);
}

// Search functionality
function initializeSearch() {
    const searchForm = document.querySelector('.search-box');
    const searchInput = searchForm?.querySelector('input');
    const searchBtn = searchForm?.querySelector('button');
    
    if (searchForm && searchInput && searchBtn) {
        // Search on button click
        searchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            performSearch(searchInput.value);
        });
        
        // Search on form submit
        searchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            performSearch(searchInput.value);
        });
        
        // Real-time search suggestions
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value;
            if (query.length > 2) {
                showSearchSuggestions(query);
            } else {
                hideSearchSuggestions();
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!searchForm.contains(e.target)) {
                hideSearchSuggestions();
            }
        });
    }
}

// Perform search
function performSearch(query) {
    if (!query.trim()) return;
    
    console.log('Searching blog for:', query);
    
    // Show loading
    showSearchLoading();
    
    // Simulate API call
    setTimeout(() => {
        hideSearchLoading();
        // In real app, filter posts or redirect to search results
        filterBlogPosts(query);
    }, 1000);
}

// Show search suggestions
function showSearchSuggestions(query) {
    const suggestions = [
        'Chăm sóc sức khỏe',
        'Dinh dưỡng',
        'Tập thể dục',
        'Giấc ngủ',
        'Vitamin',
        'Tim mạch',
        'Miễn dịch',
        'Stress'
    ].filter(item => item.toLowerCase().includes(query.toLowerCase()));
    
    if (suggestions.length > 0) {
        const suggestionsHtml = suggestions.map(suggestion => 
            `<div class="search-suggestion" onclick="selectSuggestion('${suggestion}')">${suggestion}</div>`
        ).join('');
        
        showSuggestionDropdown(suggestionsHtml);
    }
}

// Hide search suggestions
function hideSearchSuggestions() {
    const dropdown = document.querySelector('.search-suggestions-dropdown');
    if (dropdown) {
        dropdown.remove();
    }
}

// Show suggestion dropdown
function showSuggestionDropdown(html) {
    hideSearchSuggestions();
    
    const searchWidget = document.querySelector('.search-widget');
    const dropdown = document.createElement('div');
    dropdown.className = 'search-suggestions-dropdown';
    dropdown.innerHTML = html;
    dropdown.style.cssText = `
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    `;
    
    // Style suggestions
    const style = document.createElement('style');
    style.textContent = `
        .search-suggestion {
            padding: 12px 16px;
            cursor: pointer;
            transition: background 0.2s ease;
            border-bottom: 1px solid #f8f9fa;
        }
        .search-suggestion:hover {
            background: #f8f9fa;
            color: #667eea;
        }
        .search-suggestion:last-child {
            border-bottom: none;
        }
    `;
    document.head.appendChild(style);
    
    searchWidget.style.position = 'relative';
    searchWidget.appendChild(dropdown);
}

// Select suggestion
function selectSuggestion(suggestion) {
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.value = suggestion;
        performSearch(suggestion);
    }
    hideSearchSuggestions();
}

// Show search loading
function showSearchLoading() {
    const searchBtn = document.querySelector('.search-box button');
    if (searchBtn) {
        searchBtn.innerHTML = '<div class="loading"></div>';
        searchBtn.disabled = true;
    }
}

// Hide search loading
function hideSearchLoading() {
    const searchBtn = document.querySelector('.search-box button');
    if (searchBtn) {
        searchBtn.innerHTML = '<i class="fas fa-search"></i>';
        searchBtn.disabled = false;
    }
}

// Filter blog posts
function filterBlogPosts(query) {
    const posts = document.querySelectorAll('.blog-post');
    let visibleCount = 0;
    
    posts.forEach(post => {
        const title = post.querySelector('h2, h3')?.textContent?.toLowerCase() || '';
        const content = post.querySelector('p')?.textContent?.toLowerCase() || '';
        const category = post.querySelector('.post-category')?.textContent?.toLowerCase() || '';
        
        const matches = title.includes(query.toLowerCase()) || 
                       content.includes(query.toLowerCase()) || 
                       category.includes(query.toLowerCase());
        
        if (matches) {
            post.style.display = 'block';
            post.style.opacity = '1';
            visibleCount++;
        } else {
            post.style.opacity = '0.3';
            post.style.filter = 'grayscale(100%)';
        }
    });
    
    // Show search results info
    showSearchResults(query, visibleCount);
}

// Show search results info
function showSearchResults(query, count) {
    // Remove existing search info
    const existingInfo = document.querySelector('.search-results-info');
    if (existingInfo) existingInfo.remove();
    
    // Create new search info
    const searchInfo = document.createElement('div');
    searchInfo.className = 'search-results-info';
    searchInfo.innerHTML = `
        <div class="alert alert-info">
            <i class="fas fa-search me-2"></i>
            Tìm thấy ${count} bài viết cho từ khóa "<strong>${query}</strong>"
            <button class="btn btn-sm btn-outline-primary ms-3" onclick="clearSearch()">
                <i class="fas fa-times me-1"></i>Xóa bộ lọc
            </button>
        </div>
    `;
    
    const blogContent = document.querySelector('.blog-section .container');
    blogContent.insertBefore(searchInfo, blogContent.firstChild);
}

// Clear search
function clearSearch() {
    const posts = document.querySelectorAll('.blog-post');
    posts.forEach(post => {
        post.style.display = '';
        post.style.opacity = '';
        post.style.filter = '';
    });
    
    const searchInfo = document.querySelector('.search-results-info');
    if (searchInfo) searchInfo.remove();
    
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) searchInput.value = '';
}

// Initialize scroll animations
function initializeScrollAnimations() {
    const animatedElements = document.querySelectorAll(
        '.blog-post, .sidebar-widget, .section-title'
    );
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });
    
    animatedElements.forEach((element, index) => {
        // Set initial state
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = `all 0.6s ease ${index * 0.05}s`;
        
        observer.observe(element);
    });
    
    // Add CSS for animate-in class
    const style = document.createElement('style');
    style.textContent = `
        .animate-in {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        
        .blog-post.animate-in,
        .sidebar-widget.animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .loading {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 50%;
            border-top-color: #667eea;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle me-2"></i>
        ${message}
    `;
    
    const color = type === 'success' ? '#28a745' : '#667eea';
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${color};
        color: white;
        padding: 12px 20px;
        border-radius: 25px;
        z-index: 1000;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    `;
    
    // Add animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideInRight 0.3s ease reverse';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add loading animation
function addLoadingAnimation() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.innerHTML = `
        <div style="
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        ">
            <div style="
                width: 50px;
                height: 50px;
                border: 3px solid #f3f3f3;
                border-top: 3px solid #667eea;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            "></div>
        </div>
    `;
    
    document.body.appendChild(loadingOverlay);
    
    window.addEventListener('load', () => {
        setTimeout(() => {
            loadingOverlay.style.opacity = '0';
            setTimeout(() => {
                loadingOverlay.remove();
            }, 500);
        }, 800);
    });
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    addLoadingAnimation();
});

// Add scroll progress indicator
function addScrollProgress() {
    const progressBar = document.createElement('div');
    progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        z-index: 1000;
        transition: width 0.1s ease;
    `;
    document.body.appendChild(progressBar);
    
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset;
        const docHeight = document.body.scrollHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        progressBar.style.width = scrollPercent + '%';
    });
}

// Initialize scroll progress
document.addEventListener('DOMContentLoaded', addScrollProgress); 