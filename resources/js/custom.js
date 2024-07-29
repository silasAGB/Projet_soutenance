document.addEventListener("DOMContentLoaded", function () {
    const logo = document.querySelector(".navbar-logo");

    function updateLogoSize() {
        if (document.body.classList.contains("sidebar-collapse")) {
            logo.classList.add("collapsed");
            logo.classList.remove("expanded");
        } else {
            logo.classList.add("expanded");
            logo.classList.remove("collapsed");
        }
    }

    // Initial state
    updateLogoSize();

    // Update the logo size when the sidebar is toggled
    document
        .querySelector('[data-widget="pushmenu"]')
        .addEventListener("click", function () {
            setTimeout(updateLogoSize, 300); // Delay to match the transition duration
        });
});
