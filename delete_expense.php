<?php

require 'expensesDB.php';

(new ExpensesDB())->delete($_GET['expense']);

echo "<meta charset='UTF-8' http-equiv='refresh' content='1;URL=all_expenses.php'/>Този разход е изтрит!";