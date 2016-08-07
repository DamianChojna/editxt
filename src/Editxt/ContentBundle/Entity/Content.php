<?php

namespace Editxt\ContentBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Collection;
use Editxt\ContentBundle\Entity\ContentRelated;

/**
 * Content
 *
 * @ORM\Table(name="contents")
 * @ORM\Entity(repositoryClass="Editxt\ContentBundle\Repository\ContentRepository")
 */
class Content
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="update_date", type="datetime", nullable=true)
     */
    private $updateDate = null;

    /**
     * @ORM\OneToMany(targetEntity="ContentRelated", mappedBy="content", cascade={"persist"})
     */
    private $contentRelated;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contentRelated = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Content
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

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Content
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Content
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime 
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Add contentRelated
     *
     * @param ContentRelated $contentRelated
     * @return Content
     */
    public function addContentRelated(ContentRelated $contentRelated)
    {
        $contentRelated->setContent($this);

        $this->contentRelated->add($contentRelated);

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
     * @return Collection
     */
    public function getContentRelated()
    {
        return $this->contentRelated;
    }
}
