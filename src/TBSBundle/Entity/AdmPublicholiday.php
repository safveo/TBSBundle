<?php

namespace Time\TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ZendPdf\BinaryParser\DataSource\String;

/**
 * AdmPublicholiday
 *
 * @ORM\Table(name="adm_publicholiday")
 * @ORM\Entity
 */
class AdmPublicholiday
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
     * @ORM\Column(name="local_name", type="string", nullable=false)
     */
    private $localName;

    /**
     * @var string
     *
     * @ORM\Column(name="international_name", type="string",nullable=true)
     */
    private $internationalName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date",nullable=false)
     */
    private $date;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Time\TBSBundle\Entity\AdmCountry", cascade={"persist"} )
     *@ORM\JoinColumn(name="adm_country_id", referencedColumnName="code_iso")
     */
    private $admContryId;


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
     * Set localName
     *
     * @param string $localName
     *
     * @return AdmPublicholiday
     */
    public function setLocalName($localName)
    {
        $this->localName = $localName;

        return $this;
    }

    /**
     * Get localName
     *
     * @return string
     */
    public function getLocalName()
    {
        return $this->localName;
    }

    /**
     * Set internationalName
     *
     * @param string $internationalName
     *
     * @return AdmPublicholiday
     */
    public function setInternationalName($internationalName)
    {
        $this->internationalName = $internationalName;

        return $this;
    }

    /**
     * Get internationalName
     *
     * @return string
     */
    public function getInternationalName()
    {
        return $this->internationalName;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AdmPublicholiday
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getAdmContryId()
    {
        return $this->admContryId;
    }

    /**
     * @param mixed $admContryId
     */
    public function setAdmContryId($admContryId)
    {
        $this->admContryId = $admContryId;
    }



}

