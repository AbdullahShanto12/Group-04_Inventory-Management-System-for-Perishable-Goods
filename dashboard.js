document.addEventListener('DOMContentLoaded', () => {
    // Get all nav links
    const navLinks = document.querySelectorAll('.nav-link');

    // Add click event listeners to nav links
    navLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();

            // Get the target section from the href attribute
            const target = link.getAttribute('href').replace('.html', '');
            
            // Show the selected section
            showSection(target);
        });
    });

    // Function to show the selected section
    function showSection(sectionId) {
        document.querySelectorAll('.content-section').forEach(section => {
            section.style.display = section.id === sectionId ? 'block' : 'none';
        });
    }
});
