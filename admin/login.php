<?php
session_start();
require_once '../db_connect.php';
$error = '';
   
// $password = 'admin';
// echo password_hash($password, PASSWORD_DEFAULT);
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$conn || $conn->connect_error) {
        $error = 'Database connection error.';
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM admin_users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hash);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $id;
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
        }
        $stmt->close();
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
      body { min-height:100vh; background: linear-gradient(130deg,#fff6e6 0,#ffead9 100%); display:flex; align-items:center; justify-content:center; }
      .login-wrapper { width:100vw;height:100vh;display:flex;justify-content:center;align-items:center; }
      .login-card {
        background: #fff;
        box-shadow: 0 10px 24px #ff850033;
        border-radius: 16px;
        padding: 42px 38px 34px 38px;
        min-width: 330px;
        max-width: 95vw;
        text-align: center;
        position:relative;
        z-index:2;
      }
      .login-card .avatar {
        display:block;
        margin: 0 auto 22px auto;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        box-shadow: 0 1.5px 8px #ff850030;
        background: #ff8500;
      }
      .login-card h2 {
        margin-top: 5px; font-weight:700; color:#ff8500; font-size:1.35em; margin-bottom:17px;
      }
      .login-card input {
        padding: 12px;
        margin-bottom: 16px;
        border-radius: 7px;
        border: 1.8px solid #ffd7ac;
        font-size: 1.08em;
        background: #fcfdff;
        width: 100%;
        box-sizing: border-box;
        transition:border 0.17s;
      }
      .login-card input:focus { border: 1.8px solid #ff8500; background:#fff7ee; }
      .login-card button {
        width: 100%;
        background: linear-gradient(90deg,#ff8500 0,#ffae39 50%,#ff8500 100%);
        color: #fff;
        font-size: 1.13em;
        font-weight: 700;
        border: none;
        border-radius: 28px;
        padding: 13px 0;
        margin-top: 5px;
        margin-bottom: 17px;
        cursor: pointer;
        box-shadow: 0 3px 21px #ff850026, 0 2px 6px #ff850018;
        letter-spacing: 0.03em;
        transition: background 0.22s, transform 0.17s, box-shadow 0.2s;
        outline: none;
      }
      .login-card button:hover, .login-card button:active {
        background: linear-gradient(90deg,#ffb066 0,#ff8500 100%);
        transform: scale(1.045); box-shadow: 0 6px 32px #ff850035;
      }
      .login-card .error {
        color: #e84c3d; background: #fff2f2; border-radius:8px; margin-bottom:12px; padding:7px 0;
        font-weight:600;
      }
      @media (max-width: 540px) {
        .login-card { padding: 21px 7vw; min-width: unset; }
      }
    </style>
</head>
<body>
  <div class="login-wrapper">
    <form method="post" class="login-card">
      <img src="https://ui-avatars.com/api/?name=BV&background=ff8500&color=fff&rounded=true&size=70" alt="Admin" class="avatar">
      <h2>Admin Login</h2>
      <?php if ($error): ?>
        <div class="error"> <?= htmlspecialchars($error) ?> </div>
      <?php endif; ?>
      <input name="username" required placeholder="Username" autocomplete="username">
      <input name="password" type="password" required placeholder="Password" autocomplete="current-password">
      <button type="submit">Sign In</button>
      <div style="font-size:0.98em;color:#bbb;margin-top:8px;">Contact the site owner to create your account.</div>
    </form>
  </div>
</body>
</html>
