<?php
require 'inc/config.php';
require 'inc/auth.php';
$user = current_user();
$post_id = $_GET['id'] ?? null;
if (!$post_id) {
    header('Location: index.php');
    exit;
}
$stmt = $pdo->prepare("SELECT p.*, u.name, u.area as user_area FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$post) { echo "Post not found"; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment']) && $user) {
    $c = trim($_POST['comment']);
    $stmt = $pdo->prepare("INSERT INTO comments (post_id,user_id,comment) VALUES (?,?,?)");
    $stmt->execute([$post_id,$user['id'],$c]);
    header('Location: view_post.php?id=' . $post_id);
    exit;
}

$cmts = $pdo->prepare("SELECT c.*, u.name FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.created_at DESC");
$cmts->execute([$post_id]);
$comments = $cmts->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php echo e($post['title']); ?> - Neighborhood Help</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
  <div class="max-w-3xl mx-auto p-6">
    <a href="community.php" class="text-blue-600">&larr; Back</a>
    <div class="bg-white p-4 rounded shadow mt-4">
      <h1 class="text-2xl font-semibold"><?php echo e($post['title']); ?></h1>
      <div class="text-sm text-gray-600">By <?php echo e($post['name']); ?> — <?php echo e($post['area']); ?> — <?php echo e($post['created_at']); ?></div>
      <div class="mt-3"><?php echo nl2br(e($post['description'])); ?></div>
      <?php if($post['image']): ?>
        <div class="mt-3"><img src="assets/uploads/<?php echo e($post['image']); ?>" class="max-h-96 object-contain rounded"></div>
      <?php endif; ?>
      <div class="mt-4">
        <strong>Status:</strong> <span class="px-2 py-1 rounded <?php if($post['status']=='solved') echo 'bg-green-100 text-green-700'; else echo 'bg-gray-100 text-gray-700'; ?>"><?php echo e($post['status']); ?></span>
      </div>
      <?php if(!empty($post['location'])): ?>
        <div class="mt-4">
          <strong>Location:</strong> <span class="text-gray-700"><?php echo e($post['location']); ?></span>
        </div>
      <?php endif; ?>
    </div>

    <div class="mt-6">
      <h3 class="font-semibold">Comments</h3>
      <?php if($user): ?>
        <form method="post" class="mt-2">
          <textarea name="comment" class="w-full border p-2 rounded" rows="3" required></textarea>
          <button class="mt-2 bg-blue-600 text-white px-3 py-1 rounded">Add Comment</button>
        </form>
      <?php else: ?>
        <p class="text-sm">Please <a href="login.php" class="text-blue-600">login</a> to comment.</p>
      <?php endif; ?>

      <div class="mt-4 space-y-3">
        <?php foreach($comments as $c): ?>
          <div class="bg-white p-3 rounded shadow">
            <div class="text-sm text-gray-600"><?php echo e($c['name']); ?> — <?php echo e($c['created_at']); ?></div>
            <div class="mt-1"><?php echo e($c['comment']); ?></div>
          </div>
        <?php endforeach; ?>
        <?php if(empty($comments)): ?><div class="text-gray-600">No comments yet.</div><?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
