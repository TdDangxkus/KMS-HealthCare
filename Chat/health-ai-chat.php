<?php
session_start();
require_once '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Người dùng';
$user_role = $_SESSION['role_name'] ?? 'patient';

$role_display = [
    'admin' => 'Quản trị viên',
    'patient' => 'Bệnh nhân', 
    'doctor' => 'Bác sĩ'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🩺 AI Health Chat - Tư vấn sức khỏe thông minh | MediSync</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    
    <!-- Custom Styles -->
    <link href="health-ai-chat.css" rel="stylesheet">
</head>

<body>
    <!-- Removed floating shapes for better performance -->

    <div class="chat-wrapper">
        <!-- Header -->
        <div class="chat-header">
            <div class="header-left">
                <button class="back-btn" onclick="goHome()" title="Quay lại trang chủ">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div class="chat-info">
                    <h1>AI Health Chat</h1>
                    <p>Trợ lý sức khỏe thông minh</p>
                </div>
            </div>
            
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <?= strtoupper(substr($user_name, 0, 1)) ?>
                    </div>
                    <div class="user-details">
                        <h4><?= htmlspecialchars($user_name) ?></h4>
                        <p><?= $role_display[$user_role] ?? 'Người dùng' ?></p>
                    </div>
                </div>
                
                <div class="header-actions">
                    <button class="action-btn close" onclick="closeChat()" title="Đóng trò chuyện">
                        <i class="fas fa-times"></i>
                    </button>
                    <button class="action-btn refresh" onclick="refreshChat()" title="Làm mới trò chuyện">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button class="action-btn danger" onclick="logout()" title="Đăng xuất">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Chat -->
        <div class="chat-main">
            <!-- Removed duplicate chat controls - now only in header -->

            <!-- Inner Header -->
            <div class="chat-inner-header">
                <div class="inner-header-content">
                    <h1 class="chat-title">
                        <i class="fas fa-robot"></i>
                        AI Health Assistant
                    </h1>
                    <p class="chat-subtitle">
                        Chào mừng <?= htmlspecialchars($user_name) ?>! Tôi sẵn sàng tư vấn sức khỏe cho bạn
                    </p>
                    
                    <div class="status-indicator">
                        <div class="status-dot"></div>
                        AI đang online - Sẵn sàng hỗ trợ
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="messages-area" id="messagesArea">
                <!-- Welcome -->
                <!-- <div class="welcome-card" id="welcomeCard">
                    <div class="welcome-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h2 class="welcome-title">Xin chào! Tôi có thể giúp gì cho bạn? 👋</h2>
                    <p class="welcome-text">
                        Tôi là trợ lý AI chuyên về y tế và sức khỏe. Hãy đặt câu hỏi hoặc chọn một chủ đề dưới đây để bắt đầu!
                    </p>
                    
                    <div class="quick-suggestions">
                        <div class="suggestion-btn" onclick="sendMessage('Tôi bị đau đầu thường xuyên, nguyên nhân có thể là gì?')">
                            <span class="suggestion-emoji">🤕</span>
                            <div class="suggestion-title">Đau đầu</div>
                            <div class="suggestion-desc">Tư vấn về triệu chứng đau đầu</div>
                        </div>
                        
                        <div class="suggestion-btn" onclick="sendMessage('Làm thế nào để chăm sóc da mặt hiệu quả?')">
                            <span class="suggestion-emoji">✨</span>
                            <div class="suggestion-title">Chăm sóc da</div>
                            <div class="suggestion-desc">Hướng dẫn chăm sóc da đúng cách</div>
                        </div>
                        
                        <div class="suggestion-btn" onclick="sendMessage('Chế độ dinh dưỡng nào phù hợp cho trẻ em?')">
                            <span class="suggestion-emoji">👶</span>
                            <div class="suggestion-title">Dinh dưỡng trẻ em</div>
                            <div class="suggestion-desc">Tư vấn dinh dưỡng cho trẻ</div>
                        </div>
                        
                        <div class="suggestion-btn" onclick="sendMessage('Cách phòng ngừa cảm cúm hiệu quả?')">
                            <span class="suggestion-emoji">🛡️</span>
                            <div class="suggestion-title">Phòng ngừa bệnh</div>
                            <div class="suggestion-desc">Tăng cường miễn dịch</div>
                        </div>
                        
                        <div class="suggestion-btn" onclick="sendMessage('Làm thế nào để chăm sóc người cao tuổi?')">
                            <span class="suggestion-emoji">👴</span>
                            <div class="suggestion-title">Chăm sóc người già</div>
                            <div class="suggestion-desc">Sức khỏe người cao tuổi</div>
                        </div>
                        
                        <div class="suggestion-btn" onclick="sendMessage('Tôi muốn tập thể dục để giảm cân, bắt đầu như thế nào?')">
                            <span class="suggestion-emoji">💪</span>
                            <div class="suggestion-title">Thể dục & giảm cân</div>
                            <div class="suggestion-desc">Lời khuyên về tập luyện</div>
                        </div>
                    </div>
                </div> -->

                <!-- Typing indicator will be dynamically created -->
            </div>

            <!-- Input Area -->
            <div class="input-area">
                <form id="chatForm">
                    <div class="input-container">
                        <textarea 
                            id="messageInput" 
                            class="message-input" 
                            placeholder="Nhập câu hỏi về sức khỏe của bạn..." 
                            rows="1"
                            required
                        ></textarea>
                        <div class="input-actions">
                            <button type="button" class="attach-btn" title="Đính kèm file">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <button type="submit" class="send-btn" id="sendBtn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');
        const messagesArea = document.getElementById('messagesArea');
        const welcomeCard = document.getElementById('welcomeCard');
        const chatForm = document.getElementById('chatForm');
        
        // Global typing indicator variable
        let typingIndicator = null;

        // Auto-resize textarea
        messageInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // Navigation functions
        function goHome() {
            window.location.href = '../index.php';
        }

        function logout() {
            if (confirm('Bạn có chắc muốn đăng xuất?')) {
                window.location.href = '../logout.php';
            }
        }

        function refreshChat() {
            if (confirm('Làm mới trò chuyện? Tất cả tin nhắn sẽ bị xóa.')) {
                location.reload();
            }
        }

        function closeChat() {
            if (confirm('Đóng trò chuyện và quay về trang chủ?')) {
                window.location.href = '../index.php';
            }
        }

        // Chat functions
        function scrollToBottom() {
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        function showTyping() {
            console.log('Show typing indicator');
            
            // Remove existing typing indicator if any
            hideTyping();
            
            // Create new typing indicator
            typingIndicator = document.createElement('div');
            typingIndicator.className = 'message bot';
            typingIndicator.id = 'typingIndicator';
            
            const avatar = document.createElement('div');
            avatar.className = 'message-avatar';
            avatar.innerHTML = '<i class="fas fa-robot"></i>';
            
            const typingContent = document.createElement('div');
            typingContent.className = 'typing-dots';
            typingContent.innerHTML = `
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            `;
            
            typingIndicator.appendChild(avatar);
            typingIndicator.appendChild(typingContent);
            
            // Add to messages area
            messagesArea.appendChild(typingIndicator);
            scrollToBottom();
        }

        function hideTyping() {
            console.log('Hide typing indicator');
            if (typingIndicator && typingIndicator.parentNode) {
                typingIndicator.parentNode.removeChild(typingIndicator);
                typingIndicator = null;
            }
        }

        function addMessage(content, isUser = false) {
            if (welcomeCard && isUser) {
                welcomeCard.style.display = 'none';
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
            
            const avatar = document.createElement('div');
            avatar.className = 'message-avatar';
            avatar.innerHTML = isUser ? '<i class="fas fa-user"></i>' : '<i class="fas fa-robot"></i>';
            
            const content_div = document.createElement('div');
            content_div.className = 'message-content';
            
            if (isUser) {
                content_div.textContent = content;
            } else {
                content_div.innerHTML = marked.parse(content);
            }
            
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(content_div);
            
            messagesArea.appendChild(messageDiv);
            scrollToBottom();
        }

        function sendMessage(text) {
            messageInput.value = text;
            chatForm.dispatchEvent(new Event('submit'));
        }

        // Form submission
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (!message) return;
            
            // Add user message
            addMessage(message, true);
            
            // Clear input
            messageInput.value = '';
            messageInput.style.height = 'auto';
            
            // Disable send button and show typing
            sendBtn.disabled = true;
            
            // Ensure typing indicator is reset and shown
            hideTyping();
            setTimeout(() => {
                showTyping();
                
                // Simulate AI response with delay
                setTimeout(() => {
                    hideTyping();
                    sendBtn.disabled = false;
                    
                    const responses = [
                    `**🩺 Phân tích tình trạng:**

Cảm ơn bạn đã chia sẻ! Dựa trên mô tả của bạn, đây là những thông tin hữu ích:

**📋 Đánh giá ban đầu:**
- Triệu chứng bạn mô tả khá phổ biến
- Có thể có nhiều nguyên nhân khác nhau
- Cần xem xét tổng thể về lối sống và sức khỏe

**💡 Các biện pháp tự chăm sóc:**
- Đảm bảo nghỉ ngơi đầy đủ (7-8 tiếng/ngày)
- Uống đủ nước (2-2.5L/ngày)
- Tập thể dục nhẹ nhàng, đều đặn
- Quản lý stress hiệu quả
- Chế độ dinh dưỡng cân bằng

**⚠️ Khi nào cần gặp bác sĩ:**
- Triệu chứng kéo dài hoặc trở nên nghiêm trọng
- Xuất hiện các dấu hiệu bất thường khác
- Ảnh hưởng đến sinh hoạt hàng ngày

*Lưu ý: Đây là thông tin tham khảo. Hãy tham khảo ý kiến bác sĩ để có chẩn đoán chính xác.*`,

                    `**✨ Hướng dẫn chăm sóc sức khỏe:**

Rất vui được hỗ trợ bạn! Dưới đây là những lời khuyên hữu ích:

**🌟 Chế độ sinh hoạt khoa học:**
- **Giấc ngủ:** 7-8 tiếng mỗi đêm, đi ngủ đúng giờ
- **Dinh dưỡng:** Ăn đủ 3 bữa, tăng rau xanh, trái cây
- **Thể dục:** 30 phút/ngày, ít nhất 5 ngày/tuần
- **Tinh thần:** Thư giãn, thiền, nghe nhạc

**🥗 Dinh dưỡng cân bằng:**
- Protein: Thịt, cá, trứng, đậu
- Carbohydrate: Cơm, bánh mì nguyên cám
- Chất béo tốt: Dầu ô liu, hạt, cá biển
- Vitamin & khoáng chất: Rau củ quả đa dạng

**📊 Theo dõi sức khỏe:**
- Kiểm tra cân nặng, huyết áp định kỳ
- Ghi chép cảm giác hàng ngày
- Khám sức khỏe tổng quát 6 tháng/lần

**💝 Lời khuyên cuối:**
Hãy kiên nhẫn và thực hiện từng bước một cách bền vững!`,

                    `**🔬 Phân tích chuyên sâu:**

Tôi hiểu mối quan tâm của bạn. Hãy cùng tìm hiểu chi tiết:

**🎯 Kế hoạch cải thiện từng bước:**

**Tuần 1-2: Thiết lập nền tảng**
- Điều chỉnh giờ giấc sinh hoạt
- Tăng lượng nước uống hàng ngày
- Bắt đầu tập thể dục nhẹ

**Tuần 3-4: Phát triển thói quen**
- Ổn định chế độ ăn uống
- Tăng cường hoạt động thể chất
- Thực hành kỹ thuật thư giãn

**Tuần 5-8: Duy trì và nâng cao**
- Đánh giá tiến độ cải thiện
- Điều chỉnh kế hoạch phù hợp
- Xây dựng thói quen lâu dài

**📈 Dấu hiệu tích cực:**
- Ngủ ngon hơn, tỉnh táo buổi sáng
- Tinh thần phấn chấn, ít stress
- Thể lực được cải thiện
- Sức đề kháng tăng cường

**🚨 Cần lưu ý:**
Nếu không thấy cải thiện sau 2-3 tuần, hãy tham khảo ý kiến chuyên gia y tế.`,

                    `**🏥 Tư vấn y tế chuyên nghiệp:**

Xin chào! Tôi sẽ hỗ trợ bạn một cách tốt nhất có thể:

**🔍 Phương pháp đánh giá:**
- Xem xét triệu chứng một cách toàn diện
- Phân tích các yếu tố nguy cơ
- Đưa ra khuyến nghị phù hợp

**📝 Thông tin cần thiết:**
- Mô tả chi tiết triệu chứng
- Thời gian xuất hiện
- Các yếu tố liên quan
- Tiền sử bệnh lý (nếu có)

**💊 Lưu ý quan trọng:**
- Không tự ý dùng thuốc khi chưa có chỉ định
- Theo dõi sát triệu chứng
- Ghi chép nhật ký sức khỏe

**📞 Khi nào cần hỗ trợ y tế:**
- Triệu chứng nặng hoặc kéo dài
- Có dấu hiệu báo động
- Cần tư vấn chuyên sâu

Hãy chia sẻ thêm để tôi có thể hỗ trợ bạn tốt hơn!`
                ];
                
                                    const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                    addMessage(randomResponse, false);
                    
                    messageInput.focus();
                }, Math.random() * 2000 + 1000);
            }, 100);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey && document.activeElement === messageInput) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });

        // Prevent accidental page refresh
        let hasMessages = false;
        
        // Track when user starts chatting
        function setHasMessages() {
            hasMessages = true;
        }
        
        // Override the original addMessage to track messages
        const originalAddMessage = addMessage;
        addMessage = function(content, isUser = false) {
            originalAddMessage(content, isUser);
            if (isUser || (!welcomeCard || welcomeCard.style.display === 'none')) {
                setHasMessages();
            }
        };
        
        // Prevent refresh/F5 when there are messages
        window.addEventListener('beforeunload', function(e) {
            if (hasMessages) {
                const message = 'Bạn có chắc muốn rời khỏi trang? Tất cả tin nhắn sẽ bị mất!';
                e.preventDefault();
                e.returnValue = message;
                return message;
            }
        });
        
        // Prevent F5 key specifically
        document.addEventListener('keydown', function(e) {
            // F5 key
            if (e.key === 'F5' || (e.ctrlKey && e.key === 'r')) {
                if (hasMessages) {
                    e.preventDefault();
                    if (confirm('Bạn có chắc muốn làm mới trang? Tất cả tin nhắn chat sẽ bị mất!')) {
                        hasMessages = false; // Allow refresh
                        location.reload();
                    }
                }
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            messageInput.focus();
            scrollToBottom();
        });
    </script>
</body>
</html> 