<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: registration_login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$full_name = htmlspecialchars($_SESSION['full_name'] ?? 'John Doe');
$status = htmlspecialchars($_SESSION['status'] ?? 'Active');
$email = htmlspecialchars($_SESSION['email'] ?? 'user@example.com'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile - NBSPiLink</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="Assets/logo.png" alt="Logo">
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <img src="Assets/icons8-search-100.png" alt="Search Icon" class="search-icon">
            </div>
            <div class="nav-menu">
                <a href="index.php"><img src="Assets/icons8-home-50.png" alt="Home"></a>
                <a href="announcement.php"><img src="Assets/icons8-announcement-100.png" alt="Announcements"></a>
                <a href="groups.php"><img src="Assets/icons8-user-groups-100.png" alt="Groups"></a>
                <a href="notification.php"><img src="Assets/icons8-notification-100.png" alt="Notifications"></a>
            </div>
            <div class="profile">
                <div class="profile-container" onclick="toggleDropdown()">
                    <div class="profile-info">
                        <span class="profile-name"><?php echo $full_name; ?></span>
                        <span class="profile-status"><?php echo $status; ?></span>
                    </div>
                    <div class="profile-icon">
                        <img src="Assets/profilesample.jpg" alt="Profile">
                    </div>
                </div>
                <div id="profile-dropdown" class="dropdown-menu hidden">
                    <ul>
                        <li><a href="profile.php">View Profile</a></li>
                        <li class="dropdown-status">
                            <span>Status:</span>
                            <ul>
                                <li><a href="update_status.php?status=Active">Active</a></li>
                                <li><a href="update_status.php?status=Inactive">Inactive</a></li>
                                <li><a href="update_status.php?status=Do Not Disturb">Do Not Disturb</a></li>
                            </ul>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="main-content">
        <div class="left-column">
            <h2>Profile</h2>
            <ul>
                <li><strong>Username:</strong> <?php echo $username; ?></li>
                <li><strong>Full Name:</strong> <?php echo $full_name; ?></li>
                <li><strong>Email:</strong> <?php echo $email; ?></li>
                <li><strong>Status:</strong> <?php echo $status; ?></li>
            </ul>
        </div>
        <div class="center-column">
        </div>
        <div class="right-column">
            <h2>Suggested</h2>
            <ul>
                <li><a href="#">Suggestion 1</a></li>
                <li><a href="#">Suggestion 2</a></li>
                <li><a href="#">Suggestion 3</a></li>
            </ul>
        </div>
    </div>
    <footer>
        <p>© 2025 NBSPiLink. All rights reserved.</p>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            const dropdown = document.getElementById('profile-dropdown');
            const profileContainer = document.querySelector('.profile-container');
            if (!profileContainer.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
