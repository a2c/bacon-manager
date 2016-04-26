<?php
namespace Bacon\Custom\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        // Create a new user
        $user = $userManager->createUser();
        $user->setUsername('admin');
        $user->setEmail('adan.medeiros@a2c.com.br');
        $user->setPlainPassword('123');
        $user->setEnabled(true);
        $user->addRole('ROLE_ADMIN');

        $manager->persist($user);

        $manager->flush();
    }
}
