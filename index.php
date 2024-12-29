<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBSPiLink</title>
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
                <a href="#"><img src="Assets/icons8-home-50.png" alt=""></a>
                <a href="#"><img src="Assets/icons8-announcement-100.png" alt=""></a>
                <a href="#"><img src="Assets/icons8-user-groups-100.png" alt=""></a>
                <a href="#"><img src="Assets/icons8-notification-100.png" alt=""></a>
            </div>
            <div class="profile">
                <div class="profile-container">
                    <div class="profile-info">
                        <span class="profile-name">John Doe</span>
                        <span class="profile-status">Active</span>
                    </div>
                    <div class="profile-icon">
                        <img src="Assets/I will do corporate headshot editing, portrait retouching, photo background editing.jpg" alt="Profile">
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="main-content">
        <div class="left-column">
            <h2>Pages</h2>
        </div>
        <div class="center-column">
            <div class="whats-on-your-mind-container">
                <div class="whats-on-your-mind">
                    <div class="profile-and-textarea">
                        <div class="profile">
                            <img src="Assets/I will do corporate headshot editing, portrait retouching, photo background editing.jpg" alt="Profile" class="profile-img">
                        </div>
                        <textarea placeholder="What's on your mind?" rows="3"></textarea>
                    </div>
                    <div class="upload-icons">
                        <label for="upload-photo" class="upload-icon">
                            <img src="Assets/icons8-photo-gallery-100.png" alt="Upload Photo">
                            <input type="file" id="upload-photo" accept="image/*" hidden>
                        </label>
                        <label for="upload-video" class="upload-icon">
                            <img src="Assets/icons8-video-100.png" alt="Upload Video">
                            <input type="file" id="upload-video" accept="video/*" hidden>
                        </label>
                    </div>
                    <button class="post-button">Post</button>
                </div>
            </div>
        </div>
        <div class="right-column">
            <h2>Suggested</h2>
        </div>
    </div>
</body>
</html>
