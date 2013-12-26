<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LanguagesLabels
 *
 * @ORM\Table(name="languages_labels", indexes={@ORM\Index(name="language", columns={"language_id"}), @ORM\Index(name="module_id", columns={"module_id"}), @ORM\Index(name="isadmin", columns={"isbackend"}), @ORM\Index(name="isuniversal", columns={"isuniversal"})})
 * @ORM\Entity
 */
class LanguagesLabels
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label_name", type="string", length=80, nullable=true)
     */
    private $labelName;

    /**
     * @var string
     *
     * @ORM\Column(name="label_value", type="text", nullable=true)
     */
    private $labelValue;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="isbackend", type="integer", nullable=true)
     */
    private $isbackend = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="isuniversal", type="integer", nullable=true)
     */
    private $isuniversal = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50, nullable=true)
     */
    private $status = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="module_id", type="integer", nullable=true)
     */
    private $moduleId = '0';

    /**
     * @var \Application\Entity\Languages
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Languages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     * })
     */
    private $language;



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
     * Set labelName
     *
     * @param string $labelName
     * @return LanguagesLabels
     */
    public function setLabelName($labelName)
    {
        $this->labelName = $labelName;

        return $this;
    }

    /**
     * Get labelName
     *
     * @return string 
     */
    public function getLabelName()
    {
        return $this->labelName;
    }

    /**
     * Set labelValue
     *
     * @param string $labelValue
     * @return LanguagesLabels
     */
    public function setLabelValue($labelValue)
    {
        $this->labelValue = $labelValue;

        return $this;
    }

    /**
     * Get labelValue
     *
     * @return string 
     */
    public function getLabelValue()
    {
        return $this->labelValue;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return LanguagesLabels
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isbackend
     *
     * @param integer $isbackend
     * @return LanguagesLabels
     */
    public function setIsbackend($isbackend)
    {
        $this->isbackend = $isbackend;

        return $this;
    }

    /**
     * Get isbackend
     *
     * @return integer 
     */
    public function getIsbackend()
    {
        return $this->isbackend;
    }

    /**
     * Set isuniversal
     *
     * @param integer $isuniversal
     * @return LanguagesLabels
     */
    public function setIsuniversal($isuniversal)
    {
        $this->isuniversal = $isuniversal;

        return $this;
    }

    /**
     * Get isuniversal
     *
     * @return integer 
     */
    public function getIsuniversal()
    {
        return $this->isuniversal;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return LanguagesLabels
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set moduleId
     *
     * @param integer $moduleId
     * @return LanguagesLabels
     */
    public function setModuleId($moduleId)
    {
        $this->moduleId = $moduleId;

        return $this;
    }

    /**
     * Get moduleId
     *
     * @return integer 
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     * Set language
     *
     * @param \Application\Entity\Languages $language
     * @return LanguagesLabels
     */
    public function setLanguage(\Application\Entity\Languages $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Application\Entity\Languages 
     */
    public function getLanguage()
    {
        return $this->language;
    }
}