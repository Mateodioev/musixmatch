<?php require __DIR__ . '/../vendor/autoload.php';

use Musixmatch\Musixmatch;

// Load api key from .env file
Musixmatch::SetApiKeyEnv(__DIR__); // or Musixmatch::SetApiKey('YOUR API KEY HERE');

/**
 * Basic example
 * 
 * Musixmatch::Send('method_name', ['parameters']);
 */


// Get the list of the top artists of a given country.
$response = Musixmatch::Send('chart.artists.get', [
  'country' => 'it',
  'page' => 1,
  'page_size' => 2
]); // Return string
print_r($response);


// Search for track in our database.
// See more in https://developer.musixmatch.com/documentation/api-reference/track-search
$response = Musixmatch::Send('track.search', [
  'q_track' => '', // The song title
  'q_artist' => 'justin bieber', // The song artist
  'page' => 1, // Define the page number for paginated results
  'page_size' => 2 // Define the page size for paginated results. Range is 1 to 100.
], true); // Return array
print_r($response);
