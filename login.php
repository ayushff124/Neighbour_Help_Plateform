<?php
require 'inc/config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT id,password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: community.php');
            exit;
        } else {
            $err = 'Invalid credentials.';
        }
    } else {
        $err = 'Enter email and password.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - Neighborhood Help</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
    <h1 class="text-xl font-semibold mb-4">Login</h1>
    <?php if($err): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?php echo e($err); ?></div>
    <?php endif; ?>
    <form method="post">
      <label class="block mb-2">Email<input name="email" type="email" class="w-full border p-2 rounded" required></label>
      <label class="block mb-4">Password<input name="password" type="password" class="w-full border p-2 rounded" required></label>
      <button class="w-full bg-blue-600 text-white p-2 rounded">Login</button>
    </form>
    <p class="mt-3 text-sm">Don't have account? <a href="register.php" class="text-blue-600">Register</a></p>
  </div>
</body>
</html>
