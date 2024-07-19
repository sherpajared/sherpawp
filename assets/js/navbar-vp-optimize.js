// assets/js/navbar.js
window.addEventListener('resize', function() {
    // Get all navbar-collapse elements
    var navbarCollapseElements = document.getElementsByClassName('navbar-collapse');
  
    // Check if the viewport width exceeds 767.98px (Bootstrap's breakpoint for mobile view)
    if (window.innerWidth > 767.98) {
      // Loop through each navbar-collapse element
      for (var i = 0; i < navbarCollapseElements.length; i++) {
        // Remove the 'show' class if it exists
        if (navbarCollapseElements[i].classList.contains('show')) {
          navbarCollapseElements[i].classList.remove('show');
        }
      }
    }
  });
  