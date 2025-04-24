<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $amount = $_POST['amount'];
  header("Location: https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&business=your-paypal-email@example.com&item_name=Flight+Ticket&amount=$amount&currency_code=USD");
  exit;
}
?>
