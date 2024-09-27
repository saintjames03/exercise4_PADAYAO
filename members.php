<?php
// Handle search
$members = [
  // Define your members here, e.g., ['name' => 'Raymart', 'age' => 21, 'comment' => []]
];

$searchQuery = '';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
  $searchQuery = htmlspecialchars($_GET['search']);
  // Filter members based on the search query
  $filteredMembers = array_filter($members, function ($member) use ($searchQuery) {
    return stripos($member['name'], $searchQuery) !== false;
  });
}

// Handle comments
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['member'])) {
  $comment = htmlspecialchars($_POST['comment']);
  $memberName = htmlspecialchars($_POST['member']);
  // Add the comment to the respective member
  foreach ($members as &$member) {
    if ($member['name'] == $memberName) {
      $member['comment'][] = $comment;
    }
  }
}
?>
<!DOCTYPE html>
<html>

  <head>
    <title>Member Search and Comments</title>
  </head>

  <body>
    <form method="GET">
      <input type="text" name="search" placeholder="Search members..." value="<?= $searchQuery ?>">
      <button type="submit">Search</button>
    </form>

    <div class="members">
      <?php foreach ($filteredMembers ?? $members as $member): ?>
        <h3><?= $member['name'] ?></h3>
        <h4><?= $member['age'] ?> Years Old</h4>
        <form method="POST">
          <textarea name="comment" placeholder="Add a comment"></textarea>
          <input type="hidden" name="member" value="<?= $member['name'] ?>">
          <button type="submit">Comment</button>
        </form>
        <div>
          <?php foreach ($member['comment'] ?? [] as $comm): ?>
            <p><?= $comm ?></p>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </body>

</html>