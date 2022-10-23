<?php
namespace PhpPro\Convertor\Helpers;

use InvalidArgumentException;
use PhpPro\Convertor\Interfaces\IUrlValidator;

class UrlValidator implements IUrlValidator
{
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
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return (!empty($response) && in_array($response, $correctCodes));
    }
}
