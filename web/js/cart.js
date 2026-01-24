$(() => {
  let $send_request = false;

  const getCartCount = () => {
    $.ajax({
      url: "/account/cart/count",
      method: "POST",
      success(data) {
        if (data !== false) {
          $("#cart-count").text(data);
        }
        $send_request = false;
      },
    });
  };

  $("#catalog-pjax").on("click", ".btn-add-cart", function (e) {
    e.preventDefault();
    if ($send_request) {
      return;
    }

    $send_request = true;
    $.ajax({
      url: $(this).attr("href"),
      method: "POST",
      success(data) {
        getCartCount();
      },
      error(data) {
        $send_request = false;
      },
    });
  });

  $("#cart-pjax").on(
    "click",
    ".btn-cart-item_action, .btn-cart-item-remove, .btn-cart-clear",
    function (e) {
      e.preventDefault();
      if ($send_request) {
        return;
      }

      $send_request = true;
      $.ajax({
        url: $(this).attr("href"),
        method: "POST",
        success(data) {
          $.pjax.reload("#cart-pjax");
        },
        error(data) {
          $send_request = false;
        },
      });
    },
  );

  $("#cart-pjax").on("pjax:end", function () {
    getCartCount();
  });
});
