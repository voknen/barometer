<?php

require 'earningsDB.php';

(new EarningsDB())->delete($_GET['earning']);

echo "<meta charset='UTF-8' http-equiv='refresh' content='1;URL=all_earnings.php'/>Този приход е изтрит!";