<?php

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

class LinkCreateRequest
{
    #[Assert\NotBlank(message: "URL не може бути пустим")]
    #[Assert\Url(message: "Введіть коректний URL")]
    #[Assert\Regex(
        pattern: '/^https:\/\//',
        message: "URL має містити https://"
    )]
    public ?string $url = null;

    #[Assert\NotBlank(message: "Час існування не може бути пустим")]
    #[Assert\Type(type: "integer", message: "Час існування має бути числом")]
    #[Assert\Positive(message: "Час існування має бути більше 0")]
    public ?int $timeToLive = null;
}