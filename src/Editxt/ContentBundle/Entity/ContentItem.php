<?php

namespace Editxt\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Editxt\ContentBundle\Entity\ContentRelated;
use Editxt\ContentBundle\Entity\Tag;
use Editxt\ContentBundle\Entity\SubTitle;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table("content_items")
 * @ORM\Entity(repositoryClass="Editxt\ContentBundle\Repository\ContentItemRepository")
 */
class ContentItem
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
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @ORM\OneToMany(targetEntity="ContentRelated" , mappedBy="item" , cascade={"all"})
     */
    private $contentRelated;

    /**
     * @var integer
     */
    private $itemId;

    /**
     * @ORM\ManyToMany(
     *      targetEntity = "Tag",
     *      inversedBy = "contentItems",
     *      cascade={"persist"}
     * )
     *
     * @ORM\JoinTable(
     *      name = "content_item_tags"
     * )
     */
    private $tags;

    /**
     * @ORM\ManyToMany(
     *      targetEntity = "SubTitle",
     *      inversedBy = "contentItems",
     *      cascade={"persist"}
     * )
     *
     * @ORM\JoinTable(
     *      name = "content_item_subtitles"
     * )
     */
    private $subTitles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contentRelated = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->subTitles = new ArrayCollection();
    }

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
     * Set body
     *
     * @param string $body
     * @return ContentItem
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Add contentRelated
     *
     * @param ContentRelated $contentRelated
     * @return ContentItem
     */
    public function addContentRelated(ContentRelated $contentRelated)
    {
        if (!$this->contentRelated->contains($contentRelated)) {
            $contentRelated->setItem($this);
            $this->contentRelated->add($contentRelated);
        }

        return $this;
    }

    /**
     * Remove contentRelated
     *
     * @param ContentRelated $contentRelated
     */
    public function removeContentRelated(ContentRelated $contentRelated)
    {
        $this->contentRelated->removeElement($contentRelated);
    }

    /**
     * Get contentRelated
     *
     * @return ArrayCollection
     */
    public function getContentRelated()
    {
        return $this->contentRelated;
    }

    public function __toString() {

        return (string)$this->getId();

    }

    /**
     * Set itemId
     *
     * @param integer $id
     * @return ContentItem
     */
    public function setItemId($id)
    {
        $this->itemId = $id;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ContentItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function addTag(Tag $tag)
    {
        $tag->addContentItem($this);
        $this->tags->add($tag);

        return $this;
    }

    public function removeTag(Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function tagsToString()
    {
        $names = array();
        foreach($this->tags as $entity){
            $names[] = $entity->getName();
        }

        return implode(', ', $names);
    }

    public function setTags($tags)
    {

        $this->tags = $tags;

        return $this;
    }

    public function addSubTitle(SubTitle $entity)
    {
        $entity->addContentItem($this);
        $this->subTitles->add($entity);

        return $this;
    }

    public function subTitlesToString($postFix = ', ')
    {
        $names = array();
        foreach($this->subTitles as $entity){
            $names[] = $entity->getName();
        }

        return implode($postFix, $names);
    }

    public function removeSubTitle(SubTitle $entity)
    {
        $this->subTitles->removeElement($entity);
    }

    public function getSubTitles()
    {
        return $this->subTitles;
    }

    public function setSubTitles($SubTitles)
    {

        $this->subTitles = $SubTitles;

        return $this;
    }
}
