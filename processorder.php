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
        
        define('TIREPRICE', 100);
        difine('OILPRICE', 10);
        define('SPARKPRICE', 4);        
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
        <?php
        $totalqty = 0;
        $totalqty = $tireqty + $oilqty + $sparkqty;
        echo "<p>Items ordered: ".$totalqty."<br />";
        $totalamount = 0.00;
      
        $totalamount = $tireqty * TIREPRICE + $oilqty * OILPRICE + $sparkqty * SPARKPRICE;
        echo "Subtotal: $".number_format($totalamount,2)."<br />";

        $taxrate = 0.10; //local sales tax is 10%
        $totalamount = $totalamount * (1 + $taxrate);
        echo "Total including tax: $".number_format($totalamount,2)."</p>";
        ?>
    </body>
</html>

