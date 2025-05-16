<?php
include 'components/connect.php';
session_start();

// Fetch users sorted by stars in descending order
$fetch_leaderboard = $conn->prepare("SELECT username, stars, score FROM users ORDER BY stars DESC, score DESC");
$fetch_leaderboard->execute();
$users = $fetch_leaderboard->fetchAll(PDO::FETCH_ASSOC);

// Function to determine trophy image based on stars
function getTrophy($stars) {
    if ($stars >= 126) {
        return "images/platinum.png";
    } elseif ($stars >= 100) {
        return "images/dimond.png";
    } elseif ($stars >= 75) {
        return "images/gold.png";
    } elseif ($stars >= 50) {
        return "images/silver.png";
    } elseif ($stars >= 25) {
        return "images/bronze.png";
    } else {
        return ""; // No trophy if below 25 stars
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <section class="flex">
        <h1 class="user">Leaderboard</h1>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="category.php">Category</a>
            <a href="profile.php">Profile</a>
        </nav>
    </section>
</header>

<section id="leaderboard">
    <h2>Top Players</h2>

    <div id="leaderboard-container">
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>Score</th>
                    <th>Stars</th>
                    <th>Trophy</th>
                </tr>
            </thead>
            <tbody id="leaderboard-body">
                <?php
                $rank = 1;
                foreach ($users as $user) {
                    $trophy = getTrophy($user['stars']);
                    echo "<tr>
                            <td>{$rank}</td>
                            <td>" . htmlspecialchars($user['username']) . "</td>
                            <td>" . htmlspecialchars($user['score']) . "</td>
                            <td>" . str_repeat("⭐", min(5, $user['stars'])) . " ({$user['stars']})</td>
                            <td>";
                    if (!empty($trophy)) {
                        echo "<img src='{$trophy}' alt='Trophy' width='50'>";
                    } else {
                        echo "No Trophy Yet";
                    }
                    echo "</td></tr>";
                    $rank++;
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

</body>
</html>