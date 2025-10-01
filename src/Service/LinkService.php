<?php
namespace App\Service;

use App\Entity\Link;
use App\Repository\LinkRepository;

class LinkService
{
    public function __construct(private LinkRepository $repository) {}

    public function create(string $url, int $timeToLiveHours = 0): Link
    {
        $code = $this->generateCode();
        $expiresAt = $timeToLiveHours > 0 ? new \DateTimeImmutable("+{$timeToLiveHours} hours") : null;

        $link = new Link($url, $code, $expiresAt);
        $this->repository->save($link);

        return $link;
    }

    public function resolve(string $code): ?Link
    {
        return $this->repository->findOneBy(['shortCode' => $code]);
    }

    private function generateCode(int $length = 6): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($chars, $length)), 0, $length);
    }
}