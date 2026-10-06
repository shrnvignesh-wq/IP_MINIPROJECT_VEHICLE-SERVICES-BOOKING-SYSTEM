/* ============================================================
   Vehicle Services Booking System - Client-side JavaScript
   Handles: form validation, dynamic price preview
   ============================================================ */

// ---------- Registration form validation ----------
function validateRegisterForm() {
    const name = document.getElementById("full_name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const password = document.getElementById("password").value;
    let valid = true;

    clearErrors();

    if (name.length < 3) {
        showError("full_name_error", "Name must be at least 3 characters.");
        valid = false;
    }
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        showError("email_error", "Enter a valid email address.");
        valid = false;
    }
    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        showError("phone_error", "Phone number must be 10 digits.");
        valid = false;
    }
    if (password.length < 6) {
        showError("password_error", "Password must be at least 6 characters.");
        valid = false;
    }
    return valid;
}

// ---------- Login form validation ----------
function validateLoginForm() {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    let valid = true;

    clearErrors();

    if (email === "") {
        showError("email_error", "Email is required.");
        valid = false;
    }
    if (password === "") {
        showError("password_error", "Password is required.");
        valid = false;
    }
    return valid;
}

// ---------- Booking form: dynamic price preview ----------
function updateServicePreview() {
    const select = document.getElementById("service_id");
    const preview = document.getElementById("service_preview");
    if (!select || !preview) return;

    const selected = select.options[select.selectedIndex];
    const price = selected.getAttribute("data-price");
    const duration = selected.getAttribute("data-duration");

    if (price) {
        preview.innerHTML =
            "Estimated Cost: <strong>Rs. " + price + "</strong> &nbsp;|&nbsp; " +
            "Duration: <strong>" + duration + " mins</strong>";
        preview.style.display = "block";
    } else {
        preview.style.display = "none";
    }
}

function validateBookingForm() {
    const vehicleNumber = document.getElementById("vehicle_number").value.trim();
    const date = document.getElementById("booking_date").value;
    let valid = true;

    clearErrors();

    if (vehicleNumber.length < 4) {
        showError("vehicle_number_error", "Enter a valid vehicle number.");
        valid = false;
    }
    const today = new Date().toISOString().split("T")[0];
    if (date < today) {
        showError("booking_date_error", "Booking date cannot be in the past.");
        valid = false;
    }
    return valid;
}

// ---------- Helpers ----------
function showError(id, message) {
    const el = document.getElementById(id);
    if (el) el.textContent = message;
}
function clearErrors() {
    document.querySelectorAll(".form-error").forEach(el => el.textContent = "");
}

// ---------- Init ----------
document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("service_id");
    if (select) select.addEventListener("change", updateServicePreview);
});
