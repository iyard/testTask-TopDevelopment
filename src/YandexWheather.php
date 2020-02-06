<?php


namespace App;


use App\formatters\Formatter;
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
    private $_config;
    private $_lat;
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
    private function getRequestMethod()
    {
        return $this->_config['requestMethod'];
    }

    /**
     * @return mixed
     */
    private function getRequestUrl()
    {
        return $this->_config['requestUrl'];
    }

    /**
     * @return mixed
     */
    private function getRequestHeaders()
    {
        return $this->_config['requestHeaders'];
    }

    /**
     * @return mixed
     */
    private function getRequestLanguage()
    {
        return $this->_config['requestLanguage'];
    }

    /**
     * @return mixed
     */
    private function getLat()
    {
        return $this->_lat;
    }

    /**
     * @return mixed
     */
    private function getLon()
    {
        return $this->_lon;
    }

    /**
     * Return formatted weather
     *
     * @param string $format
     * @param string $lat
     * @param string $lon
     * @return string
     */
    public function get(string $format, $lat = self::LAT_DEFAULT, $lon = self::LON_DEFAULT) : string
    {
        $this->_lat = $lat;
        $this->_lon = $lon;
        $formatter = Formatter::getInstance($format);

        if (!$response = $this->sendRequest()) {
            return '';
        };
        $weather = $this->getWeather($response);
        return $formatter->format($weather);
    }

    public function getResponseBody($response)
    {
        return (string) $response->getBody();
    }

    /**
     * @param $response
     * @return string
     */
    private function getWeather($response)
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
