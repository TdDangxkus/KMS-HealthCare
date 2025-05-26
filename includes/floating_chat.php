<!-- Floating Chat Button with Animated Popout (Modern, Beautiful, Small, Suggestion Bubble, Fixed Overlap) -->
<div id="floating-chat-group">
  <button id="main-chat-btn" class="chat-float-btn animate-glow" title="Liên hệ nhanh">
    <i class="fas fa-comments"></i>
  </button>
  <div id="chat-suggestion-bubble" class="chat-suggestion-bubble" style="display:none;"></div>
  <div id="chat-actions" class="chat-actions">
    <a href="https://zalo.me/" target="_blank" class="chat-action-btn chat-zalo" title="Chat Zalo"><img src="/assets/img/zalo-icon.png" alt="Zalo" style="width:22px;height:22px;"></a>
    <a href="https://facebook.com/" target="_blank" class="chat-action-btn chat-fb" title="Chat Facebook"><i class="fab fa-facebook-messenger"></i></a>
    <button class="chat-action-btn chat-ai" title="Chat với AI" onclick="window.dispatchEvent(new Event('open-ai-chatbox'));"><i class="fas fa-robot"></i></button>
  </div>
</div>
<style>
#floating-chat-group {
  position: fixed;
  bottom: 24px;
  right: 24px;
  z-index: 9999;
}
.chat-float-btn {
  background: linear-gradient(135deg,#1976d2 0%,#1ec0f7 100%);
  border: none;
  border-radius: 50%;
  width: 44px;
  height: 44px;
  box-shadow: 0 0 0 0 #1ec0f7, 0 4px 16px rgba(25,118,210,0.13);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 1.35rem;
  cursor: pointer;
  transition: box-shadow 0.3s, background 0.2s;
  outline: none;
  position: relative;
  filter: drop-shadow(0 0 6px #1ec0f7aa);
  z-index: 2;
}
.animate-glow {
  animation: glow 2.2s infinite alternate;
}
@keyframes glow {
  0% { box-shadow: 0 0 0 0 #1ec0f7, 0 4px 16px rgba(25,118,210,0.13); }
  100% { box-shadow: 0 0 8px 4px #1ec0f799, 0 4px 16px rgba(25,118,210,0.13); }
}
.chat-suggestion-bubble {
  position: absolute;
  right: 54px;
  bottom: 0;
  background: linear-gradient(90deg,#1ec0f7 0%,#1976d2 100%);
  color: #fff;
  font-size: 1rem;
  padding: 8px 18px;
  border-radius: 18px 18px 18px 0;
  box-shadow: 0 2px 12px rgba(30,192,247,0.13);
  white-space: nowrap;
  opacity: 0.97;
  z-index: 10;
  animation: fadeInBubble 0.5s;
  pointer-events: none;
}
@keyframes fadeInBubble {
  from { opacity: 0; transform: translateY(10px) scale(0.95); }
  to { opacity: 0.97; transform: translateY(0) scale(1); }
}
.chat-actions {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 0;
  height: 0;
  pointer-events: none;
  z-index: 1;
}
.chat-action-btn {
  position: absolute;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: linear-gradient(135deg,#1976d2 0%,#1ec0f7 100%);
  color: #fff;
  box-shadow: 0 2px 8px rgba(30,192,247,0.13);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
  opacity: 0;
  transform: scale(0.5);
  transition: all 0.35s cubic-bezier(.68,-0.55,.27,1.55);
  pointer-events: none;
  border: none;
  outline: none;
  filter: drop-shadow(0 0 4px #1ec0f7aa);
  z-index: 1;
}
#floating-chat-group.open .chat-action-btn {
  opacity: 1;
  transform: scale(1);
  pointer-events: auto;
}
#floating-chat-group.open .chat-zalo {
  right: 54px;
  bottom: 0;
  transition-delay: 0.05s;
}
#floating-chat-group.open .chat-fb {
  right: 38px;
  bottom: 38px;
  transition-delay: 0.12s;
}
#floating-chat-group.open .chat-ai {
  right: 0;
  bottom: 54px;
  transition-delay: 0.18s;
}
.chat-action-btn:hover {
  background: linear-gradient(135deg,#1ec0f7 0%,#1976d2 100%);
  color: #fff;
  box-shadow: 0 6px 18px rgba(30,192,247,0.18);
  filter: drop-shadow(0 0 8px #1ec0f7cc);
}
.chat-action-btn[title]:hover:after {
  content: attr(title);
  position: absolute;
  left: 50%;
  top: -32px;
  transform: translateX(-50%);
  background: #1976d2;
  color: #fff;
  padding: 4px 12px;
  border-radius: 8px;
  font-size: 0.93rem;
  white-space: nowrap;
  box-shadow: 0 2px 8px rgba(30,192,247,0.13);
  opacity: 0.95;
  pointer-events: none;
  z-index: 10;
}
@media (max-width: 600px) {
  #floating-chat-group { right: 7px; bottom: 7px; }
  .chat-float-btn { width:36px;height:36px;font-size:1rem; }
  .chat-action-btn { width:28px;height:28px;font-size:0.9rem; }
  #floating-chat-group.open .chat-zalo { right: 34px; }
  #floating-chat-group.open .chat-fb { right: 24px; bottom: 24px; }
  #floating-chat-group.open .chat-ai { bottom: 34px; }
  .chat-suggestion-bubble { right: 40px; font-size:0.93rem; padding:6px 12px; }
}
</style>
<script>
(function(){
  var group = document.getElementById('floating-chat-group');
  var mainBtn = document.getElementById('main-chat-btn');
  var bubble = document.getElementById('chat-suggestion-bubble');
  var suggestions = [
    'Bạn cần tư vấn sức khỏe?',
    'Chat với AI để được hỗ trợ!',
    'Kết nối Zalo, Facebook dễ dàng!',
    'Đặt câu hỏi cho chuyên gia!',
    'Nhận tư vấn miễn phí ngay!',
    'Bạn muốn đặt lịch khám?',
    'Hỏi đáp nhanh với AI!',
    'Hỗ trợ 24/7, click để chat!'
  ];
  function showBubble() {
    var msg = suggestions[Math.floor(Math.random()*suggestions.length)];
    bubble.textContent = msg;
    bubble.style.display = 'block';
    setTimeout(function(){ bubble.style.display = 'none'; }, 4000);
  }
  // Hiện bubble mỗi 15s
  setInterval(showBubble, 15000);
  // Hiện ngay khi load lần đầu
  setTimeout(showBubble, 2000);
  mainBtn.onclick = function(e) {
    e.stopPropagation();
    group.classList.toggle('open');
    mainBtn.classList.remove('animate-glow');
  };
  // Đóng khi click ngoài
  document.addEventListener('click', function(e) {
    if (!group.contains(e.target)) group.classList.remove('open');
  });
})();
</script> 