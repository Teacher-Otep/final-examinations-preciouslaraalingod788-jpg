function showSection(sectionID) {
    const home = document.getElementById('home');
    const sections = document.querySelectorAll('.content');

    if (home) home.style.display = 'none';
    sections.forEach(s => s.style.display = 'none');

    const target = document.getElementById(sectionID);
    if (target) target.style.display = 'block';
}

window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('status') === 'success') {
        showSection('read');
        alert("Operation Successful!");
    } else {
        showSection('home');
    }
};