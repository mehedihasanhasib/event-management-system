function submit(
  url,
  data,
  callback = () => {
    location.reload();
  }
) {
  console.log(data);
  fetch(url, {
    method: "POST",
    body: data,
  })
    .then((response) => response.json())
    .then((data) => console.log(data));
}
