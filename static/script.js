// Add smooth scrolling to navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Add some sparkle to the title on hover
const siteTitle = document.querySelector('.site-title');
siteTitle.addEventListener('mouseover', () => {
    siteTitle.style.transform = 'scale(1.05)';
    siteTitle.style.transition = 'transform 0.3s ease';
});

siteTitle.addEventListener('mouseout', () => {
    siteTitle.style.transform = 'scale(1)';
});
