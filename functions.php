<?php
$conn = mysqli_connect("localhost", "root", "", "laundry");
function checkUserSession() {
    if (!isset($_SESSION['email']) && !isset($_SESSION['name'])) {
        header("Location: login.php");
    } else {
        $email = $_SESSION['email'];
        $name = $_SESSION['name'];
    }
}

function userInfo($email) {
    $userInfoQ = mysqli_query($conn, "SELECT * from users where email = $email");
    }

function secondsToTime($inputSeconds) {
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;

    // Extract days
    $days = floor($inputSeconds / $secondsInADay);

    // Extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // Extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // Extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // Format and return
    $timeParts = [];
    $sections = [
        'day' => (int)$days,
        'hour' => (int)$hours,
        'minute' => (int)$minutes,
        'second' => (int)$seconds,
    ];

    foreach ($sections as $name => $value){
        if ($value > 0){
            $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
        }
    }

    return implode(', ', $timeParts);
}

function make_query($conn, $issue_id)
{

$conn = mysqli_connect("localhost", "root", "", "laundry");
$query = "SELECT * FROM media where issue_id = '$issue_id'";
$result = mysqli_query($conn, $query);
 return $result;
}

function make_slide_indicators($conn, $issue_id)

{
 $output = ''; 
 $count = 0;
 $result = make_query($conn, $issue_id);
 while($row = mysqli_fetch_array($result))
 {
  if($count == 0)
  {
   $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'" class="active"></li>
   ';
  }
  else
  {
   $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="'.$count.'"></li>
   ';
  }
  $count = $count + 1;
 }
 return $output;
}

function make_slides($conn, $issue_id)
{
 $output = '';
 $count = 0;
 $result = make_query($conn, $issue_id);
 if (mysqli_num_rows($result) > 0 ) {
 while($row = mysqli_fetch_array($result))
 {
  if($count == 0)
  {
   $output .= '<div class="item active">';
  }
  else
  {
   $output .= '<div class="item">';
  }
  $output .= '
   <a href="javascript:;"><img class="fancybox" src="media/'.$row["media_name"].'" title="'.$row["caption"].'" /></a>
   <div class="carousel-caption">
   </div>
  </div>
  ';
  $count = $count + 1;
 }
  return $output;
} else {
    $output = '<p>No Media For This Issue!</p>';
 return $output;
}
}
?>
