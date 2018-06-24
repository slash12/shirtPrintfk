<?php

$sqlCommand = "SELECT user_id, username FROM tbl_user WHERE username='".$_SESSION['admin']."'";
$query =mysqli_query($dbc, $sqlCommand);

while ($row=mysqli_fetch_array($query)) {
  $pid = $row['user_id'];
  $username =$row['username'];

}

//check for new messages..
$sqlCommand = "SELECT COUNT(id) AS numbers FROM pm_inbox WHERE userid ='$pid' AND viewed='0'";
$query = mysqli_query($dbc, $sqlCommand);
$result = mysqli_fetch_assoc($query);
$inboxMessagesNew = $result ['numbers'];

//check for all messages in the inbox
$sqlCommand = "SELECT COUNT(id) AS numbers FROM pm_inbox WHERE userid = '$pid'";
$query = mysqli_query($dbc , $sqlCommand);
$result = mysqli_fetch_assoc($query);

$inboxMessagesTotal = $result['numbers'];

//check for all messages in the outbox
$sqlCommand = "SELECT COUNT(id) AS numbers FROM pm_outbox WHERE userid = '$pid'";
$query = mysqli_query($dbc , $sqlCommand);
$result = mysqli_fetch_assoc($query);

$outboxMessages = $result['numbers'];

?>


<?php if($_SESSION['admin']) {?>

<div class="message_button">
  <center>
        <!--inbox button-->
        <div class="svg-wrapper">
          <svg height="40" width="150" xmlns="http">
            <rect id="shape" height="40" width="150" />
            <div id="text">
              <a href="pm_inbox.php">Inbox <?php if($inboxMessagesNew>0) {print"<b>New*(".$inboxMessagesNew.")</b>";}
                else{}?> (<?php print $inboxMessagesTotal; ?>) <img src="../images/icons/inbox.png" height="20px" width="20px;">
            </a>
            </div>
          </svg>
        </div>
        <!--outbox button -->
        <div class="svg-wrapper">
          <svg height="40" width="150" >
            <rect id="shape" height="40" width="150" />
            <div id="text">
              <a href="pm_outbox.php">Outbox( <?php print $outboxMessages; ?> )<img src="../images/icons/outbox.png" height="20px" width="20px;"></a>
            </div>
          </svg>
        </div>
        <!--Send mesg button -->
        <div class="svg-wrapper">
          <svg height="40" width="150">
            <rect id="shape" height="40" width="150" />
            <div id="text">
              <a href="pm_send.php">Send message <?php } ?><img src="../images/icons/send_message.png" height="20px" width="20px;"></a>
            </div>
          </svg>
        </div>
  </center>
</div>
