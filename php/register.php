<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg rounded-4">
          <div class="card-body p-4">
            <h3 class="text-center mb-4">📝 ลงทะเบียนสมาชิก</h3>

            <form id="registerForm" action="register_save.php" method="POST">
              
              <div class="mb-3">
                <label for="username" class="form-label">ชื่อผู้ใช้ (Username)</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="กรอกชื่อผู้ใช้" required>
              </div>

              <div class="mb-3">
                <label for="fullname" class="form-label">ชื่อ-นามสกุล (Full Name)</label>
                <input type="text" class="form-control" id="fullname" name="full_name" placeholder="กรอกชื่อ-นามสกุล" required>
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="กรอกเบอร์โทรศัพท์" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">รหัสผ่าน (Password)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="กรอกรหัสผ่าน" required>
              </div>

              <div class="mb-3">
                <label for="confirm_password" class="form-label">ยืนยันรหัสผ่าน</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="กรอกยืนยันรหัสผ่าน" required>
                <div id="passwordFeedback" class="form-text text-danger d-none">รหัสผ่านไม่ตรงกัน</div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-success btn-lg">สมัครสมาชิก</button>
              </div>
              
              <div class="text-center mt-3">
                  <a href="login.php">มีบัญชีอยู่แล้ว? เข้าสู่ระบบ</a>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const form = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const feedback = document.getElementById('passwordFeedback');

    form.addEventListener('submit', function(event) {
      if (password.value !== confirmPassword.value) {
        event.preventDefault();
        feedback.classList.remove('d-none');
        confirmPassword.focus();
      } else {
        feedback.classList.add('d-none');
      }
    });
  </script>
</body>
</html>