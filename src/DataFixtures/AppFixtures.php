<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;
use Bezhanov\Faker\Provider\Commerce;
use Faker\Factory;
use Faker\Generator;
use Nelmio\Alice\Faker\Provider\AliceProvider;
use Nelmio\Alice\Throwable\LoadingThrowable;

class AppFixtures extends Fixture
{
    public function createFaker(): Generator
    {
        $faker = Factory::create();

        $faker->addProvider(new AliceProvider());
        $faker->addProvider(new Commerce($faker));

        return $faker;
    }

    public function load(ObjectManager $manager): void
    {
        $fixturesFile = __DIR__ . '/fixtures.yml';
        $entity = new NativeLoader($this->createFaker());
        try {
            $entities = $entity
                ->loadFile($fixturesFile)
                ->getObjects();
        } catch (LoadingThrowable $e) {
            throw new \LogicException(sprintf('Unable to load fixtures file [%s].', $fixturesFile), 0, $e);
        }

        foreach ($entities as $entity) {
            if (!$this->isEntity(get_class($entity), $manager)) {
                continue;
            }
            $manager->persist($entity);
        }

        $manager->flush();
    }

    private function isEntity(string $className, ObjectManager $manager): bool
    {
        return !$manager->getMetadataFactory()
            ->isTransient($className)
        ;
    }
}
