<?php
namespace PhpPro\Convertor\Helpers;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use InvalidArgumentException;
use PhpPro\Convertor\Interfaces\IUrlValidator;



class UrlValidator implements IUrlValidator
{
    protected ClientInterface $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function validateUrl(string $url): bool
    {
        if(empty($url)
        || !filter_var($url, FILTER_VALIDATE_URL)
        || !$this->isUrl($url)) {
            throw new InvalidArgumentException ($url . ' - is not a correct url');
        }
        return true;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function isUrl(string $url): bool
    {
        $correctCodes = [
            200, 201, 301, 302
        ];
        try {
            $response = $this->client->request('GET', $url);
            return (!empty($response->getStatusCode()) && in_array($response->getStatusCode() , $correctCodes));
        } catch (ConnectException $exception) {
            throw new InvalidArgumentException($exception->getMessage(), $exception->getCode());
        }
    }
}
