<?php

namespace Time\TBSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdmCountry
 *
 * @ORM\Table(name="adm_country")
 * @ORM\Entity
 */
class AdmCountry
{


    /**
     * @var string
     * @ORM\Column(name="code_iso", type="string", length=20)
     * @ORM\Id
     * ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codeIso;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @return string
     */
    public function getCodeIso()
    {
        return $this->codeIso;
    }

    /**
     * @param string $codeIso
     */
    public function setCodeIso($codeIso)
    {
        $this->codeIso = $codeIso;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}