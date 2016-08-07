<?php

namespace Editxt\ContentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Editxt\ContentBundle\Entity\ContentRelated;

class ContentRelatedFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        for($i=0; $i<15; $i++) {
            for($j=0; $j<15; $j++) {
                $obj = new ContentRelated;
                $obj->setContent($this->getReference('content_'.$i));
                $obj->setItem($this->getReference('contentItem_'.$j));
                $obj->setWeight($j);
                $manager->persist($obj);
            }
        }
        $manager->flush();
    }



    public function getOrder() {
        return 20;
    }
}