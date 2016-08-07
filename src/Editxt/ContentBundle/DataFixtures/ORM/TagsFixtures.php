<?php

namespace Editxt\ContentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Editxt\ContentBundle\Entity\Tag;

class TagsFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        foreach($this->getData() as $key => $title) {
            $obj = new Tag;
            $obj->setName($title);
            $this->addReference('tag_'.$key, $obj);
            $manager->persist($obj);
        }
        $manager->flush();
    }

    function getData() {
        return array(
            'Saski',
            'Poland',
            'Germany',
            'Santa Maria',
            'Muzem',
            'Sea',
            'Clubs'
        );
    }

    public function getOrder() {
        return 5;
    }
}