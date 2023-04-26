<?php
require_once '../classes/google-api/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=../classes/google-api/keys/nikoo-academy-lms-edcd53a2ccc3.json');

$client = new Google\Client();
$client->setApplicationName("nikoo-academy-project01");
//$client->useApplicationDefaultCredentials();

//$client->setAuthConfig("../classes/google-api/keys/nikoo-academy-crm-9287e005b9fe.json");
//$client->setAuthConfig("../classes/google-api/keys/nikoo-academy-lms-edcd53a2ccc3.json");

$client->setAuthConfig("../classes/google-api/keys/client_secret_1097964749705-117622p74v5mpfsu8be9f314p56ke7cs.apps.googleusercontent.com.json");

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
echo $redirect_uri;
$client->setRedirectUri($redirect_uri);
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
}
echo "Token:".$token;

//nikooacademy-calendar@nikoo-academy-project01.iam.gserviceaccount.com
$client->addScope(Google\Service\Calendar::CALENDAR,Google\Service\Calendar::CALENDAR_EVENTS);
$client->setScopes([\Google_Service_Calendar::CALENDAR, \Google_Service_Calendar::CALENDAR_EVENTS]);
$client->setAccessType( 'offline' );
$client->setSubject('nikooaiacademy@gmail.com');

$service = new Google\Service\Calendar($client);

echo "<pre>";
print_r($client);
echo "<hr/>";
//print_r($service);
echo "</pre>";

$calendarList = $service->calendarList->listCalendarList();

while(true) {
  foreach ($calendarList->getItems() as $calendarListEntry) {
    echo $calendarListEntry->getSummary();
  }
  $pageToken = $calendarList->getNextPageToken();
  if ($pageToken) {
    $optParams = array('pageToken' => $pageToken);
    $calendarList = $service->calendarList->listCalendarList($optParams);
  } else {
    break;
  }
}
die;

$event = new Google_Service_Calendar_Event(array(
    'summary' => 'Nikoo Academy',
    'location' => 'Online Class',
    'description' => 'Python Class',
    'start' => array(
      'dateTime' => '2022-06-11T17:00:00+03:30',
      'timeZone' => 'Asia/Tehran',
    ),
    'end' => array(
      'dateTime' => '2022-06-11T18:00:00+03:30',
      'timeZone' => 'Asia/Tehran',
    ),
    'attendees' => array(
      array('email' => 'masoud.nikoofar@gmail.com'),
    ),
    'reminders' => array(
      'useDefault' => FALSE,
      'overrides' => array(
        array('method' => 'popup', 'minutes' => 15),
      ),
    ),
  ));
  
  $calendarId = 'primary';
  $event = $service->events->insert($calendarId, $event);
  printf('Event created: %s\n', $event->htmlLink);
?>


