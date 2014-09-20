<?php

/*
  Programming Assessment: With Ajax Play Button
  Assignee: Willow Hunt
  Date: 09/19/2014

  Iterates through bubble sort, displaying each step as a bar chart.

  I implemented the play button using JQuery. The entire body of the page
  is refreshed with the contents of the endpoint, which is loaded with ajax.
  The method parameter is passed, which simply tells us whether to render the
  full page or the partial body.

*/

function print_row($item, $highlight) {
?>
  <tr <?php if ($highlight) { ?>class="highlighted-table-row"<?php } ?>>
    <td class="number-cell <?php if ($highlight) { ?>highlighted-number<?php } ?>">
      <?php print $item; ?>
    </td>
    <td>
      <div <?php if ($highlight) { ?>class="highlighted-row"<?php } else { ?>class="row"<?php } ?> style="width: <?php print $item*6 ?>px;">&nbsp;</div>
    </td>
  </tr>
<?php
}

function display_body($items, $swapped, $step, $done) {
?>
    <form id="step_form">
      <input type="hidden" name="action" value="step" />
      <input type="hidden" name="items" id="items" value="<?php print implode(",", $items); ?>" />
      <input type="hidden" name="swapped" id="swapped" value="<?php print $swapped; ?>" />
      <input type="hidden" name="step" id="step" value="<?php print $step; ?>" />
      <input type="submit" value="step" class="submit"
      <?php if ($done) { ?>
        disabled
      <?php } ?>
       />
    </form>
    <form>
      <input type="hidden" name="action" value="shuffle" />
      <input type="submit" value="shuffle" class="submit" />
    </form>
    <input id="play_button" type="submit" value="play" class="submit"
      <?php if ($done) { ?>
        disabled
      <?php } ?>
    />
    <table>
    <?php
    foreach ($items as $index => $item) {
      $highlight = false;
      if (!$done && ($index == $step || $index == $step-1)) {
        $highlight = true;
      }
      print_row($item, $highlight);
    }
    ?>
    </table>
<?php
}

function display_page($items, $swapped, $step, $done) {
?>
<html>
  <head>
    <title>Grove Street Bubble Sort Simulation</title>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="play-button.js"></script>
    <link rel="stylesheet" type="text/css" href="bubble-sort.css">
  </head>
  <body>
    <?php display_body($items, $swapped, $step, $done); ?>
  </body>
</html>
<?php
}

function bubble_sort_step(&$items, $swapped, $step) {
  if ($items[$step-1] > $items[$step]) {
    $temp = $items[$step];
    $items[$step] = $items[$step-1];
    $items[$step-1] = $temp;
    return true;
  }
  return $swapped;
}

$items = $_GET['items'];
$action = $_GET['action'];
$swapped = $_GET['swapped'];
$step = $_GET['step'];
$mode = $_GET['mode'];

$done = false;
$length = 10;

if (!$items || $action === "shuffle") {
  $items = array();
  for ($i = 0; $i < $length; $i++) {
    $items[$i] = rand(1, 100);
  };
  $swapped = false;
  $step = 1;
}
else if ($items) {
  $items = explode(",", $items);
}
if ($action === "step") {
  $swapped = bubble_sort_step($items, $swapped, $step);
  $step++;
  if ($step > $length-1) {
    if (!$swapped) {
      $done = true;
    }
    $step = 1;
    $swapped = false;
  }
}

if (!($mode === "ajax")) {
  display_page($items, $swapped, $step, $done);
}
else {
  display_body($items, $swapped, $step, $done);
}

?>
