<?php
require_once '../classes/google-api/vendor/autoload.php';

$client = new Google\Client();
$client->setApplicationName("nikoo-academy-project01");
$client->setDeveloperKey("AIzaSyAM_HXW3GR8HAGq6MDsQ6bxzGTEyz-cYCs");

$service = new Google\Service\Books($client);
$query = 'Henry David Thoreau';
$optParams = [
  'filter' => 'free-ebooks',
];
$results = $service->volumes->listVolumes($query, $optParams);

foreach ($results->getItems() as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}
?>