// ============================================================
// Spice Route Restaurant - Client-side interactivity
// ============================================================

document.addEventListener("DOMContentLoaded", function () {

    // ---------- Add to cart (AJAX, no page reload) ----------
    document.querySelectorAll(".add-to-cart-form").forEach(function (form) {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const itemId = form.querySelector("input[name='item_id']").value;
            const qtyInput = form.querySelector("input[name='quantity']");
            const quantity = qtyInput ? qtyInput.value : 1;
            const button = form.querySelector("button");
            const originalText = button.textContent;
            button.textContent = "Adding...";
            button.disabled = true;

            const params = new URLSearchParams();
            params.append("item_id", itemId);
            params.append("quantity", quantity);

            fetch("cart_action.php?action=add", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params.toString()
            })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.success) {
                        const cartCountEl = document.getElementById("cartCount");
                        if (cartCountEl) cartCountEl.textContent = data.cartCount;
                        button.textContent = "Added ✓";
                        setTimeout(function () {
                            button.textContent = originalText;
                            button.disabled = false;
                        }, 900);
                    } else {
                        alert(data.message || "Could not add item. Please login first.");
                        button.textContent = originalText;
                        button.disabled = false;
                    }
                })
                .catch(function () {
                    alert("Something went wrong. Please try again.");
                    button.textContent = originalText;
                    button.disabled = false;
                });
        });
    });

    // ---------- Cart page: update quantity ----------
    document.querySelectorAll(".qty-input").forEach(function (input) {
        input.addEventListener("change", function () {
            const itemId = input.dataset.itemId;
            const quantity = input.value;
            if (quantity < 1) { input.value = 1; return; }

            const params = new URLSearchParams();
            params.append("item_id", itemId);
            params.append("quantity", quantity);

            fetch("cart_action.php?action=update", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params.toString()
            })
                .then(function (res) { return res.json(); })
                .then(function () { window.location.reload(); });
        });
    });

    // ---------- Cart page: remove item ----------
    document.querySelectorAll(".remove-item-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            if (!confirm("Remove this item from your cart?")) return;
            const itemId = btn.dataset.itemId;
            const params = new URLSearchParams();
            params.append("item_id", itemId);

            fetch("cart_action.php?action=remove", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params.toString()
            })
                .then(function (res) { return res.json(); })
                .then(function () { window.location.reload(); });
        });
    });

    // ---------- Category filter (client-side show/hide) ----------
    const filterLinks = document.querySelectorAll(".category-filter a");
    filterLinks.forEach(function (link) {
        link.addEventListener("click", function (e) {
            const cat = link.dataset.category;
            if (!cat) return; // let normal server-side links work if used instead
            e.preventDefault();
            filterLinks.forEach(function (l) { l.classList.remove("active"); });
            link.classList.add("active");
            document.querySelectorAll(".menu-card").forEach(function (card) {
                if (cat === "all" || card.dataset.category === cat) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });

    // ---------- Registration form validation ----------
    const registerForm = document.getElementById("registerForm");
    if (registerForm) {
        registerForm.addEventListener("submit", function (e) {
            let valid = true;
            const password = registerForm.querySelector("#password").value;
            const confirm = registerForm.querySelector("#confirm_password").value;
            const phone = registerForm.querySelector("#phone").value;
            const errorBox = document.getElementById("registerError");
            errorBox.textContent = "";

            if (password.length < 6) {
                errorBox.textContent = "Password must be at least 6 characters.";
                valid = false;
            } else if (password !== confirm) {
                errorBox.textContent = "Passwords do not match.";
                valid = false;
            } else if (!/^[0-9]{10}$/.test(phone)) {
                errorBox.textContent = "Enter a valid 10-digit phone number.";
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }

    // ---------- Checkout form validation ----------
    const checkoutForm = document.getElementById("checkoutForm");
    if (checkoutForm) {
        checkoutForm.addEventListener("submit", function (e) {
            const address = checkoutForm.querySelector("#delivery_address").value.trim();
            const errorBox = document.getElementById("checkoutError");
            errorBox.textContent = "";
            if (address.length < 10) {
                errorBox.textContent = "Please enter a complete delivery address.";
                e.preventDefault();
            }
        });
    }
});
