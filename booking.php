<?php

include 'includes/db.php';

$err = '';
$success = '';

require 'doctors.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Lấy dữ liệu POST, trim để tránh khoảng trắng
  $patient_name = trim($_POST['patient_name'] ?? '');
  $appointment_date = trim($_POST['appointment_date'] ?? '');
  $appointment_time = trim($_POST['appointment_time'] ?? '');
  $specialty = trim($_POST['specialty'] ?? '');
  $doctor_name = trim($_POST['doctor'] ?? '');
  $note = trim($_POST['note'] ?? '');


  $valid_specialties = ['Tiêu hóa', 'Hô hấp', 'Tim mạch', 'Thần kinh', 'Da liễu'];
  $valid_doctors = array_column($doctors, 'name');
  // Validate đơn giản
  if (!$patient_name || !$appointment_date || !$appointment_time || !$specialty) {
    $error_message = "Vui lòng điền đầy đủ các trường bắt buộc.";
  } elseif (!preg_match('/^[\p{L}\s]+$/u', $patient_name)) {
    $error_message = "Tên bệnh nhân chỉ được chứa chữ cái và khoảng trắng.";
  } elseif (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
    $error_message = "Ngày hẹn không được nhỏ hơn ngày hiện tại.";
  } elseif (!preg_match('/^\d{2}:\d{2}$/', $appointment_time)) {
    $error_message = "Giờ hẹn không hợp lệ.";
  } elseif (!in_array($specialty, $valid_specialties)) {
    $error_message = "Chuyên khoa không hợp lệ.";
  } elseif ($doctor_name && !in_array($doctor_name, $valid_doctors)) {
    $error_message = "Bác sĩ không hợp lệ.";
  } else {
    try {
      $stmt = $pdo->prepare("INSERT INTO bookings (patient_name, appointment_date, appointment_time, specialty, doctor_name, note) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->execute([$patient_name, $appointment_date, $appointment_time, $specialty, $doctor_name ?: null, $note ?: null]);
      $success_message = "✅ Đặt lịch thành công!";
      // Clear fields
      $patient_name = $appointment_date = $appointment_time = $specialty = $doctor_name = $note = '';
    } catch (Exception $e) {
      $error_message = "❌ Lỗi khi lưu dữ liệu: " . $e->getMessage();
    }
  }
}

?>

<div class="modal fade " id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="bookingModalLabel">
            <i class="fas fa-calendar-plus me-2"></i>Đặt lịch khám bệnh
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
        </div>

        <div class="modal-body">
          <?php if ($err): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
          <?php elseif ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
          <?php elseif (isset($error_message)): ?>
            <div class="alert alert-warning"><?= htmlspecialchars($error_message) ?></div>
          <?php endif; ?>
          <div class="row g-3">
            <!-- Tên bệnh nhân -->
            <div class="col-md-6">
              <label for="patientName" class="form-label fw-semibold">
                <i class="fas fa-user me-1"></i>Tên bệnh nhân
              </label>
              <input type="text" class="form-control" id="patientName" name="patient_name" required
                value="<?= isset($patient_name) ? htmlspecialchars($patient_name) : '' ?>">
            </div>

            <!-- Ngày hẹn -->
            <div class="col-md-3">
              <label for="appointmentDate" class="form-label fw-semibold">
                <i class="fas fa-calendar-day me-1"></i>Ngày hẹn
              </label>
              <input type="date" class="form-control" id="appointmentDate" name="appointment_date"
                min="<?= date('Y-m-d') ?>" required
                value="<?= isset($appointment_date) ? htmlspecialchars($appointment_date) : date('Y-m-d') ?>">
            </div>

            <!-- Giờ hẹn -->
            <div class="col-md-3">
              <label for="appointmentTime" class="form-label fw-semibold">
                <i class="fas fa-clock me-1"></i>Giờ hẹn
              </label>
              <input type="time" class="form-control" id="appointmentTime" name="appointment_time" required
                value="<?= isset($appointment_time) ? htmlspecialchars($appointment_time) : '' ?>">
            </div>

            <!-- Chuyên khoa -->
            <div class="col-md-6">
              <label for="specialty" class="form-label fw-semibold">
                <i class="fas fa-stethoscope me-1"></i>Chuyên khoa
              </label>
              <select class="form-select" id="specialty" name="specialty" required>
                <option value="">-- Chọn chuyên khoa --</option>
                <?php
                $specialties = ['Tiêu hóa', 'Hô hấp', 'Tim mạch', 'Thần kinh', 'Da liễu'];
                foreach ($specialties as $spec): ?>
                  <option value="<?= htmlspecialchars($spec) ?>" <?= (isset($specialty) && $specialty === $spec) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($spec) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Bác sĩ -->
            <!-- Bác sĩ -->
            <div class="col-md-6">
              <label for="doctor" class="form-label fw-semibold">
                <i class="fas fa-user-md me-1"></i>Bác sĩ (tuỳ chọn)
              </label>
              <select class="form-select" id="doctor" name="doctor">
                <option value="">-- Chọn bác sĩ --</option>
                <?php foreach ($doctors as $doc): ?>
                  <option value="<?= htmlspecialchars($doc['name']) ?>"
                    data-specialty="<?= htmlspecialchars($doc['specialty']) ?>"
                    <?= (isset($doctor_name) && $doctor_name === $doc['name']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($doc['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Ghi chú -->
            <div class="col-12">
              <label for="note" class="form-label fw-semibold">
                <i class="fas fa-note-sticky me-1"></i>Ghi chú thêm
              </label>
              <textarea class="form-control" id="note" name="note" rows="3"
                placeholder="Triệu chứng, yêu cầu đặc biệt..."><?= isset($note) ? htmlspecialchars($note) : '' ?></textarea>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-submit w-100 py-2 fs-5">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <i class="fas fa-check-circle me-1"></i>Xác nhận đặt lịch
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Lọc bác sĩ theo chuyên khoa
  document.getElementById('specialty').addEventListener('change', function() {
    const selectedDept = this.value;
    const doctorSelect = document.getElementById('doctor');
    const options = doctorSelect.querySelectorAll('option');

    doctorSelect.value = '';

    options.forEach(option => {
      if (option.value === '') {
        option.hidden = false;
        return;
      }
      if (selectedDept === '') {
        option.hidden = false;
      } else {
        option.hidden = option.dataset.specialty !== selectedDept;
      }
    });
  });
  document.querySelector('form').addEventListener('submit', function() {
    const spinner = this.querySelector('.spinner-border');
    if (spinner) spinner.classList.remove('d-none');
  });
  // Trigger sự kiện change để lọc bác sĩ khi tải trang (nếu đã chọn chuyên khoa)
  window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('specialty').dispatchEvent(new Event('change'));
  });
</script>