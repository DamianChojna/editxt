<?php

namespace Editxt\ContentBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Editxt\ContentBundle\Entity\ContentItem;

class ContentItemsFixtures extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        foreach($this->getData() as $key => $title) {
            $obj = new ContentItem;

            $obj->setBody($title);
            $obj->setTitle($title);
            $obj->addTag($this->getReference('tag_'.rand(0,6)));
            $obj->addTag($this->getReference('tag_'.rand(0,6)));

            $this->addReference('contentItem_'.$key, $obj);
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
            'Lorem Ipsum, aber der Hauptteil erlitt �nderungen',
            'Ipsum dolor sit amet',
            'Nam libero tempore, cum soluta nobis est eligendi',
            'Example',
            'Sed incididunt ut labore et dolore magna aliqua',
            'Aber der Hauptteil erlitt �nderungen'
        );
    }

    public function getOrder() {
        return 10;
    }
}