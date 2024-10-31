jQuery(document).ready(function ($) {
  get_product();

  jQuery(".pisol_cat_button").click(function () {
    jQuery(".pisol_cat_button").removeClass("active");
    get_product($(this).data("id"));
    jQuery(this).addClass("active");
  });

  $(document).on("change", ".quantity input", function () {
    var p = $(this)
      .parent("div")
      .parent("td")
      .parent("tr");
    $(".ajax_add_to_cart", p).attr("data-quantity", $(this).val());
  });

  /* max_limit(); */

  visual_improvement();

  product_search();

  jQuery(document).on('click', '.show-side-dishes', function () {
    var product = jQuery(this).data('product');
    jQuery('.side-dish-for-' + product).toggleClass('hide-side-dish');
  });

  jQuery(document).on('pi_res_deselect_product', function (event, product_id) {
    deselectProduct(product_id);
  })

});

function deselectProduct(product_id) {
  jQuery('.dishes-group[data-product="' + product_id + '"] input[type="checkbox"]:checked').prop('checked', false).trigger('change');
}

function max_limit() {
  var $ = jQuery;

  $("input.dish").on("change", function () {
    var max = $(this).data("max");

    if (
      $(
        "input:checked",
        $(this)
          .parent()
          .parent()
          .parent()
      ).length >= max
    ) {
      console.log(
        $(
          "input:checked",
          $(this)
            .parent()
            .parent()
            .parent()
        ).length
      );
      $(
        "input:not(:checked)",
        $(this)
          .parent()
          .parent()
          .parent()
      ).attr("disabled", true);
    } else {
      $(
        "input:not(:checked)",
        $(this)
          .parent()
          .parent()
          .parent()
      ).attr("disabled", false);
    }

    if ($(this).prop("checked") == true) {
      console.log($(this).attr("name"));
      var present_price = parseFloat(
        $(
          "#product_" +
          $(this).data("product") +
          "_" +
          $(this).data("cat") +
          " .product_price"
        ).html()
      );
      var sidedish_price = parseFloat($(this).data("price"));
      var total_price = present_price + sidedish_price;
      total_price = total_price.toFixed(2);
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .product_price"
      ).html(total_price);
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .ajax_add_to_cart"
      ).data("dish" + $(this).data("unique") + "[name]", $(this).val());
      if (sidedish_price == 0) {
        $(
          "#product_" +
          $(this).data("product") +
          "_" +
          $(this).data("cat") +
          " .added_sidedishes"
        ).append(
          '<li id="' + $(this).data("hash") + '">' + $(this).val() + "</li>"
        );
      } else {
        $(
          "#product_" +
          $(this).data("product") +
          "_" +
          $(this).data("cat") +
          " .added_sidedishes"
        ).append(
          '<li id="' +
          $(this).data("hash") +
          '">' +
          $(this).val() +
          ": <small>" +
          pisol.currency +
          $(this).data("price") +
          pisol.currency_right +
          "</small></li>"
        );
      }
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .ajax_add_to_cart"
      ).data(
        "dish" + $(this).data("unique") + "[price]",
        $(this).data("price")
      );
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .ajax_add_to_cart"
      ).data("dish" + $(this).data("unique") + "[hash]", $(this).data("hash"));
    } else {
      var present_price = parseFloat(
        $(
          "#product_" +
          $(this).data("product") +
          "_" +
          $(this).data("cat") +
          " .product_price"
        ).html()
      );
      var sidedish_price = parseFloat($(this).data("price"));
      var total_price = present_price - sidedish_price;
      total_price = total_price.toFixed(2);
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .product_price"
      ).html(total_price);
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .ajax_add_to_cart"
      ).removeData("dish" + $(this).data("unique") + "[name]");
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .ajax_add_to_cart"
      ).removeData("dish" + $(this).data("unique") + "[price]");
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .ajax_add_to_cart"
      ).removeData("dish" + $(this).data("unique") + "[hash]");
      $(
        "#product_" +
        $(this).data("product") +
        "_" +
        $(this).data("cat") +
        " .added_sidedishes #" +
        $(this).data("hash")
      ).remove();
    }
  });
}


/*
  Loads product table with ajax call on load and on tab click
*/
function get_product(cat) {
  if (jQuery("#pisol_product_table").length == 0) return;

  if (cat) {
    var cat_id = cat;
  } else {
    var cat_id = pisol.default_cat;
  }

  var session_products = sessionStorage.getItem('pisol_cat_products_' + cat_id);

  if (session_products && pisol.browser_caching) {
    afterProductAdde(session_products, cat_id);
    return;
  }

  jQuery.ajax({
    url: pisol.ajax_url,
    type: "post",
    data: {
      action: "pisol_get_products",
      pisol_cat_id: cat_id
    },
    beforeSend: function () {
      jQuery("#pisol_product_table").append(
        '<div class="pisol-processing"></div>'
      );
    },
    success: function (response) {
      afterProductAdde(response, cat_id);
    }
  });
}

function afterProductAdde(response, cat_id) {
  jQuery("#pisol_product_table").html(response);
  sessionStorage.setItem('pisol_cat_products_' + cat_id, response);
  max_limit();
  if (jQuery.isFunction(window.disableIfMinCriteria)) {
    var min_obj = new disableIfMinCriteria();
    min_obj.init();
  }
}

/*
  Front end visual improvement
*/
function visual_improvement() {
  var $ = jQuery;

  /* Open side dishes group on click */
  $(document).on("click", ".sidedish-group", function (e) {
    $(this)
      .next(".dishes-group")
      .toggle();
  });

  $(document.body).on("adding_to_cart", function (event, data) {
    if (pisol.clear_on_add_to_cart == 1) {
      var product_id = jQuery(data).data('product_id');
      jQuery(document).trigger('pi_res_deselect_product', [product_id]);
    }
    jQuery("#pisol_product_table").append(
      '<div class="pisol-processing"></div>'
    );
  });
  /* cart_page_refreshed */
  $(document.body).on("wc_cart_button_updated", function () {
    //console.log("asdsad");
    jQuery(".pisol-processing").remove();
  });

  $(document.body).on("cart_page_refreshed", function () {
    //console.log("asdsad");
    jQuery(".pisol-processing").remove();
  });

  /* Filtering of product based on veg and non veg */
  $(document).on("click", ".type_filter", function (e) {
    var data_class = $(this).data("class");
    $(".type_filter").removeClass("active");

    $(this).addClass("active");
    if (data_class == ".none") {
      $(".pisol_table .product_row, .pisol_table .pisol_sidedish_row").fadeIn();
      return;
    }

    $.when(
      $(".pisol_table .product_row, .pisol_table .pisol_sidedish_row")
        .not(data_class)
        .fadeOut(),
      $(".pisol_table .product_row" + data_class).fadeIn(),
      $(".pisol_table .pisol_sidedish_row" + data_class).fadeIn()
    ).done(function () {
      if ($(".product_row:visible").length == 0) {
        $(".pisol_table tbody").append(
          '<tr class="pisol_no_product_msg"><td colspan="5">' +
          pisol.no_product_msg +
          "</td></tr>"
        );
      } else {
        $(".pisol_no_product_msg").remove();
      }
    });

    /* Check if there are any product left to show after applying filter */
  });

  $(document).on("click", ".pisol_child_cat_toggle", function () {
    var cat_id = $(this).data("child-cat-id");
    $(this).toggleClass("child_cap_closed");
    $(".child_category_selector_" + cat_id).toggle();
  });
}

function product_search() {
  // Declare variables
  var $ = jQuery;

  $("#pisol_product_search").keyup(function () {
    var value = $(this).val();
    $(".product_row").each(function () {
      var product = $(".product_name a", this).html();
      /*
      console.log(product);
      console.log(product.toUpperCase().indexOf(value.toUpperCase()));
      */
      if (product.toUpperCase().indexOf(value.toUpperCase()) > -1) {
        $(this).fadeIn();
        $(this)
          .next(".pisol_sidedish_row")
          .fadeIn();
      } else {
        $(this).fadeOut();
        $(this)
          .next(".pisol_sidedish_row")
          .fadeOut();
      }
    });
  });

  /*
    Product search from all product in system
  */
  $("#pisol_search_all_product").on("click", function (e) {
    var product_name = $("#pisol_product_search").val();

    jQuery.ajax({
      url: pisol.ajax_url,
      type: "post",
      data: {
        action: "pisol_search_product",
        product_name: product_name
      },
      beforeSend: function () {
        jQuery("#pisol_product_table").append(
          '<div class="pisol-processing"></div>'
        );
      },
      success: function (response) {
        jQuery("#pisol_product_table").html(response);
        max_limit();
        if (jQuery.isFunction(window.disableIfMinCriteria)) {
          var min_obj = new disableIfMinCriteria();
          min_obj.init();
        }
      }
    });
  });
}

jQuery(function ($) {
  jQuery(document).on('click', '.pi-rm-image', function (e) {
    e.preventDefault();
    var src = $(this).attr('href');
    $.magnificPopup.open({
      items: {
        src: src
      },
      type: 'image'
    });
  })

})