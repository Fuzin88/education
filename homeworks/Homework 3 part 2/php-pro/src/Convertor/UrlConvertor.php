<?php
namespace PhpPro\Convertor;

use InvalidArgumentException;
use PhpPro\Convertor\Interfaces\{
    ICodeRepository,
    IUrlEncoder,
    IUrlDecoder,
    IUrlValidator
};
use PhpPro\Convertor\Exceptions\DataNotFoundException;
use PhpPro\Convertor\ValueObjects\UrlCodePair;

class UrlConvertor implements IUrlEncoder, IUrlDecoder
{
    const CODE_LENGTH = 6;

    protected ICodeRepository $repository;
    protected int $codeLength;
    protected string $codeChairs = '0123456789abcdefghijklmnopqrstuvwxyz';

    protected IUrlValidator $validator;

    /**
     * @param ICodeRepository $repository
     * @param IUrlValidator $validator
     * @param int $codeLength
     */
    public function __construct(
        ICodeRepository $repository,
        IUrlValidator $validator,
        $codeLength = self::CODE_LENGTH )
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->codeLength = $codeLength;
    }

    /**
     * @param string $url
     * @return string
     * @throws InvalidArgumentException
     */
    public function encode(string $url): string
    {
        $this->validator->validateUrl($url);
        try {
            $code = $this->repository->getCodeByUrl($url);
        } catch (DataNotFoundException $e) {
            $code = $this->generateAndSaveCode($url);
        }
        return $code;
    }

    public function decode(string $code): string
    {
        try{
            $code = $this->repository->getUrlByCode($code);
        } catch (DataNotFoundException $e) {
            throw new InvalidArgumentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
        return $code;
    }

    protected function generateAndSaveCode(string $url): string
    {
        $code = $this->generateUniqueCode();
        $this->repository->saveEntity(new UrlCodePair($code, $url));
        return $code;
    }

    protected function generateUniqueCode(): string
    {
        $date = new \DateTime();
        $str = $this->codeChairs . mb_strtoupper($this->codeChairs) . $date->getTimestamp();
        return substr(str_shuffle($str), 0, $this->codeLength);
    }
}
