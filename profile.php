<?php
include 'components/connect.php';
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_user->execute([$user_id]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

// If user not found, redirect to login
if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Default profile picture if none selected
$profile_pic = !empty($user['profile_pic']) ? $user['profile_pic'] : 'avatar1.png';

$fetch_stars = $conn->prepare("SELECT stars from `users` WHERE id=?");
$fetch_stars->execute([$user_id]);
$total_stars = $fetch_stars->fetchColumn();

// Fetch user rank based on stars (higher stars = better rank)
$get_rank = $conn->prepare("SELECT id FROM users ORDER BY stars DESC, score DESC");
$get_rank->execute();
$ranks = $get_rank->fetchAll(PDO::FETCH_COLUMN);
$user_rank = array_search($user_id, $ranks) + 1; // Find user position in the list


// Function to determine trophy based on stars
function getTrophy($stars)
{
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
        return "No Trophy Yet";
    }
}

$trophy = getTrophy($user['stars']);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile | Quizzle</title>
    <meta name="description" content="Track your quiz performance, scores, and stars. Manage your account and see your achievements." />
    <link rel="canonical" href="https://mansi-zanjale.github.io/profile.php" />


    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Navbar -->
    <!-- <?php include 'components/user_header.php'; ?> -->


    <header class="header">

        <section class="flex">

            <h1 class="user"> Hello &nbsp;

                <?php
                $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                $select_profile->execute([$user_id]);
                if ($select_profile->rowCount() > 0) {
                    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                    echo '<p class"name">' . htmlspecialchars($fetch_profile['username']) . '</p>';
                }
                ?>


            </h1>

            <div class="hamburger" onclick="toggleMenu()">≣</div>
            <nav class="navbar">
                <a href="category.php">Category</a>
            </nav>

        </section>
    </header>


    <section class="profile-container">
        <h1>Your Profile</h1>

        <div class="profile-box">
            <img src="images/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-img">
            <div class="profile-details">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>

                <div class="stats-trophy">
                    <div class="st">
                        <p><strong>Your Rank:</strong> <?php echo htmlspecialchars($user_rank); ?></p>
                        <p><strong>Score:</strong> <?php echo htmlspecialchars($user['score']); ?></p>
                        <p><strong>Stars:</strong> <?php echo htmlspecialchars($total_stars); ?> ⭐</p>
                    </div>

                    <div>
                        <p><strong>Trophy:</strong></p>
                        <?php if ($trophy !== "No Trophy Yet") : ?>
                            <img src="<?= htmlspecialchars($trophy); ?>" alt="Trophy" class="trophy-img">
                        <?php else : ?>
                            No Trophy Yet
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-btn">
            <form action="edit_profile.php" method="get">
                <button class="edit" type="submit">Edit Profile</button>
            </form>
            <form action="logout.php" method="get">
                <button class="logout" type="submit">Logout</button>
            </form>
        </div>
    </section>



    <!-- Custom JS File -->
    <script src="js/script.js"></script>



</body>

</html>