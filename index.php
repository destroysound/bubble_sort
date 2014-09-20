<?php

/*
  Programming Assessment: Minimal Version
  Assignee: Willow Hunt
  Date: 09/19/2014

  Iterates through bubble sort, displaying each step as a bar chart.
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

function display_table($items, $swapped, $step, $done) {
?>
<html>
  <head>
    <title>Grove Street Bubble Sort Simulation</title>
    <style>
      body {
        font-family: verdana;
      }
      form {
        display: inline;
      }
      table {
        border-spacing: 1px;
      }
      td {
        padding: 0px;
      }
      .number-cell {
        width: 40px;
      }
      .highlighted-number {
        font-weight: bold;
        color: #F00;
      }
      .highlighted-row {
        background: #F00;
      }
      .row {
        background: #000;
      }
      .highlighted-table-row {
        background: #EEE;
      }
      .submit {
          background-color: #888;
          -moz-border-radius: 5px;
          -webkit-border-radius: 5px;
          border-radius: 6px;
          color: #fff;
          font-size: 18px;
          text-decoration: none;
          cursor: pointer;
          border: 1px #222 solid;
      }

      .submit:hover {
          border: 1px #222 solid;
          background: #555;
          box-shadow: 0px 0px 1px #777;
      }
      .submit:disabled {
          background: #222;
          color: #888;
          box-shadow: 0px 0px 1px #777;
          cursor: default;
      }
    </style>
  </head>
  <body>
    <form action="index.php">
      <input type="hidden" name="action" value="step" />
      <input type="hidden" name="items" value="<?php print implode(",", $items); ?>" />
      <input type="hidden" name="swapped" value="<?php print $swapped; ?>" />
      <input type="hidden" name="step" value="<?php print $step; ?>" />
      <input type="submit" value="step" class="submit"
      <?php if ($done) { ?>
        disabled
      <?php } ?>
       />
    </form>
    <form action="index.php">
      <input type="hidden" name="action" value="shuffle" />
      <input type="submit" value="shuffle" class="submit" />
    </form>
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

display_table($items, $swapped, $step, $done);

?>
