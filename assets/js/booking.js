document.addEventListener("DOMContentLoaded", function () {
  const phoneInput = document.getElementById("phone");
  phoneInput.addEventListener("input", () => {
    const phoneRegex = /^[0-9]{9,11}$/;
    if (!phoneRegex.test(phoneInput.value)) {
      phoneInput.setCustomValidity("Số điện thoại không hợp lệ (9–11 chữ số).");
    } else {
      phoneInput.setCustomValidity("");
    }
  });
  const dateInput = document.getElementById("date");
  const today = new Date().toISOString().split("T")[0];
  dateInput.setAttribute("min", today);
  dateInput.addEventListener("input", () => {
    if (dateInput.value < today) {
      dateInput.setCustomValidity("Ngày không được trước ngày hôm nay.");
    } else {
      dateInput.setCustomValidity("");
    }
  });
});
