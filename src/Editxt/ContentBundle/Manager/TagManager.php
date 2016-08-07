<?php

namespace Editxt\ContentBundle\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;
use Editxt\ContentBundle\Repository\TagRepository;
use Editxt\ContentBundle\Entity\Tag;
use Editxt\ContentBundle\Manager\Manager;

class TagManager implements Manager {

    public $em;
    public $entityClass;
    public $repository;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->em = $managerRegistry->getManager();
    }

    public function setEntityClass($entity) {
        $this->entityClass = $entity;
        $this->repository = $this->em->getRepository($entity);
    }

    public function manageTags( $names)
    {
        foreach($names as $k=>$name)
        {
            $name = trim($name);
            if(!empty($name))
            {
                $tagExist = $this->repository->findNameOrNullResult($name);

                if(!empty($tagExist))
                {
                    $names[$k] = $tagExist;
                }else{
                    $tag = $this->create($name);
                    $names[$k] = $tag;
                }
            }else{
                unset($names[$k]);
            }
        }


        return $names;
    }

    public function create($name)
    {
        $tag = new $this->entityClass;
        $tag->setName($name);
        $this->em->persist($tag);
        $this->em->flush();

        return $tag;
    }
}
