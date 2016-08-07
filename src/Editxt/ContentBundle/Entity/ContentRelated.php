<?php

namespace Editxt\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Editxt\ContentBundle\Entity\Content;
use Editxt\ContentBundle\Entity\ContentItem;

/**
 * ContentRelated
 *
 * @ORM\Table("content_related")
 * @ORM\Entity(repositoryClass="Editxt\ContentBundle\Repository\ContentRelatedRepository")
 */
class ContentRelated
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Content", inversedBy="contentRelated", cascade={"persist"})
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="ContentItem", inversedBy="contentRelated", cascade={"persist"})
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="smallint", options={"default":0}, nullable=true)
     */
    private $weight = 0;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set weight
     *
     * @param integer $weight
     * @return ContentRelated
     */
    public function setWeight($weight = 0)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set content
     *
     * @param Content $content
     * @return ContentRelated
     */
    public function setContent(Content $content = null)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set item
     *
     * @param ContentItem $item
     * @return ContentRelated
     */
    public function setItem(ContentItem $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return ContentItem
     */
    public function getItem()
    {
        return $this->item;
    }
}
