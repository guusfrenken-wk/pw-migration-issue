<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        $user = (new User())
            ->setEmail('test@test.com')
            ->setIsLegacy(true);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'secret'
        );

        $user->setPassword($hashedPassword);

         $manager->persist($user);

        $manager->flush();
    }
}
