<?php
require_once 'ShowtimeXSLT.php';
require_once 'Booking/BookingXML.php';
require_once 'Decorator/BaseHall.php';
require_once 'Decorator/LuxeDecorator.php';
require_once 'Decorator/DeluxeDecorator.php';
session_start();
?>

<!DOCTYPE html
    <html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="Payment.css">
</head>
<body>
    <?php
    //echo $_POST['adults'];
    //Display Order Summary https://i.imgur.com/T7Aje7g.png
    //Display PayPal and Credit Card Payment
    //Ticket : https://i.imgur.com/2ikZXWk.png
    ?>
    
    <?php
    if (isset($_GET['id'])) {
        $showtimeId = $_GET['id'];
        $xmlGenShowtime = new ShowtimeXSLT($showtimeId);
        $bookingXML = new BookingXML($_SESSION['userId']);
        $bookingXML->createBookingElement($showtimeId);
        $bookingXML->createSeatElement();
        
        $hall = new BaseHall(10);
        $luxe = new LuxeDecorator($hall);
        
        echo "<br/>Luxe Hall: <br/>Price:" . $luxe->cost() . "<br/>Experience: " . $luxe->experience();
        
        $deluxe = new DeluxeDecorator($hall);
        
        echo "<br/><br/><br/>Deluxe Hall: <br/>Price:" . $deluxe->cost() . "<br/>Experience: " . $deluxe->experience();
        
        //Generate Booking.xml for the User
        //Append the Showtime.xml inside the Booking.xml as a Child Node
        //Append the UsersSeats[userID].xml inside the Booking.xml as a Child node
        //Calculate the price of the ticket using Hall Decorator -> 1. Get The Hall Type -> 2. Apply the appropriate decorator
        //Add price element inside the Booking.xml for each seat
        //Have 2 buttons for Payment (paypal and credit card)
        //Upon submission Add Payment Method to Booking.xml
        //Proceed to Receipt page
        
        //This is just an idea. You could have Ticket Decorator for Kids, Adults and Double Seat.
    }
    ?>

    <div class="order-summary-section">
        <h3><center>Order Summary</center></h3>
    </div>
</body>
</html>
