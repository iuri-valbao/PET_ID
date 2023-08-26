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
        
        define("TIREPRICE", 100);
        define("OILPRICE", 10);
        define("SPARKPRICE", 4);        
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
        echo "$tireqty tires<br />"."$oilqty bottles of oil<br/>"."$sparkqty spark plugs";
        ?>
        <?php
        $totalqty = 0;
        $totalqty = $tireqty + $oilqty + $sparkqty;
        echo "<p>Items ordered: ".$totalqty."<br />";
        $totalamount = 0.00;
      
        $totalamount = $tireqty * TIREPRICE + $oilqty * OILPRICE + $sparkqty * SPARKPRICE;
        echo "Subtotal: R$ ".number_format($totalamount,2)."<br />";

        $taxrate = 0.10; //local sales tax is 10%
        $totalamount = $totalamount * (1 + $taxrate);
        echo "Total including tax: R$ ".number_format($totalamount,2)."</p>";
        ?>
        <?php
        echo 'isset($tireqty) : '.isset($tireqty) . '<br />';
        echo 'isset($nothere) : '.isset($nothere) . '<br />';
        echo 'empty($tireqty) : '.empty($tireqty) . '<br />';
        echo 'empty($nothere) : '.empty($nothere) . '<br />';
        ?>        
    </body>
</html>

