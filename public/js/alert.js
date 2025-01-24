function sweetAlert({ icon, title, text = "Something went worng" }) {
  Swal.fire({
    icon: icon,
    title: title,
    text: text,
    confirmButtonText: "Okay",
    customClass: {
      container: "sweet-alert-container",
      popup: "sweet-alert-popup",
      header: "sweet-alert-header",
      title: "sweet-alert-title",
      close: "sweet-alert-close",
      icon: "sweet-alert-icon",
      image: "sweet-alert-image",
      content: "sweet-alert-content",
      input: "sweet-alert-input",
      actions: "sweet-alert-actions",
      confirmButton: "sweet-alert-confirm-button",
      cancelButton: "sweet-alert-cancel-button",
      footer: "sweet-alert-footer",
    },
    showClass: {
      popup: "animate__animated animate__fadeInDown",
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp",
    },
  });
}

function notification({ icon, text = "Something went worng" }) {
  Swal.fire({
    icon: icon,
    // title: title,
    text: text,
    toast: true,
    position: "top-end",
    timer: 5000,
    timerProgressBar: true,
    showConfirmButton: false,
    showCloseButton: true,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
    customClass: {
      popup: "sweet-alert-toast-popup", // Custom class for the popup
      toast: "sweet-alert-toast-popup",
      timerProgressBar: "sweet-alert-toast-progressBar",
    },
    showClass: {
      popup: "animate__animated animate__fadeInDown",
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp",
    },
  });
}

function sweetAlertConfirm({ icon, title, text = "Something went worng" }) {
  return Swal.fire({
    icon: icon,
    title: title,
    text: text,
    showCancelButton: true, // Enable the cancel button
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    cancelButtonColor: "#dc3545",
    customClass: {
      container: "sweet-alert-container",
      popup: "sweet-alert-popup",
      header: "sweet-alert-header",
      title: "sweet-alert-title",
      close: "sweet-alert-close",
      icon: "sweet-alert-icon",
      image: "sweet-alert-image",
      content: "sweet-alert-content",
      input: "sweet-alert-input",
      actions: "sweet-alert-actions",
      confirmButton: "sweet-alert-confirm-button",
      cancelButton: "sweet-alert-cancel-button",
      footer: "sweet-alert-footer",
    },
    showClass: {
      popup: "animate__animated animate__fadeInDown",
    },
    hideClass: {
      popup: "animate__animated animate__fadeOutUp",
    },
  }).then((result) => {
    if (result.isConfirmed) {
      // The user clicked "Yes"
      return true;
    } else if (result.isDismissed) {
      // The user clicked "No" or closed the dialog
      return false;
    }
  });
}
