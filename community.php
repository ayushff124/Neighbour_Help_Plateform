<?php
require 'inc/config.php';
$user = current_user();
$filter_area = $_GET['area'] ?? 'all';
if ($filter_area === 'all') {
    $stmt = $pdo->query("SELECT p.*, u.name FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC");
} else {
    $stmt = $pdo->prepare("SELECT p.*, u.name FROM posts p JOIN users u ON p.user_id = u.id WHERE p.area = ? ORDER BY p.created_at DESC");
    $stmt->execute([$filter_area]);
}
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Neighborhood Help - Feed</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
  <nav class="bg-white shadow p-4 flex justify-between items-center">
    <div class="flex items-center gap-4">
      <a href="community.php" class="font-bold text-lg">Neighborhood Help</a>
      <a href="new_post.php" class="bg-blue-600 text-white px-3 py-1 rounded">New Post</a>
    </div>
    <div>
      <?php if($user): ?>
        <span class="mr-4">Hi, <?php echo e($user['name']); ?> (<?php echo e($user['area']); ?>)</span>
        <a href="logout.php" class="text-red-600">Logout</a>
      <?php else: ?>
        <a href="login.php" class="mr-3">Login</a>
        <a href="register.php" class="text-blue-600">Register</a>
      <?php endif; ?>
    </div>
  </nav>

  <div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-semibold">Community Feed</h2>
      <form method="get" class="flex items-center gap-2">
        <select name="area" onchange="this.form.submit()" class="border p-2 rounded">
          <option value="all" <?php if($filter_area=='all') echo 'selected'; ?>>All areas</option>
          <option value="Central" <?php if($filter_area=='Central') echo 'selected'; ?>>Central</option>
          <option value="North" <?php if($filter_area=='North') echo 'selected'; ?>>North</option>
          <option value="South" <?php if($filter_area=='South') echo 'selected'; ?>>South</option>
          <option value="East" <?php if($filter_area=='East') echo 'selected'; ?>>East</option>
          <option value="West" <?php if($filter_area=='West') echo 'selected'; ?>>West</option>
        </select>
      </form>
    </div>

    <?php if(empty($posts)): ?>
      <div class="bg-white p-4 rounded shadow">No posts found.</div>
    <?php endif; ?>

    <div class="space-y-4">
      <?php foreach($posts as $p): ?>
        <div class="bg-white p-4 rounded shadow">
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-lg font-semibold"><?php echo e($p['title']); ?></h3>
              <div class="text-sm text-gray-600">Posted by <?php echo e($p['name']); ?> — <?php echo e($p['area']); ?> — <?php echo e($p['created_at']); ?></div>
            </div>
            <div class="text-sm px-3 py-1 rounded <?php
              if($p['status']=='solved') echo 'bg-green-100 text-green-700';
              elseif($p['status']=='in_progress') echo 'bg-yellow-100 text-yellow-700';
              else echo 'bg-gray-100 text-gray-700';
            ?>"><?php echo e(ucfirst($p['status'])); ?></div>
          </div>
          <p class="mt-3"><?php echo nl2br(e($p['description'])); ?></p>
          <?php if($p['image']): ?>
            <div class="mt-3">
              <img src="assets/uploads/<?php echo e($p['image']); ?>" alt="" class="max-h-64 object-contain rounded">
            </div>
          <?php endif; ?>
          <div class="mt-3 flex gap-2">
            <a href="view_post.php?id=<?php echo $p['id']; ?>" class="text-blue-600">View</a>
            <?php if($user && $user['role']=='admin'): ?>
              <a href="admin.php?id=<?php echo $p['id']; ?>" class="text-orange-600">Manage</a>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
