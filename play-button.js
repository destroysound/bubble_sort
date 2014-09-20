$(function () {
  var play_timer = null;
  var xhr = null;
  function stop_play_button() {
    // first, stop the timer
    clearTimeout(play_timer);
    // if there is a pending ajax request, kill it
    if (xhr) {
      xhr.abort();
    }
    $("#play_button").attr("value", "play");
    $("#play_button").unbind("click");
    $("#play_button").click(function () {
      click_play_button();
    });
  }
  function click_play_button() {
    var serialized = $("#step_form").serializeArray();
    var context = {
      'action': serialized[0].value,
      'items': serialized[1].value,
      'swapped': serialized[2].value,
      'step': serialized[3].value,
      'mode': 'ajax'
    };
    xhr = $.ajax({
      type: "GET",
      url: "index-extra-credit.php",
      data: context
    })
    .done(function( html ) {
      xhr = null;
      $('body').html(html);
      // if the button isn't disabled, we can keep playing
      if (!$("#play_button").is(":disabled")) {
        $("#play_button").attr("value", "stop");
        // we need to rebind this now that we've refreshed
        // the entire body
        $("#play_button").click(function () {
          stop_play_button();
        });
        play_timer = setTimeout(function () {
          click_play_button();
        }, 500);
      }
    });
  }
  $("#play_button").click(function () {
    click_play_button();
  });
});
