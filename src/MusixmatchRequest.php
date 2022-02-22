<?php 

namespace Musixmatch;

use GuzzleHttp\Client;

class MusixmatchRequest {
  
  const API_URL = 'http://api.musixmatch.com/ws/1.1/';

  private $client;

  public $query;
  public $request;
  public $response;

  /**
   * Create Guzzle Client
   */
  public function __construct($opt = [])
  {
    if (isset($opt['query'])) {
      $this->query = $opt['query'];
      unset($opt['query']);
    }

    $config = array_merge(['base_uri' => self::API_URL], $opt);
    $this->client = new Client($config);

  }

  /**
   * Emulate Guzzle\Client 5 defaults query
   */
  public function Query(array $def = []):array
  {
    if ($this->query === null) {
      $this->query = $def;
    }
    $this->query = array_merge($this->query, $def);
    return $this->query;
  }

  /**
   * @param   string  $method  
   * @param   array   $params  Require api parameters
   * @param   bool    $decode  True to return array, false to return json string
   * @return  array|string     MusixMatch api response
   * 
   * @link https://developer.musixmatch.com/documentation/api-methods
   */
  public function SendEndPoint(string $method, array $params = [], bool $decode = false)
  {
    $this->request =  $this->client->request('GET', $method, [
      'query' => $this->Query($params)
    ]); // Send request
    
    $this->response = $this->request->getBody()->getContents(); // Get response
    return $decode ? json_decode($this->response, true) : $this->response;
  }
}