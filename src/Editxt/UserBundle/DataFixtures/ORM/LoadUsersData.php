<?php

namespace Editxt\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Editxt\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUsersData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager) {
        
        $user = new User();
        $user->setId(21);
        $user->setUsername('editxt');
        $user->setEmail('admin@admin.pl');
        $user->setPlainPassword('editxt');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user);

        $manager->flush();
    }
    
    /**
    * {@inheritDoc}
    */
    public function getOrder()
    {
        return 1;
    }

}