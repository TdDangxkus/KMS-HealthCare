<?php
// session_start();
include 'includes/db.php';
require 'doctors.php';

$err = '';
$success = '';
$is_logged_in = isset($_SESSION['user_id']);
$user_id = $is_logged_in ? $_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $patient_name = trim($_POST['patient_name'] ?? '');
  $appointment_date = trim($_POST['appointment_date'] ?? '');
  $appointment_time = trim($_POST['appointment_time'] ?? '');
  $specialty = trim($_POST['specialty'] ?? '');
  $doctor_name = trim($_POST['doctor'] ?? '');
  $note = trim($_POST['note'] ?? '');

  if ($is_logged_in && isset($_SESSION['full_name'])) {
    $patient_name = $_SESSION['full_name'];
  }

  $valid_specialties = ['Tiêu hóa', 'Hô hấp', 'Tim mạch', 'Thần kinh', 'Da liễu'];
  $valid_doctors = array_column($doctors, 'name');
  $today = date('Y-m-d');
  $time_pattern = '/^\d{2}:\d{2}$/';
  $name_pattern = '/^[\p{L}\s]+$/u';

  if (empty($patient_name) || empty($appointment_date) || empty($appointment_time) || empty($specialty)) {
    $err = "❗ Vui lòng điền đầy đủ các trường bắt buộc.";
  } elseif (!preg_match($name_pattern, $patient_name)) {
    $err = "❗ Tên bệnh nhân chỉ được chứa chữ cái và khoảng trắng.";
  } elseif (strtotime($appointment_date) < strtotime($today)) {
    $err = "❗ Ngày hẹn không được nhỏ hơn ngày hiện tại.";
  } elseif (strtotime($appointment_date) == strtotime($today) && $appointment_time < date('H:i')) {
    $err = "❗ Giờ hẹn không được nhỏ hơn giờ hiện tại.";
  } elseif (!preg_match($time_pattern, $appointment_time)) {
    $err = "❗ Giờ hẹn không đúng định dạng (HH:mm).";
  } elseif ($appointment_time < '07:00' || $appointment_time > '18:00') {
    $err = "❗ Giờ hẹn chỉ được trong khoảng từ 07:00 đến 18:00.";
  } elseif (!in_array($specialty, $valid_specialties)) {
    $err = "❗ Chuyên khoa không hợp lệ.";
  } elseif ($doctor_name && !in_array($doctor_name, $valid_doctors)) {
    $err = "❗ Bác sĩ không hợp lệ.";
  } else {
    try {
      $stmt = $pdo->prepare("INSERT INTO bookings (user_id, patient_name, appointment_date, appointment_time, specialty, doctor_name, note) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([
        $user_id, // null nếu chưa login
        $patient_name,
        $appointment_date,
        $appointment_time,
        $specialty,
        $doctor_name ?: null,
        $note ?: null
      ]);
      $success = "✅ Đặt lịch thành công!";
      header('Location: index.php');
      // Reset lại form
      $patient_name = $appointment_date = $appointment_time = $specialty = $doctor_name = $note = '';
    } catch (Exception $e) {
      $err = "❌ Lỗi khi lưu dữ liệu: " . $e->getMessage();
      exit;
    }
  }
}  //    else {
//   // Kiểm tra trùng lịch hẹn nếu bác sĩ được chọn
//   if ($doctor_name) {
//     $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE appointment_date = ? AND appointment_time = ? AND doctor_name = ?");
//     $stmtCheck->execute([$appointment_date, $appointment_time, $doctor_name]);
//     if ($stmtCheck->fetchColumn() > 0) {
//       $err = "❗ Bác sĩ đã có lịch khám vào thời gian này. Vui lòng chọn giờ khác.";
//     }
//   }
// }
?>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
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
          <?php endif; ?>

          <div class="row g-3">
            <!-- Tên bệnh nhân -->
            <div class="col-md-6">
              <label for="patientName" class="form-label fw-semibold">
                <i class="fas fa-user me-1"></i>Tên bệnh nhân
              </label>

              <?php if (!$is_logged_in): ?>
                <input type="text" class="form-control" id="patientName" name="patient_name" required
                  value="<?= isset($patient_name) ? htmlspecialchars($patient_name) : '' ?>">
              <?php else: ?>
                <input type="text" class="form-control" id="patientName_display" value="<?= htmlspecialchars($_SESSION['full_name']) ?>" readonly>
                <input type="hidden" name="patient_name" value="<?= htmlspecialchars($_SESSION['full_name']) ?>">
              <?php endif; ?>
            </div>

            <!-- Ngày hẹn -->
            <div class="col-md-3">
              <label for="appointmentDate" class="form-label fw-semibold">
                <i class="fas fa-calendar-day me-1"></i>Ngày hẹn
              </label>
              <input type="date" class="form-control" id="appointmentDate" name="appointment_date" required
                value="<?= isset($appointment_date) ? htmlspecialchars($appointment_date) : date('Y-m-d') ?>">
            </div>

            <!-- Giờ hẹn -->
            <div class="col-md-3">
              <label for="appointmentTime" class="form-label fw-semibold">
                <i class="fas fa-clock me-1"></i>Giờ hẹn
              </label>
              <input type="time" class="form-control" id="appointmentTime" name="appointment_time" required
                min="07:00" max="18:00"
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
  // Đặt min ngày cho input date dựa trên thời gian máy client để tránh chọn ngày quá khứ
  const timeInput = document.getElementById('appointmentTime');
  const dateInput = document.getElementById('appointmentDate');
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');
  const minDate = `${yyyy}-${mm}-${dd}`;
  dateInput.min = minDate;
  // Nếu không có giá trị hoặc giá trị nhỏ hơn min, đặt lại giá trị ngày hiện tại
  if (!dateInput.value || dateInput.value < minDate) {
    dateInput.value = minDate;
  }

  timeInput.addEventListener('change', () => {
    if (timeInput.value < '07:00' || timeInput.value > '18:00') {
      alert('Giờ hẹn chỉ được trong khoảng từ 07:00 đến 18:00.');
      timeInput.value = '';
    }
  });

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

  // Kích hoạt lọc bác sĩ khi tải trang nếu đã chọn chuyên khoa
  window.addEventListener('DOMContentLoaded', () => {
    document.getElementById('specialty').dispatchEvent(new Event('change'));
  });

  // Hiển thị spinner khi submit form
  document.querySelector('form').addEventListener('submit', function() {
    const spinner = this.querySelector('.spinner-border');
    if (spinner) spinner.classList.remove('d-none');
  });
</script>