<?php 
session_start();

if (!isset($_SESSION['isLogged'])) {
    header("Location: login.php");
    exit();
}

require 'earningsDB.php';
$earnings = new EarningsDB();

$salary_earnings = $earnings->getEarningsByType('salary');
$scholarship_earnings = $earnings->getEarningsByType('scholarship');
$inheritance_earnings = $earnings->getEarningsByType('inheritance');
$other_earnings = $earnings->getEarningsByType('other');

require 'expensesDB.php';
$expenses = new ExpensesDB();

$food_expenses = $expenses->getExpensesByType('food');
$fuel_expenses = $expenses->getExpensesByType('fuel');
$education_expenses = $expenses->getExpensesByType('education');
$entertainment_expenses = $expenses->getExpensesByType('entertainment');
$other_expenses = $expenses->getExpensesByType('other');
?>
<html>
<head>
	<meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="js/javascript.js"></script>
</head>
<body>
	<div class="mymenu">
	</div><br>
    <h3>Статистика на всички приходи</h3>
    <table>
        <th> Заплата</th>
        <th> Стипендия </th>
        <th> Наследство </th>
        <th> Други </th>
        <tr>
            <td><?= $salary_earnings->sum; ?></td>
            <td><?= $scholarship_earnings->sum; ?></td>
            <td><?= $inheritance_earnings->sum; ?></td>
            <td><?= $other_earnings->sum; ?></td>
        </tr>
    </table><br>    
    <h3>Статистика на всички разходи</h3>
    <table>
        <th> Храна </th>
        <th> Гориво </th>
        <th> Забавление </th>
        <th> Образование</th>
        <th> Други </th>
        <tr>
            <td><?= $food_expenses->sum; ?></td>
            <td><?= $fuel_expenses->sum; ?></td>
            <td><?= $entertainment_expenses->sum; ?></td>
            <td><?= $education_expenses->sum; ?></td>
            <td><?= $other_expenses->sum; ?></td>
        </tr>
    </table>    
</body>
</html>