// Cart Management System
class CartManager {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateCartDisplay();
    }

    bindEvents() {
        // Add to cart buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-to-cart') || e.target.closest('.btn-add-to-cart')) {
                e.preventDefault();
                this.handleAddToCart(e.target.closest('.add-to-cart') || e.target.closest('.btn-add-to-cart'));
            }
        });

        // Wishlist buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('.add-to-wishlist') || e.target.closest('.btn-add-to-wishlist')) {
                e.preventDefault();
                this.handleAddToWishlist(e.target.closest('.add-to-wishlist') || e.target.closest('.btn-add-to-wishlist'));
            }
        });
    }

    async handleAddToCart(button) {
        const productId = button.dataset.id;
        
        if (!productId) {
            this.showNotification('Không tìm thấy thông tin sản phẩm', 'error');
            return;
        }

        // Check if user is logged in
        const isLoggedIn = await this.checkAuthStatus();
        if (!isLoggedIn) {
            this.showNotification('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng', 'error');
            setTimeout(() => {
                window.location.href = '/login.php';
            }, 1500);
            return;
        }

        // Get quantity (for product details page)
        let quantity = 1;
        const quantityInput = document.querySelector('.quantity-input');
        if (quantityInput) {
            quantity = parseInt(quantityInput.value) || 1;
        }

        // Disable button during request
        const originalHtml = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        try {
            const response = await fetch('/api/cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: parseInt(productId),
                    quantity: quantity
                })
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification('Đã thêm sản phẩm vào giỏ hàng', 'success');
                this.updateCartCount(data.cart_count);
                
                // Add visual feedback
                this.addToCartAnimation(button);
            } else {
                this.showNotification(data.message || 'Có lỗi xảy ra', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Có lỗi xảy ra khi thêm sản phẩm', 'error');
        } finally {
            // Re-enable button
            button.disabled = false;
            button.innerHTML = originalHtml;
        }
    }

    async handleAddToWishlist(button) {
        const productId = button.dataset.id;
        
        if (!productId) return;

        // Check if user is logged in
        const isLoggedIn = await this.checkAuthStatus();
        if (!isLoggedIn) {
            this.showNotification('Vui lòng đăng nhập để thêm vào danh sách yêu thích', 'error');
            return;
        }

        try {
            const response = await fetch('/api/wishlist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: parseInt(productId)
                })
            });

            const data = await response.json();

            if (data.success) {
                const icon = button.querySelector('i');
                if (data.added) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.showNotification('Đã thêm vào danh sách yêu thích', 'success');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.showNotification('Đã xóa khỏi danh sách yêu thích', 'info');
                }
            } else {
                this.showNotification(data.message || 'Có lỗi xảy ra', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification('Có lỗi xảy ra', 'error');
        }
    }

    async checkAuthStatus() {
        try {
            const response = await fetch('/api/check-auth.php');
            const data = await response.json();
            return data.authenticated;
        } catch (error) {
            return false;
        }
    }

    async updateCartDisplay() {
        try {
            const response = await fetch('/api/cart.php');
            const data = await response.json();
            
            if (data.success) {
                this.updateCartCount(data.count);
            }
        } catch (error) {
            console.error('Error updating cart display:', error);
        }
    }

    updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = count;
            element.style.display = count > 0 ? 'inline' : 'none';
        });

        // Update cart badge
        const cartBadges = document.querySelectorAll('.cart-badge');
        cartBadges.forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline' : 'none';
        });
    }

    addToCartAnimation(button) {
        // Add a temporary success class for animation
        button.classList.add('btn-success');
        setTimeout(() => {
            button.classList.remove('btn-success');
        }, 1000);

        // Animate cart icon if exists
        const cartIcons = document.querySelectorAll('.fa-shopping-cart');
        cartIcons.forEach(icon => {
            icon.classList.add('animate-bounce');
            setTimeout(() => {
                icon.classList.remove('animate-bounce');
            }, 600);
        });
    }

    showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.cart-notification');
        existingNotifications.forEach(notification => notification.remove());

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `cart-notification alert alert-${this.getAlertClass(type)} position-fixed`;
        notification.style.cssText = `
            top: 20px; 
            right: 20px; 
            z-index: 9999; 
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            animation: slideInRight 0.3s ease-out;
        `;
        
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${this.getIcon(type)} me-2"></i>
                <span class="flex-grow-1">${message}</span>
                <button type="button" class="btn-close ms-2" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => notification.remove(), 300);
            }
        }, 4000);
    }

    getAlertClass(type) {
        const classes = {
            'success': 'success',
            'error': 'danger',
            'info': 'info',
            'warning': 'warning'
        };
        return classes[type] || 'info';
    }

    getIcon(type) {
        const icons = {
            'success': 'fa-check-circle',
            'error': 'fa-exclamation-circle',
            'info': 'fa-info-circle',
            'warning': 'fa-exclamation-triangle'
        };
        return icons[type] || 'fa-info-circle';
    }
}

// Initialize cart manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.cartManager = new CartManager();
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% {
            transform: scale(1);
        }
        40%, 43% {
            transform: scale(1.2);
        }
        70% {
            transform: scale(1.1);
        }
        90% {
            transform: scale(1.05);
        }
    }
    
    .animate-bounce {
        animation: bounce 0.6s ease-in-out;
    }
    
    .btn-success {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
        transition: all 0.3s ease;
    }
    
    .cart-notification {
        transition: all 0.3s ease;
    }
`;
document.head.appendChild(style); 