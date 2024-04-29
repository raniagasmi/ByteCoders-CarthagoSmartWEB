document.addEventListener("DOMContentLoaded", function() {
  const container = document.querySelector(".container");
  // Check if the current URL contains "/register" or "/login" and apply the appropriate class
  if (window.location.pathname.includes("/register")) {
      container.classList.add("sign-up-mode");
      container.classList.remove("sign-in-mode");

  } else if (window.location.pathname.includes("/login")) {
      container.classList.remove("sign-up-mode");
      container.classList.add("sign-in-mode");

  }
});
