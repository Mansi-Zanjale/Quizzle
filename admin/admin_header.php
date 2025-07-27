<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../admin_style.css" />
</head>
<body>
  <header class="header">
    <section class="flex">
      <a class="logo">Admin Panel</a>

      <div class="hamburger" onclick="toggleMenu()">&#9776;</div>

      <nav class="navbar" id="navbar">
        <a href="dashboard.php">Home</a>
        <a href="add_category.php">Categories</a>
        <a href="users_accounts.php">Users</a>
        <a href="admin_accounts.php">Admins</a>
      </nav>
    </section>
  </header>

  <!-- Hamburger toggle script -->
  <script>
    function toggleMenu() {
      document.getElementById("navbar").classList.toggle("show");
    }
  </script>
</body>
</html>
