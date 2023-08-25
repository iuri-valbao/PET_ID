<!DOCTYPE html>
<html>
    <head>
        <title>Bob's Auto Parts  -  Order Results</title>
    </head>
    <body>
        <?php
        //create short variable names
        $tireqty = $_POST['tireqty'];
        $oilqty = $_POST['oilqty'];
        $sparkqty = $_POST['sparkqty'];
        ?>
        <h1>Bob's Auto Parts</h1>
        <h2>Order Results</h2>
        <?php
            echo "<p>Order processed at ".date('H:i, jS F Y')."</p>";
        ?>
        <?php
        echo '<p>Your order is as follows:</p>';
        $tireqty = htmlspecialchars($tireqty);
        $oilqty = htmlspecialchars($oilqty);
        $sparkqty = htmlspecialchars($sparkqty);
        echo "$tireqty t__ires<br />"."$oilqty b__ottles of oil<br/>"."$sparkqty s__park plugs";
        ?>
    </body>
</html>

