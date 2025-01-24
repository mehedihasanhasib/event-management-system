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
      loader.classList.add("d-none");
    },
    error: function (xhr) {
      const statusCode = xhr.status;
      const errorResponse = xhr.responseJSON.errors;

      if (statusCode == 500) {
        notification({ icon: "error", text: errorResponse[0] });
      }

      if (statusCode == 422) {
        // const errorResponse = xhr.responseJSON.errors;
        Object.entries(errorResponse).forEach(function (errors) {
          const str = errors[0];
          const className = str.includes(".") ? str.split(".")[0] : str;
          const element = document.querySelector(`.${className}Error`);
          element.innerText = errors[1][0];
        });
        notification({ icon: "error", text: "Validation Error" });
      }

      loader.classList.add("d-none");
    },
  });
}
