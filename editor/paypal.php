<html>
<head>
    <title>Payment with Paypal</title>
</head>
<body>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <!-- Identify your business so that you can collect the payments. -->
        <input type="hidden" name="business" value="Enter your business paypal ID">
        <!-- Specify a Buy Now button. -->
        <input type="hidden" name="cmd" value="_xclick">
        <!-- Specify details about the item that buyers will purchase. -->
        <input type="text" name="item_number" placeholder="Enter product ID">
        <input type="number" name="amount" placeholder="Enter price">
        <input type="hidden" name="currency_code" value="USD">
        <!-- Specify URLs -->
        <input type='hidden' name='cancel_return' value='{cancel_url}'>
        <input type='hidden' name='return' value='{success_url}'>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>
