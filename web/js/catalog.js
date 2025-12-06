$(() => {
  $("#catalog-pjax").on("click", ".btn-favourite", function (e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr("href"),
      method: "POST",
      success(data) {
        if (data) {
          $.pjax.reload("#catalog-pjax");
        }
      },
    });
  });
});
