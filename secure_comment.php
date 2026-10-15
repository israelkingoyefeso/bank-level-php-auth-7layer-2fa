<?php
include 'config.php';

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS comments (id INT AUTO_INCREMENT PRIMARY KEY, text TEXT)");

if(isset($_POST['comment'])){
    // FIX 1: Prepared Statement stops SQL Injection
    $stmt = $conn->prepare("INSERT INTO comments (text) VALUES (?)");
    $stmt->bind_param("s", $_POST['comment']);
    $stmt->execute();
    echo "<p style='color:green'>✅ Comment saved securely!</p>";
}
?>
<form method="POST">
  Comment: <input name="comment" style="width:300px" placeholder="Try <script>alert(1)</script>">
  <button>Post</button>
</form>
<hr>
<h3>Comments:</h3>
<?php
$result = $conn->query("SELECT text FROM comments ORDER BY id DESC");
while($row=$result->fetch_assoc()){
  // FIX 2: htmlspecialchars stops XSS
  $safe_text = htmlspecialchars($row['text'], ENT_QUOTES, 'UTF-8');
  echo "<p>Comment: ".$safe_text."</p>";
}
?>