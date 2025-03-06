// Show Global Loading Animation
function showLoading() {
    Swal.fire({
        title: "Processing...",
        text: "Please wait...",
        allowOutsideClick: false,
        timer: 3000,
        didOpen: () => {
            Swal.showLoading();
            setTimeout(() => {
                Swal.close();
            }, 3000);
        }
    });
}

// Show Global Success Message with Optional Redirect
function showSuccessMessage(message, redirectUrl = null) {
    Swal.fire({
        title: "Success!",
        text: message,
        icon: "success",
        confirmButtonText: "OK",
        timer: 3000
    }).then(() => {
        if (redirectUrl) {
            window.location.href = redirectUrl; // Redirect after confirmation
        }
    });
}