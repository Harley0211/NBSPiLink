<?php
session_start();
require 'dbconnect.php';

if (!isset($_SESSION['username'])) {
    header("Location: registration_login.php");
    exit();
}

$username = $_SESSION['username'];

$query = "
    SELECT 
        u.id, 
        u.first_name, 
        u.middle_name, 
        u.last_name, 
        IFNULL(p.status, 'Active') AS status, 
        IFNULL(p.profile_picture, 'default.png') AS profile_picture 
    FROM 
        users u
    LEFT JOIN 
        user_profiles p ON u.id = p.user_id
    WHERE 
        u.username = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['full_name'] = trim($user['first_name'] . ' ' . $user['middle_name'] . ' ' . $user['last_name']);
    $_SESSION['status'] = $user['status'];
    $_SESSION['profile_picture'] = $user['profile_picture'];
} else {
    session_destroy();
    header("Location: registration_login.php");
    exit();
}

$suggestions_query = "
    SELECT 
        u.id, 
        u.first_name, 
        u.middle_name, 
        u.last_name, 
        IFNULL(up.status, 'Active') AS status, 
        IFNULL(up.profile_picture, 'default.png') AS profile_picture
    FROM 
        users u
    LEFT JOIN 
        user_profiles up ON u.id = up.user_id
    WHERE 
        u.id != ? 
        AND u.id NOT IN (
            SELECT friend_id FROM friends WHERE user_id = ?
        )
";
$suggestions_stmt = $conn->prepare($suggestions_query);
$suggestions_stmt->bind_param("ii", $_SESSION['id'], $_SESSION['id']);
$suggestions_stmt->execute();
$suggestions_result = $suggestions_stmt->get_result();
$friend_suggestions = $suggestions_result->fetch_all(MYSQLI_ASSOC);


$user_profile = [
    'name' => htmlspecialchars($_SESSION['full_name']),
    'status' => htmlspecialchars($_SESSION['status']),
    'profile_picture' => htmlspecialchars($_SESSION['profile_picture'])
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups</title>
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
                        <span class="profile-name"><?php echo $user_profile['name']; ?></span>
                        <span class="profile-status"><?php echo $user_profile['status']; ?></span>
                    </div>
                    <div class="profile-icon">
                        <img src="Assets/<?php echo $user_profile['profile_picture']; ?>" alt="Profile">
                    </div>
                </div>
                <div id="profile-dropdown" class="dropdown-menu hidden">
                    <ul>
                        <li><a href="profile.php">View Profile</a></li>
                        <li class="dropdown-status">
                            <span>Status:</span>
                            <ul>
                                <li><a href="update_status.php?status=Active" class="<?php echo ($user_profile['status'] === 'Active') ? 'active-status' : ''; ?>">Active</a></li>
                                <li><a href="update_status.php?status=Inactive" class="<?php echo ($user_profile['status'] === 'Inactive') ? 'active-status' : ''; ?>">Inactive</a></li>
                                <li><a href="update_status.php?status=Do Not Disturb" class="<?php echo ($user_profile['status'] === 'Do Not Disturb') ? 'active-status' : ''; ?>">Do Not Disturb</a></li>
                            </ul>
                        </li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="main-content">
        <div class="left-column">
            <h2>Pages</h2>
            <ul>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>
            </ul>
        </div>
        <div class="center-column">
            <h2>Groups</h2>
        </div>
        <div class="right-column">
            <h2>Friend Suggestions</h2>
            <?php foreach ($friend_suggestions as $suggestion): ?>
                <div class="friend-suggestion-box">
                    <div class="friend-profile">
                        <img src="Assets/<?php echo htmlspecialchars($suggestion['profile_picture']); ?>" alt="Profile" class="friend-profile-img">
                    </div>
                    <div class="friend-info">
                        <p class="friend-name"><?php echo htmlspecialchars($suggestion['first_name'] . ' ' . $suggestion['middle_name'] . ' ' . $suggestion['last_name']); ?></p>
                        <p class="friend-status"><?php echo htmlspecialchars($suggestion['status']); ?></p>
                        <form action="friend_action.php" method="POST" class="friend-actions">
                            <input type="hidden" name="friend_id" value="<?php echo htmlspecialchars($suggestion['id']); ?>">
                            <button type="submit" name="action" value="add" class="add-friend-button">Accept</button>
                            <button type="submit" name="action" value="deny" class="deny-friend-button">Deny</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    <footer>
        <p>© 2025 NBSPiLink. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>