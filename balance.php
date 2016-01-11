<?php 
session_start();

if (!isset($_SESSION['isLogged'])) {
    header("Location: login.php");
    exit();
}

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
	</div>
    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') : ?>
        <?php
            require 'expensesDB.php';
            require 'earningsDB.php';
            $success = false;
            $all_expenses_sum = (new ExpensesDB())->getAllExpenses($_POST);
            $all_earnings_sum = (new EarningsDB())->getAllEarnings($_POST);

            if ($all_earnings_sum->sum != null && $all_expenses_sum->sum == null) {
                $all_expenses_sum->sum = 0;
                $success = true;
            }
            if ($all_earnings_sum->sum == null && $all_expenses_sum->sum != null) {
                $all_earnings_sum->sum = 0;
                $success = true; 
            }
            if ($all_earnings_sum->sum != null && $all_expenses_sum->sum != null) {
                $success = true;
            }
        ?>
    <?php endif; ?> 

    <div class="balance-container">
        <input type="radio" name="balance" value="day" ><label for="day"> Дневен</label>
        <form id="form-day-balance" action="" method="post" style="display: none">
            <label for="day">Ден</label>
            <select name="day" class="info">
                <?php for ($i=1; $i<=31;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="month">Месец</label>
            <select name="month" class="info">
                <?php for ($i=1; $i<=12;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="year">Година</label>
            <select name="year" class="info">
                <?php for ($i=2015; $i<=2100;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <input type="hidden" name="type_balance" value="day"><br>
            <input type="submit" value="Покажи" class="form-submit">
        </form>

        <br>
        <input type="radio" name="balance" value="week"><label for="week"> Седмичен</label>
        <form id="form-week-balance" action="" method="post" style="display: none">
            <label for="from">От</label><br>
            <label for="day">Ден</label>
            <select name="from_day" class="info">
                <?php for ($i=1; $i<=31;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="month">Месец</label>
            <select name="from_month" class="info">
                <?php for ($i=1; $i<=12;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="year">Година</label>
            <select name="from_year" class="info">
                <?php for ($i=2015; $i<=2100;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <br>
            <label for="to">До</label><br>
            <label for="day">Ден</label>
            <select name="to_day" class="info">
                <?php for ($i=1; $i<=31;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="month">Месец</label>
            <select name="to_month" class="info">
                <?php for ($i=1; $i<=12;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="year">Година</label>
            <select name="to_year" class="info">
                <?php for ($i=2015; $i<=2100;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <input type="hidden" name="type_balance" value="week"><br>
            <input type="submit" value="Покажи" class="form-submit">
        </form>
        <br>
        <input type="radio" name="balance" value="month" ><label for="month"> Месечен</label>
        <form id="form-month-balance" action="" method="post" style="display: none">
            <label for="month">Месец</label>
            <select name="month" class="info">
                <?php for ($i=1; $i<=12;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="year">Година</label>
            <select name="year" class="info">
                <?php for ($i=2015; $i<=2100;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <input type="hidden" name="type_balance" value="month"><br>
            <input type="submit" value="Покажи" class="form-submit">
        </form>
        <br>
        <input type="radio" name="balance" value="year" ><label for="year"> Годишен</label>
        <form id="form-year-balance" action="" method="post" style="display: none">
            <label for="year">Година</label>
            <select name="year" class="info">
                <?php for ($i=2015; $i<=2100;$i++) : ?>
                    <option value="<?= $i; ?>"><?= $i; ?></option>
                <?php endfor; ?>
            </select>
            <input type="hidden" name="type_balance" value="year"><br>
            <input type="submit" value="Покажи" class="form-submit">
        </form>
        <table>
                <th>Приходи</th>
                <th>Разходи</th> 
                <th>Баланс</th>
            <?php if (isset($success) && $success == true) : ?>
               <tr>
                    <td><?= $all_earnings_sum->sum;?></td> 
                    <td><?= $all_expenses_sum->sum; ?></td>
                    <td><?= ($all_earnings_sum->sum - $all_expenses_sum->sum); ?></td>
               </tr>
        </table>       
            <?php elseif(isset($success) && $success == false) : ?>
                <p>Нямате въведени приходи и разходи за избрания период</p>
            <?php endif;?>
        </table>
    </div>    
</body>
</html>