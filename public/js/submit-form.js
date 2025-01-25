const loader = document.getElementById("loader");
function submit(
  url,
  formData,
  callback = () => {
    location.reload();
  }
) {
  loader.classList.remove("d-none");

  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    processData: false,
    contentType: false,
    dataType: "json",
    success: function (response) {
      loader.classList.add("d-none");
      if (response.status) {
        Swal.fire({
          icon: "success",
          title: response.message,
        })
          .then((result) => {
            if (result.isConfirmed) {
              callback();
            }
          })
          .catch((err) => {});
      } else {
        Swal.fire({
          icon: "error",
          title: response.message,
        });
      }
    },
    error: function (xhr) {
      loader.classList.add("d-none");
      const statusCode = xhr.status;
      const errorResponse = xhr.responseJSON.errors;

      if (statusCode == 500) {
        notification({ icon: "error", text: errorResponse });
      }

      if (statusCode == 401) {
        const element = document.querySelector(`.validationError`);
        element.innerText = errorResponse;
        notification({ icon: "error", text: errorResponse });
      }

      if (statusCode == 422) {
        Object.entries(errorResponse).forEach(function (errors) {
          const str = errors[0];
          const className = str.includes(".") ? str.split(".")[0] : str;
          console.log(className);
          const element = document.querySelector(`.${className}Error`);
          element.innerText = errors[1];
        });
        notification({ icon: "error", text: "Validation Error" });
      }
    },
  });
}
