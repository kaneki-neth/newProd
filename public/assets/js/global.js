// Show Global Loading Animation
function showLoading() {
    Swal.fire({
        title: "Processing...",
        text: "Please wait...",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

// Show Global Success Message with Optional Redirect
function showSuccessMessage(message, redirectUrl = null) {
    Swal.fire({
        title: "Success!",
        text: message,
        icon: "success",
        confirmButtonText: "OK"
    }).then(() => {
        if (redirectUrl) {
            window.location.href = redirectUrl; // Redirect after confirmation
        }
    });
}