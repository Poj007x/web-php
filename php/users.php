<?php
session_start();

// 1. Security Check: Is the user an admin?
if (!isset($_SESSION['custid']) || $_SESSION['status'] !== 'admin') {
    header("Location: ../login.php"); 
    exit();
}

// 2. Connect to Database
include '../connect.php';

$message = "";
$error = "";

// --- HANDLE FORM SUBMISSIONS ---

// A. Create New User
if (isset($_POST['create_user'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $fullname = mysqli_real_escape_string($connect, $_POST['fullname']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);

    // Check if username exists
    $check = mysqli_query($connect, "SELECT * FROM customers2 WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username already exists!";
    } else {
        $sql = "INSERT INTO customers2 (username, password, fullname, phone, status) VALUES ('$username', '$password', '$fullname', '$phone', '$status')";
        if (mysqli_query($connect, $sql)) {
            $message = "User created successfully!";
        } else {
            $error = "Error creating user: " . mysqli_error($connect);
        }
    }
}

// B. Delete User
if (isset($_POST['delete_user'])) {
    $id_to_delete = $_POST['custid_to_delete'];
    
    // Prevent deleting yourself
    if ($id_to_delete == $_SESSION['custid']) {
        $error = "You cannot delete your own account while logged in.";
    } else {
        $sql = "DELETE FROM customers2 WHERE custid = '$id_to_delete'";
        if (mysqli_query($connect, $sql)) {
            $message = "User deleted successfully.";
        } else {
            $error = "Error deleting user: " . mysqli_error($connect);
        }
    }
}

// C. Update Permission/Status
if (isset($_POST['update_permission'])) {
    $id_to_edit = $_POST['custid_to_edit'];
    $new_status = mysqli_real_escape_string($connect, $_POST['new_status']);

    $sql = "UPDATE customers2 SET status='$new_status' WHERE custid='$id_to_edit'";
    if (mysqli_query($connect, $sql)) {
        $message = "Permissions updated successfully.";
    } else {
        $error = "Error updating permission: " . mysqli_error($connect);
    }
}

// --- FETCH DATA ---
// We need 'custid' and 'status' now as well
$sql = "SELECT custid, username, fullname, phone, status FROM customers2";
$result = mysqli_query($connect, $sql);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
  body { padding-top: 1.5rem; background-color:#f8f9fa; }
  .card { max-width: 1200px; margin: 0 auto; }
  .status-badge { font-size: 0.85em; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">👑 Admin Panel</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">

  <!-- Feedback Messages -->
  <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $message; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>
  <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $error; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="card-title mb-0">User Management</h2>
        <div>
            <!-- Add User Button -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fa-solid fa-plus"></i> Create New User
            </button>
            <a href="index.php" class="btn btn-secondary">Back</a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Full Name</th>
              <th>Phone</th>
              <th>Permission (Status)</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo $row['custid']; ?></td>
              <td><?php echo htmlspecialchars($row['username']); ?></td>
              <td><?php echo htmlspecialchars($row['fullname']); ?></td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
              <td>
                <?php if($row['status'] === 'admin'): ?>
                    <span class="badge bg-danger status-badge">Admin</span>
                <?php else: ?>
                    <span class="badge bg-primary status-badge">User</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <!-- Edit Permission Button -->
                <button type="button" class="btn btn-sm btn-warning me-1" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal<?php echo $row['custid']; ?>">
                    <i class="fa-solid fa-key"></i> Perms
                </button>

                <!-- Delete Button -->
                <button type="button" class="btn btn-sm btn-danger" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteModal<?php echo $row['custid']; ?>">
                    <i class="fa-solid fa-trash"></i>
                </button>
              </td>
            </tr>

            <!-- Edit Permission Modal (Unique per row) -->
            <div class="modal fade" id="editModal<?php echo $row['custid']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Permission for <?php echo htmlspecialchars($row['username']); ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="custid_to_edit" value="<?php echo $row['custid']; ?>">
                      <div class="mb-3">
                        <label class="form-label">Status Level</label>
                        <select name="new_status" class="form-select">
                            <option value="user" <?php if($row['status'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="admin" <?php if($row['status'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" name="update_permission" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Delete Confirmation Modal (Unique per row) -->
            <div class="modal fade" id="deleteModal<?php echo $row['custid']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST">
                    <div class="modal-header">
                      <h5 class="modal-title text-danger">Confirm Delete</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($row['fullname']); ?></strong>?</p>
                      <p class="text-danger small">This action cannot be undone.</p>
                      <input type="hidden" name="custid_to_delete" value="<?php echo $row['custid']; ?>">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" name="delete_user" class="btn btn-danger">Delete User</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Create User Modal (Shared) -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Create New User</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Permission Level</label>
            <select name="status" class="form-select">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" name="create_user" class="btn btn-success">Create User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>