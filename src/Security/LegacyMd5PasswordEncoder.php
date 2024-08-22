<?php

declare(strict_types=1);

namespace App\Security;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class LegacyMd5PasswordEncoder implements PasswordHasherInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws Exception
     */
    public function hash(string $plainPassword): string
    {
        return md5($plainPassword);
    }

    /**
     * @throws Exception
     */
    public function verify(string $hashedPassword, string $plainPassword): bool
    {
        return $hashedPassword === $this->hash($plainPassword);
    }

    public function needsRehash(string $hashedPassword): bool
    {
        return true;
    }
}
