<?php
// Database connection details
$servername = "localhost"; 
$username = "new_username";    
$password = "new_password";    
$sql_store = "blog_12032025";  

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$sql_store", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to get posts and comments
    $sql = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, comments.comment_id, comments.author AS comment_author, comments.comment AS comment_content
            FROM posts
            LEFT JOIN comments ON posts.post_id = comments.post_id
            ORDER BY posts.created_at DESC, comments.created_at ASC";

    // Execute the query
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Group posts by post_id
    $posts = [];
    foreach ($results as $row) {
        $post_id = $row['post_id'];
        if (!isset($posts[$post_id])) {
            $posts[$post_id] = [
                'title' => $row['title'],
                'content' => $row['content'],
                'created_at' => $row['created_at'],
                'comments' => []
            ];
        }
        
        // If there is a comment, add it to the post
        if ($row['comment_id'] !== null) {
            $posts[$post_id]['comments'][] = [
                'comment_id' => $row['comment_id'],
                'author' => $row['comment_author'],
                'comment' => $row['comment_content']
            ];
        }
    }

    // Display posts and comments
    foreach ($posts as $post) {
        echo "<h2>" . htmlspecialchars($post['title']) . "</h2>";
        echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
        echo "<p><small>Posted on: " . $post['created_at'] . "</small></p>";

        if (count($post['comments']) > 0) {
            echo "<h3>Comments:</h3><ul>";
            foreach ($post['comments'] as $comment) {
                echo "<li><strong>" . htmlspecialchars($comment['author']) . ":</strong> " . htmlspecialchars($comment['comment']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No comments yet.</p>";
        }
        echo "<hr>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
