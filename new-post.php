<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pievienot komentāru</title>
</head>
<body>
    <h1>Pievienot komentāru</h1>

    <!-- Form to submit name and comment -->
    <form action="poopwars.php" method="POST">
        <label for="name">Vārds:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="comment">Komentārs:</label><br>
        <textarea id="comment" name="comment" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" value="Pievienot komentāru">
    </form>

    <hr>

    <h2>Visi komentāri:</h2>
</body>
</html>

