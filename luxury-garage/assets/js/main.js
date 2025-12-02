/**
 * main.js
 * - Mobile navigation toggle
 * - Simple products filter on the client-side
 */

// Mobile navigation toggle
const navToggle = document.getElementById("navToggle");
const mainNav   = document.getElementById("mainNav");

if (navToggle && mainNav) {
    navToggle.addEventListener("click", () => {
        mainNav.classList.toggle("open");
    });
}

// Products filter (client-side)
const filterBtn      = document.getElementById("filterBtn");
const searchInput    = document.getElementById("searchInput");
const brandFilter    = document.getElementById("brandFilter");
const categoryFilter = document.getElementById("categoryFilter");
const productsGrid   = document.getElementById("productsGrid");

if (filterBtn && productsGrid && searchInput && brandFilter && categoryFilter) {
    filterBtn.addEventListener("click", () => {
        const searchValue   = (searchInput.value || "").toLowerCase();
        const brandValue    = brandFilter.value;
        const categoryValue = categoryFilter.value;

        const cards = productsGrid.querySelectorAll(".product-card");

        cards.forEach((card) => {
            const name     = card.querySelector(".product-name").textContent.toLowerCase();
            const brand    = card.getAttribute("data-brand");
            const category = card.getAttribute("data-category");

            let visible = true;

            if (searchValue && !name.includes(searchValue)) {
                visible = false;
            }

            if (brandValue && brand !== brandValue) {
                visible = false;
            }

            if (categoryValue && category !== categoryValue) {
                visible = false;
            }

            card.style.display = visible ? "block" : "none";
        });
    });
}

// Profile dropdown toggle
document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.getElementById('profileTrigger');
    const dropdown = document.getElementById('profileDropdown');

    if (!trigger || !dropdown) return;

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.classList.toggle('show');
    });

    // إغلاق المنيو إذا ضغطت برّا
    document.addEventListener('click', () => {
        dropdown.classList.remove('show');
    });
});
