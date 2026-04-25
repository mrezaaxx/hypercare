document.addEventListener("DOMContentLoaded", () => {
    const trigger = document.querySelector("[data-toggle-highlight]");
    const target = document.querySelector("#integrations");

    if (trigger && target) {
        trigger.addEventListener("click", () => {
            target.classList.remove("pulse");
            window.requestAnimationFrame(() => {
                target.classList.add("pulse");
                target.scrollIntoView({ behavior: "smooth", block: "center" });
            });
        });
    }

    const sidebarToggle = document.getElementById("sidebar-toggle");
    const sidebar = document.getElementById("sidebar");

    if (sidebarToggle && sidebar) {
        const overlay = document.createElement("div");
        overlay.className = "sidebar-overlay";
        document.body.appendChild(overlay);

        const closeSidebar = () => {
            sidebar.classList.remove("open");
            overlay.classList.remove("active");
        };

        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            overlay.classList.toggle("active");
        });

        overlay.addEventListener("click", closeSidebar);

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                closeSidebar();
            }
        });

        window.addEventListener("resize", () => {
            if (window.innerWidth > 960) {
                closeSidebar();
            }
        });
    }

    const flash = document.getElementById("flash-success");
    if (flash) {
        setTimeout(() => {
            flash.style.transition = "opacity 400ms ease, transform 400ms ease";
            flash.style.opacity = "0";
            flash.style.transform = "translateY(-10px)";
            setTimeout(() => flash.remove(), 400);
        }, 4000);
    }
});
