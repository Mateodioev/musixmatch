<?php 

namespace Musixmatch;

use Musixmatch\MusixmatchRequest;

class Musixmatch {
  
  public static $request;
  public static string $apiKey;

  /**
   * Add api key
   * @link https://developer.musixmatch.com/
   */
  public static function SetApiKey(string $key)
  {
    self::$apiKey = $key;
  }

  /**
   * Add api key form .env file
   *
   * @param   string  $dir  Dir of .env file
   */
  public static function SetApiKeyEnv(?string $dir = null)
  {
    $dir = $dir ?? __DIR__;
    $dotenv = \Dotenv\Dotenv::createImmutable($dir);
    $dotenv->load();

    self::$apiKey = $_ENV['MUSIXMATCH_API_KEY'] ?? '';
  }

  /**
   * Get Musix Match client
   */
  private static function GetClient(int $timeout = 2): void
  {
    if (empty(self::$apiKey)) {
      throw new \Exception("Add your api key with method " . __CLASS__ . '::SetApiKey($apiKey)');
    }

    if (self::$request == null) {
      self::$request = new MusixmatchRequest([
        'query' => [
          'apikey' => self::$apiKey,
          'format' => 'json',
        ],
        'timeout' => $timeout
      ]);
    }
  }

  /**
   * Send any method to api endpoint
   * 
   * @param   string  $method  Api method
   * @param   array   $opt  Require api parameters
   * @param   bool    $decode  True to return array, false to return json string
   * 
   * @api https://api.musixmatch.com/ws/1.1/
   * @link https://developer.musixmatch.com/documentation/api-methods
   * 
   * @return  array|string     MusixMatch api response
   */
  public static function Send(string $method, array $opt = [], bool $decode = false)
  {
    self::GetClient();

    return self::$request->SendEndPoint($method, $opt, $decode);
  }
}