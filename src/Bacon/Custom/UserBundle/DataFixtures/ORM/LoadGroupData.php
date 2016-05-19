<?php
namespace Bacon\Custom\UserBundle\DataFixtures\ORM;

use Bacon\Custom\UserBundle\Entity\Group;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 * @author Adan Felipe Medeiros <adan.grg@gmail.com>
 */
class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $groupManager   = $this->container->get('fos_user.group_manager');
        $className      = $groupManager->getClass();

        $groupAdmin = new $className('Administrator');
        $manager->persist($groupAdmin);
        $this->addReference('admin-group', $groupAdmin);

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }
}
