document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.querySelector(".sidebar");
  const main = document.querySelector(".main");
  const toggle = document.querySelector("[data-sidebar-toggle]");

  if (toggle && sidebar && main) {
    const media = window.matchMedia("(max-width: 860px)");

    const syncMobileState = () => {
      if (media.matches) {
        sidebar.classList.add("closed");
        main.classList.add("expanded");
        toggle.setAttribute("aria-expanded", "false");
      } else {
        sidebar.classList.remove("closed");
        main.classList.remove("expanded");
        toggle.setAttribute("aria-expanded", "true");
      }
    };

    syncMobileState();
    media.addEventListener("change", syncMobileState);

    toggle.addEventListener("click", () => {
      const isClosed = sidebar.classList.toggle("closed");
      main.classList.toggle("expanded", isClosed);
      toggle.setAttribute("aria-expanded", String(!isClosed));
    });
  }
});
