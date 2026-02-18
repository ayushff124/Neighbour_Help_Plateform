<?php
require 'inc/config.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $area = trim($_POST['area'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (!$name || !$email || !$area || !$password) {
        $errors[] = 'Please fill required fields.';
    }
    if ($password !== $password2) $errors[] = 'Passwords do not match.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Email already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name,email,phone,area,password) VALUES (?,?,?,?,?)");
            $stmt->execute([$name,$email,$phone,$area,$hash]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            header('Location: community.php');
            exit;
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register - Neighborhood Help</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">
  <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
    <h1 class="text-xl font-semibold mb-4">Register</h1>
    <?php if($errors): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <?php foreach($errors as $err) echo "<div>".e($err)."</div>"; ?>
      </div>
    <?php endif; ?>
    <form method="post">
      <label class="block mb-2">Name<input name="name" class="w-full border p-2 rounded" required></label>
      <label class="block mb-2">Email<input name="email" type="email" class="w-full border p-2 rounded" required></label>
      <label class="block mb-2">Phone<input name="phone" class="w-full border p-2 rounded"></label>
      <label class="block mb-2">Area<select name="area" class="w-full border p-2 rounded" required>
        <option value="">Select area</option>
        <option>Central</option>
        <option>North</option>
        <option>South</option>
        <option>East</option>
        <option>West</option>
      </select></label>
      <label class="block mb-2">Password<input name="password" type="password" class="w-full border p-2 rounded" required></label>
      <label class="block mb-4">Confirm Password<input name="password2" type="password" class="w-full border p-2 rounded" required></label>
      <button class="w-full bg-blue-600 text-white p-2 rounded">Register</button>
    </form>
    <p class="mt-3 text-sm">Already have account? <a href="login.php" class="text-blue-600">Login</a></p>
  </div>
</body>
</html>
