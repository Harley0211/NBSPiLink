const profileContainer = document.querySelector('.profile-container');
const profileDropdown = document.getElementById('profile-dropdown');

profileContainer.addEventListener('click', () => {
    if (profileDropdown.classList.contains('hidden')) {
        profileDropdown.classList.remove('hidden');
        profileDropdown.style.display = 'block';
    } else {
        profileDropdown.classList.add('hidden');
        profileDropdown.style.display = 'none';
    }
});

document.addEventListener('click', (e) => {
    if (!profileContainer.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.add('hidden');
        profileDropdown.style.display = 'none';
    }
});

function updateStatus(status) {
    document.getElementById('profile-status').textContent = `Status: ${status}`;
}
