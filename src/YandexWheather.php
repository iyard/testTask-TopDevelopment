<?php


namespace App;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;


class YandexWheather
{
    const LAT_DEFAULT = '55.75396';
    const LON_DEFAULT = '37.620393';

    /**
     * @var Client
     */
    private $_httpClient;

    /**
     * @var array
     */
    private $_config;

    /**
     * @var string
     */
    private $_lat;

    /**
     * @var string
     */
    private $_lon;

    public function __construct($httpClient)
    {
        $this->_httpClient = $httpClient;

        $config = include('config.php');
        $this->_config = $config['yandexWeather'];
    }

    /**
     * @return mixed
     */
    private function getRequestMethod() : string
    {
        return $this->_config['requestMethod'];
    }

    /**
     * @return mixed
     */
    private function getRequestUrl() : string
    {
        return $this->_config['requestUrl'];
    }

    /**
     * @return mixed
     */
    private function getRequestHeaders() : array
    {
        return $this->_config['requestHeaders'];
    }

    /**
     * @return mixed
     */
    private function getRequestLanguage() : string
    {
        return $this->_config['requestLanguage'];
    }

    /**
     * @return mixed
     */
    private function getLat() : string
    {
        return $this->_lat;
    }

    /**
     * @return mixed
     */
    private function getLon() : string
    {
        return $this->_lon;
    }

    /**
     * Return formatted weather
     *
     * @param string $lat
     * @param string $lon
     * @return array
     */
    public function get($lat = self::LAT_DEFAULT, $lon = self::LON_DEFAULT) : array
    {
        $this->_lat = $lat;
        $this->_lon = $lon;

        if (!$response = $this->sendRequest()) {
            return [];
        };

        return  $this->getWeather($response);
    }

    /**
     * @param $response ResponseInterface
     * @return string
     */
    public function getResponseBody($response)
    {
        return (string) $response->getBody();
    }

    /**
     * @param $response ResponseInterface
     * @return array
     */
    private function getWeather($response) : array
    {
        $weather = json_decode($this->getResponseBody($response), true);
        return $weather['fact'];
    }

    /**
     * @return string
     */
    private function getQueryString() : string
    {
        return $this->getRequestUrl() . '?' . http_build_query($this->getRequestParams());
    }

    /**
     * @return array
     */
    private function getRequestParams() : array
    {
        return [
            'lat' => $this->getLat(),
            'lon' => $this->getLon(),
            'lang' => $this->getRequestLanguage()
        ];
    }

    /**
     * @return bool|ResponseInterface
     */
    private function sendRequest()
    {
        try {
            $response = $this->_httpClient->request($this->getRequestMethod(), $this->getQueryString(), [
                'headers' => $this->getRequestHeaders()
            ]);
        } catch (\Exception $exception) {
            echo ("Request Error\r\n");
            $response = false;
        }

        return $response;
    }
}
