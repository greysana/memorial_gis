const navToggle = document.querySelector(".nav-toggle");
const navMenu = document.querySelector(".nav-menu");
const navMenu1 = document.querySelector(".nav-menu1");
const navbar = document.querySelector(".navbar");
const heroSection = document.querySelector("#hero");
window.onload = function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("success_email") === "true") {
    alert("Email sent successfully!");
    // Remove the parameter from the URL
    window.history.replaceState({}, document.title, window.location.pathname);
  } else if (urlParams.get("error_email")) {
    alert(urlParams.get("error_email"));
    // Remove the parameter from the URL
    window.history.replaceState({}, document.title, window.location.pathname);
  } else if (urlParams.get("error")) {
    alert(urlParams.get("error"));
    // Remove the parameter from the URL
    window.history.replaceState({}, document.title, window.location.pathname);
  } else if (urlParams.get("message")) {
    alert(urlParams.get("message"));
    // Remove the parameter from the URL
    window.history.replaceState({}, document.title, window.location.pathname);
  }
};
// Handle nav toggle for mobile
navToggle.addEventListener("click", () => {
  navToggle.classList.toggle("rotate");
  navMenu.classList.toggle("active");
  navbar.classList.toggle("active");

  navMenu1.classList.toggle("hide");

  const icon = navToggle.querySelector("i");
  if (icon.classList.contains("fa-bars")) {
    icon.classList.remove("fa-bars");
    icon.classList.add("fa-times");
  } else {
    icon.classList.remove("fa-times");
    icon.classList.add("fa-bars");
  }
});
const navLinks = document.querySelectorAll(".nav-menu1 li a"); // Select all nav links

// Function to update the active link based on the URL path or fragment
function updateActiveLink() {
  const currentPath = window.location.pathname.split("/")[2];
  const currentHash = window.location.hash; // Get the current fragment identifier (e.g., #hero)
  console.log(currentPath);
  // Remove active class from all nav links
  navLinks.forEach((link) => {
    link.classList.remove("active");
  });

  // If the current page is index.php, check for the hash fragment
  if (currentPath.includes("index.php")) {
    navLinks.forEach((link) => {
      const linkPath = link.getAttribute("href").split("#")[1]; // Get the path part of the link (e.g., index.php)
      const linkHash = link.hash; // Get the hash fragment of the link

      if (currentHash === linkHash) {
        console.log(linkPath);
        link.classList.add("active");
      }
    });
  } else {
    // If not index.php, just check the path without the hash
    navLinks.forEach((link) => {
      const linkPath = link.getAttribute("href").split("#")[0]; // Get the path part of the link
      if (currentPath === linkPath) {
        link.classList.add("active");
      }
    });
  }
}

// Call the function on page load to set the initial active link
updateActiveLink();
window.addEventListener("popstate", updateActiveLink); // This triggers on history changes (back/forward navigation)
window.addEventListener("hashchange", updateActiveLink); // This triggers on hash changes
// Change navbar background based on hero section visibility
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        navbar.classList.remove("bg-active");
        navMenu.classList.remove("bg-active");
      } else {
        navbar.classList.add("bg-active");
        navMenu.classList.add("bg-active");
      }
    });
  },
  { threshold: 0.1 } // Adjust threshold for visibility
);

observer.observe(heroSection);

// Smooth navbar hide/show on scroll
let lastScrollY = window.scrollY;
window.addEventListener("scroll", () => {
  if (window.scrollY > lastScrollY) {
    navbar.classList.add("hide");
    navbar.classList.remove("show");
  } else {
    navbar.classList.add("show");
    navbar.classList.remove("hide");
  }
  lastScrollY = window.scrollY;
});
// Function to trigger animation on section
const sections = document.querySelectorAll(".section");

// Options for the Intersection Observer
const options = {
  threshold: 0.5, // 50% of the section must be visible to trigger animation
};

// Callback for when an intersection occurs
const observerCallback = (entries, observer) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      // Add the "show" class when the element is visible
      entry.target.classList.add("show");

      // Get the section name from the `id` attribute or any other attribute like `data-name`
      const sectionName =
        entry.target.id || entry.target.getAttribute("data-name");

      if (sectionName) {
        // Update the URL's hash with the section name
        window.location.hash = sectionName;
      }

      // Stop observing the current target since we've updated the hash
      observer.unobserve(entry.target);
    }
  });
};

// Create the Intersection Observer
const observer1 = new IntersectionObserver(observerCallback, options);

// Observe each section
sections.forEach((section) => {
  observer1.observe(section);
});
