<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Nft;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    const NBCATEGORIES = 3;
    const NBNFTS = 20;
    const NBADDRESSES = 11;
    const NBUSERS = 10;


    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $addresses = [];
        for ($i = 0; $i < self::NBADDRESSES; $i++) {
            $userAddress = new Address();
            $userAddress
                ->setCity($faker->city())
                ->setZIPCode($faker->postcode())
                ->setStreet($faker->streetAddress());

            $manager->persist($userAddress);

            $addresses[] = $userAddress;
        }

        $users = [];
        for ($i = 0; $i < self::NBUSERS; $i++) {

            $user = new User();
            $user
                ->setPseudo($faker->userName())
                ->setRoles(["ROLE_USER"])
                ->setPassword($this->passwordHasher->hashPassword($user, "password"))
                ->setEmail($faker->freeEmail())
                ->setGender($faker->boolean(50))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setBirthDate($faker->dateTimeBetween('-75 years', '-18 years'))
                ->setAddress($addresses[$i])
                ->setProfilPicture($faker->imageUrl(200, 200));

            $manager->persist($user);
            $users[] = $user;
        }


        $adminUser = new User();

        $adminUser
            ->setPseudo('admin')
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->passwordHasher->hashPassword($adminUser, 'admin'))
            ->setEmail($faker->freeEmail())
            ->setGender($faker->boolean(50))
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setBirthDate($faker->dateTimeBetween('-75 years', '-18 years'))
            ->setAddress($addresses[10])
            ->setProfilPicture('../assets/profile-picture.webp');

        $manager->persist($adminUser);



        $categories = [];
        for ($i = 0; $i < self::NBCATEGORIES; $i++) {

            $category = new Category();
            $category->setName($faker->word());
            $category->setDescription($faker->text(300));
            $manager->persist($category);

            $categories[] = $category;
        }



        for ($i = 0; $i < self::NBNFTS; $i++) {
            $nft = new Nft();
            $nft->setName($faker->word());
            $nft->setImg($faker->imageUrl(200, 200));
            $nft->setStock($faker->numberBetween(1, 10));
            $nft->setLaunchDate(new DateTime($faker->date()));
            $nft->setDescription($faker->paragraph(1));
            $nft->setCategory($faker->randomElement($categories));
            $nft->setLaunchPriceEur($faker->randomFloat(2, 10000000000));
            $nft->setLaunchPriceEth($faker->randomFloat(2, 10000000000));
            $nft->setUser($faker->randomElement($users));

            $manager->persist($nft);

        }

        $manager->flush();
    }
}