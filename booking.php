  <?php
  include 'includes/db.php';
  require 'doctors.php';

  $err = '';
  $success = '';
  $is_logged_in = isset($_SESSION['user_id']);
  $user_id = $is_logged_in ? $_SESSION['user_id'] : null;

  // Khởi tạo mặc định
  $patient_name = $appointment_date = $appointment_time = $specialty = $doctor_name = $note = '';
  $valid_specialties = ['Tiêu hóa', 'Hô hấp', 'Tim mạch', 'Thần kinh', 'Da liễu'];
  $valid_doctors = array_column($doctors, 'name');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_name     = trim($_POST['patient_name'] ?? '');
    $appointment_date = trim($_POST['appointment_date'] ?? '');
    $appointment_time = trim($_POST['appointment_time'] ?? '');
    $specialty        = trim($_POST['specialty'] ?? '');
    $doctor_name      = trim($_POST['doctor'] ?? '');
    $note             = trim($_POST['note'] ?? '');

    if ($is_logged_in && isset($_SESSION['full_name'])) {
      $patient_name = $_SESSION['full_name'];
    }

    $today = date('Y-m-d');
    $time_pattern = '/^\d{2}:\d{2}$/';
    $name_pattern = '/^[\p{L}\s]+$/u';

    if (empty($patient_name) || empty($appointment_date) || empty($appointment_time) || empty($specialty)) {
      $err = "❗ Vui lòng điền đầy đủ các trường bắt buộc.";
    } elseif (!preg_match($name_pattern, $patient_name)) {
      $err = "❗ Tên bệnh nhân chỉ được chứa chữ cái và khoảng trắng.";
    } elseif (strtotime($appointment_date) < strtotime($today)) {
      $err = "❗ Ngày hẹn không được nhỏ hơn ngày hiện tại.";
    } elseif (strtotime($appointment_date) == strtotime($today) && strtotime($appointment_time) < strtotime(date('H:i'))) {
      $err = "❗ Giờ hẹn không được nhỏ hơn giờ hiện tại.";
    } elseif (!preg_match($time_pattern, $appointment_time)) {
      $err = "❗ Giờ hẹn không đúng định dạng (HH:mm).";
    } elseif ($appointment_time < '07:00' || $appointment_time > '18:00') {
      $err = "❗ Giờ hẹn chỉ được trong khoảng từ 07:00 đến 18:00.";
    } elseif (!in_array($specialty, $valid_specialties)) {
      $err = "❗ Chuyên khoa không hợp lệ.";
    } elseif ($doctor_name && !in_array($doctor_name, $valid_doctors)) {
      $err = "❗ Bác sĩ không hợp lệ.";
    }

    if (!$err && $doctor_name) {
      $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE appointment_date = ? AND appointment_time = ? AND doctor_name = ?");
      $stmtCheck->execute([$appointment_date, $appointment_time, $doctor_name]);
      if ($stmtCheck->fetchColumn() > 0) {
        $err = "❗ Bác sĩ đã có lịch khám vào thời gian này. Vui lòng chọn giờ khác.";
      }
    }

    if (!$err) {
      try {
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, patient_name, appointment_date, appointment_time, specialty, doctor_name, note) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
          $user_id,
          $patient_name,
          $appointment_date,
          $appointment_time,
          $specialty,
          $doctor_name ?: null,
          $note ?: null
        ]);

        $success = "✅ Đặt lịch thành công!";
        $patient_name = $appointment_date = $appointment_time = $specialty = $doctor_name = $note = '';
      } catch (Exception $e) {
        $err = "❌ Lỗi khi lưu dữ liệu: " . $e->getMessage();
      }
    }
  }
  ?>

  <!-- Modal -->
  <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg">
        <form method="POST">
          <!-- Modal Header -->
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="bookingModalLabel">
              <i class="fas fa-calendar-plus me-2"></i>Đặt lịch khám bệnh
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body px-4 py-3">
            <div class="row g-3">
              <!-- Tên bệnh nhân -->
              <div class="col-md-6">
                <label for="patientName" class="form-label fw-semibold">Tên bệnh nhân <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="patientName" name="patient_name"
                  value="<?= htmlspecialchars($is_logged_in && isset($_SESSION['full_name']) ? $_SESSION['full_name'] : ($patient_name ?? '')) ?>"
                  <?= $is_logged_in ? 'disabled' : '' ?> required>
              </div>

              <!-- Ngày hẹn -->
              <div class="col-md-3">
                <label for="appointmentDate" class="form-label fw-semibold">Ngày hẹn <span class="text-danger">*</span></label>
                <div class="input-group" id="appointmentDatePicker" data-td-target-input="nearest" data-td-target-toggle="nearest">
                  <input type="text" class="form-control" data-td-target="#appointmentDatePicker"
                    id="appointmentDate" name="appointment_date" placeholder="Chọn ngày"
                    value="<?= htmlspecialchars($appointment_date ?? '') ?>" required readonly />
                  <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#appointmentDatePicker">
                    <i class="fa-solid fa-calendar-day"></i>
                  </span>
                </div>
              </div>

              <!-- Giờ hẹn -->
              <div class="col-md-3">
                <label for="appointmentTime" class="form-label fw-semibold">Giờ hẹn <span class="text-danger">*</span></label>
                <div class="input-group" id="appointmentTimePicker" data-td-target-input="nearest" data-td-target-toggle="nearest">
                  <input type="text" class="form-control" data-td-target="#appointmentTimePicker"
                    id="appointmentTime" name="appointment_time" placeholder="Chọn giờ"
                    value="<?= htmlspecialchars($appointment_time ?? '') ?>" required readonly />
                  <span class="input-group-text" data-td-toggle="datetimepicker" data-td-target="#appointmentTimePicker">
                    <i class="fa-solid fa-clock"></i>
                  </span>
                </div>
              </div>
              <!-- Chuyên khoa -->
              <div class="col-md-6">
                <label for="specialty" class="form-label fw-semibold">Chuyên khoa <span class="text-danger">*</span></label>
                <select class="form-select" id="specialty" name="specialty" required>
                  <option value="">-- Chọn chuyên khoa --</option>
                  <?php foreach ($valid_specialties as $spec): ?>
                    <option value="<?= $spec ?>" <?= ($specialty == $spec) ? 'selected' : '' ?>>
                      <?= $spec ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Bác sĩ -->
              <div class="col-md-6">
                <label for="doctor" class="form-label fw-semibold">Bác sĩ (nếu muốn)</label>
                <select class="form-select" id="doctor" name="doctor">
                  <option value="">-- Chọn bác sĩ --</option>
                  <?php foreach ($doctors as $doc): ?>
                    <option value="<?= $doc['name'] ?>" data-specialty="<?= $doc['specialty'] ?>"
                      <?= ($doctor_name == $doc['name']) ? 'selected' : '' ?>>
                      <?= $doc['name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Ghi chú -->
              <div class="col-12">
                <label for="note" class="form-label fw-semibold">Ghi chú</label>
                <textarea class="form-control" id="note" name="note" rows="3"
                  placeholder="Nhập nội dung nếu có"><?= htmlspecialchars($note ?? '') ?></textarea>
              </div>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer bg-light px-4 py-3">
            <button type="submit" class="btn btn-submit w-100 py-2 fs-5 d-flex align-items-center justify-content-center" id="submitBtn">
              <span class="spinner-border spinner-border-sm me-2 d-none" role="status" id="spinner" aria-hidden="true"></span>
              <i class="fas fa-check-circle me-2"></i> Xác nhận đặt lịch
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
 
  <!-- Tempus Dominus JS -->
  <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.5/dist/js/tempus-dominus.min.js"></script>
  <script>

    const appointmentDatePicker = new tempusDominus.TempusDominus(
      document.getElementById('appointmentDatePicker'), {
        display: {
          components: {
            calendar: true,
            date: true,
            month: true,
            year: true,
            decades: true,
            clock: false
          },
          buttons: {
            today: true,
            clear: true,
            close: true
          }
        },
        restrictions: {
          minDate: today
        },
        localization: {
          format: 'yyyy-MM-dd'
        }
      }
    );

    // Time picker: giờ hẹn
    const appointmentTimePicker = new tempusDominus.TempusDominus(
      document.getElementById('appointmentTimePicker'), {
        display: {
          components: {
            calendar: false,
            date: false,
            clock: true,
            hours: true,
            minutes: true,
            seconds: false
          },
          buttons: {
            today: false,
            clear: true,
            close: true
          }
        },
        restrictions: {
          minTime: new Date(0, 0, 0, 7, 0), // 07:00
          maxTime: new Date(0, 0, 0, 18, 0) // 18:00
        },
        localization: {
          format: 'HH:mm'
        },
        defaultDate: new Date(0, 0, 0, 8, 0)
      }
    );

    // Lọc bác sĩ theo chuyên khoa
    const specSelect = document.getElementById('specialty');
    const docSelect = document.getElementById('doctor');
    specSelect.addEventListener('change', () => {
      const selected = specSelect.value;
      docSelect.value = '';
      docSelect.querySelectorAll('option').forEach(opt => {
        opt.hidden = opt.value && opt.dataset.specialty !== selected;
      });
    });

    // Spinner khi submit
    const form = document.querySelector('#bookingModal form');
    const submitBtn = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');
    form.addEventListener('submit', () => {
      spinner.classList.remove('d-none');
      submitBtn.disabled = true;
    });
  </script>