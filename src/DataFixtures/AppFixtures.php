<?php

namespace App\DataFixtures;

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

        $usedEmails = [];
        $users = [];
        for ($i = 0; $i < self::NBUSERS; $i++) {

            $uniqueEmail = $faker->unique()->freeEmail();
            while (in_array($uniqueEmail, $usedEmails)) {
                $uniqueEmail = $faker->unique()->freeEmail();
            }
            $usedEmails[] = $uniqueEmail;

            $user = new User();
            $user
                ->setPseudo($faker->userName())
                ->setPassword('password')
                ->setEmail($uniqueEmail)
                ->setGender($faker->boolean(50))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setBirthDate($faker->dateTimeBetween('-75 years', '-18 years'))
                ->setAddress($addresses[$i])
                ->setProfilPicture('../assets/profile-picture.webp');
            
                $manager->persist($user); 
                $users[] = $user;
        }

        
        $adminUser = new User();
       
            $adminUser
                ->setPseudo('admin')
                ->setRoles(["ROLE_ADMIN"])
                ->setPassword('admin')
                ->setEmail($faker->unique()->freeEmail())
                ->setGender($faker->boolean(50))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setBirthDate($faker->dateTimeBetween('-75 years', '-18 years'))
                ->setAddress($addresses[$i])
                ->setProfilPicture('../assets/profile-picture.webp');
            
                $manager->persist($adminUser); 
         
        

        $categories = [];
        for ($i = 0; $i < self::NBCATEGORIES; $i++) {

        $category = new Category();
        $category ->setName($faker->word()); 
        $category ->setDescription($faker->text());          
        $manager->persist($category);

        $categories[] = $category;
        }


        $nfts = [];
        for ($i = 0; $i < self::NBNFTS; $i++) {
            $nft = new Nft();
            $nft ->setName($faker->word());
            $nft ->setImg('../assets/profile-picture.webp');
            $nft ->setLaunchDate($faker->dateTimeBetween('-2 years', '-1 years'));
            $nft ->setDescription($faker->paragraph());
            $nft ->setCategory($categories[rand(0, self::NBCATEGORIES - 1)]);
            $nft ->setLaunchPriceEur($faker->randomFloat(2, 10000000000));
            $nft ->setLaunchPriceEth($faker->randomFloat(2, 10000000000));
            $manager->persist($nft);

            
            $nfts[] = $nft;
        }

        $manager->flush();

    }
}
