<?php

namespace Editxt\ContentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Editxt\ContentBundle\Entity\Content;

class ContentsFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        foreach($this->getData() as $key => $title) {
            $obj = new Content;

            $obj->setTitle($title);
            $obj->setCreateDate(new \DateTime());
            $obj->setUpdateDate(null);

            $this->addReference('content_'.$key, $obj);
            $manager->persist($obj);
        }
        $manager->flush();
    }

    function getData() {
        return array(
            '914 von H. Rackham',
            'Sektion 1.10.32 des "de Finibus Bonorum et Malorum"',
            'Die Standardpassage',
            'Lorem Ipsum ist nicht nur ein',
            'Es gibt viele Variationen',
            'Lorem ipsum dolor sit amet',
            'Nam libero tempore, cum soluta nobis est eligendi',
            'To take a trivial example',
            'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
            'Lorem Ipsum, aber der Hauptteil erlitt Änderungen',
            'Ipsum dolor sit amet',
            'Nam libero tempore, cum soluta nobis est eligendi',
            'Example',
            'Sed incididunt ut labore et dolore magna aliqua',
            'Aber der Hauptteil erlitt Änderungen'
        );
    }

    public function getOrder() {
        return 10;
    }
}