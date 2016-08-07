<?php


namespace Editxt\ContentBundle\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;

interface Manager {

    public function __construct(ManagerRegistry $managerRegistry);

    public function manageTags($names);

    public function create($name);

    public function setEntityClass($entity);

}