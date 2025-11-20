<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 30rem;">
        <h3 class="text-center mb-3">เข้าสู่ระบบ</h3>

        <?php
        if (isset($_GET['register']) && $_GET['register'] == 'success') {
            echo '<div class="alert alert-success text-center">สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ</div>';
        }
        if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
            echo '<div class="alert alert-danger text-center">ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</div>';
        }
        ?>

        <form method="POST" action="login_check.php">
            <div class="mb-3">
                <label class="form-label">ชื่อผู้ใช้</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">เข้าสู่ระบบ</button>
        </form>

        <div class="text-center mt-3">
            <p>ยังไม่มีบัญชี?</p>
            <a href="register.php" class="btn btn-outline-success w-100">สมัครสมาชิก</a>
        </div>
    </div>
</div>

</body>
</html>