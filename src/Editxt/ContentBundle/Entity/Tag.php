<?php

namespace Editxt\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Editxt\ContentBundle\Entity\ContentItem;
use Doctrine\Common\Collections\ArrayCollection;
use Editxt\ContentBundle\Entity\AbstractTaxonomy;

/**
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="Editxt\ContentBundle\Repository\TagRepository")
 */
class Tag extends AbstractTaxonomy {

    /**
     * @ORM\ManyToMany(targetEntity = "ContentItem", mappedBy = "tags", cascade={"persist"})
     */
    protected $contentItems;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contentItems = new ArrayCollection();
    }

    /**
     * Add contentItems
     *
     * @param \Editxt\ContentBundle\Entity\ContentItem $contentItem
     * @return Tag
     */
    public function addContentItem(\Editxt\ContentBundle\Entity\ContentItem $contentItem)
    {
        if (!$this->contentItems->contains($contentItem)) {
            $this->contentItems->add($contentItem);
        }
        return $this;
    }

    /**
     * Remove contentItems
     *
     * @param \Editxt\ContentBundle\Entity\ContentItem $contentItems
     */
    public function removeContentItem(\Editxt\ContentBundle\Entity\ContentItem $contentItems)
    {
        $this->contentItems->removeElement($contentItems);
    }

    /**
     * Get contentItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContentItems()
    {
        return $this->contentItems;
    }
}
