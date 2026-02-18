<?php
require 'inc/config.php';
require 'inc/auth.php';
require_login();
$user = current_user();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $area = trim($_POST['area'] ?? $user['area']);
    $location = trim($_POST['location'] ?? '');

    if (!$title || !$area) $errors[] = 'Title and area required.';
    if (!$location) $errors[] = 'Location required.';

    $imageName = null;
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['png','jpg','jpeg','gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $errors[] = 'Invalid image type.';
        } else {
            $imageName = uniqid() . '.' . $ext;
            $target = __DIR__ . '/assets/uploads/' . $imageName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $errors[] = 'Failed to upload image.';
            }
        }
    }

    if (empty($errors)) {
        // PDO INSERT statement with correct columns and values
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, description, image, area, location) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user['id'], $title, $description, $imageName, $area, $location]);
        header('Location: community.php');
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>New Post - Neighborhood Help</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
  <nav class="bg-white shadow p-4 flex justify-between">
    <div><a href="community.php" class="font-bold">Neighborhood Help</a></div>
    <div>
      <?php if($user): ?>
        <span class="mr-4">Hi, <?php echo e($user['name']); ?></span>
        <a href="logout.php" class="text-red-600">Logout</a>
      <?php endif; ?>
    </div>
  </nav>
  <main class="p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Create a new problem post</h2>
    <?php if($errors): ?>
      <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <?php foreach($errors as $er) echo e($er).'<br>'; ?>
      </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="bg-white p-4 rounded shadow">
      <label class="block mb-2">Title
        <input name="title" class="w-full border p-2 rounded" required>
      </label>

      <label class="block mb-2">Description
        <textarea name="description" class="w-full border p-2 rounded" rows="4"></textarea>
      </label>

      <label class="block mb-2">Area
        <select name="area" class="w-full border p-2 rounded" required>
          <option value="<?php echo e($user['area']); ?>"><?php echo e($user['area']); ?> (Your area)</option>
          <option>Central</option><option>North</option><option>South</option><option>East</option><option>West</option>
        </select>
      </label>

      <label class="block mb-2">Location
        <input type="text" name="location" placeholder="Enter location" class="w-full border p-2 rounded" required>
      </label>

      <label class="block mb-2">Image
        <input type="file" name="image" accept="image/*" class="w-full">
      </label>

      <button class="bg-green-600 text-white p-2 rounded mt-4">Post</button>
    </form>
  </main>
</body>
</html>
