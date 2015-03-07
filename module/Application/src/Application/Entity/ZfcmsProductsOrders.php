<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZfcmsProductsOrders
 *
 * @ORM\Table(name="zfcms_products_orders")
 * @ORM\Entity
 */
class ZfcmsProductsOrders
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
     * @var integer
     *
     * @ORM\Column(name="numord", type="integer", nullable=false)
     */
    private $numord = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="qt", type="string", length=10, nullable=false)
     */
    private $qt = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="prezzo", type="decimal", precision=60, scale=2, nullable=false)
     */
    private $prezzo = '0.00';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataordine", type="datetime", nullable=false)
     */
    private $dataordine = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="rifidprod", type="integer", nullable=false)
     */
    private $rifidprod = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="idcliente", type="integer", nullable=false)
     */
    private $idcliente = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="codord", type="integer", nullable=false)
     */
    private $codord = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="visib", type="string", nullable=false)
     */
    private $visib = 'si';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=100, nullable=false)
     */
    private $status = 'no';

    /**
     * @var string
     *
     * @ORM\Column(name="formapagam", type="string", length=100, nullable=false)
     */
    private $formapagam = 'no';



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
     * Set numord
     *
     * @param integer $numord
     * @return ZfcmsProductsOrders
     */
    public function setNumord($numord)
    {
        $this->numord = $numord;
    
        return $this;
    }

    /**
     * Get numord
     *
     * @return integer 
     */
    public function getNumord()
    {
        return $this->numord;
    }

    /**
     * Set qt
     *
     * @param string $qt
     * @return ZfcmsProductsOrders
     */
    public function setQt($qt)
    {
        $this->qt = $qt;
    
        return $this;
    }

    /**
     * Get qt
     *
     * @return string 
     */
    public function getQt()
    {
        return $this->qt;
    }

    /**
     * Set prezzo
     *
     * @param string $prezzo
     * @return ZfcmsProductsOrders
     */
    public function setPrezzo($prezzo)
    {
        $this->prezzo = $prezzo;
    
        return $this;
    }

    /**
     * Get prezzo
     *
     * @return string 
     */
    public function getPrezzo()
    {
        return $this->prezzo;
    }

    /**
     * Set dataordine
     *
     * @param \DateTime $dataordine
     * @return ZfcmsProductsOrders
     */
    public function setDataordine($dataordine)
    {
        $this->dataordine = $dataordine;
    
        return $this;
    }

    /**
     * Get dataordine
     *
     * @return \DateTime 
     */
    public function getDataordine()
    {
        return $this->dataordine;
    }

    /**
     * Set rifidprod
     *
     * @param integer $rifidprod
     * @return ZfcmsProductsOrders
     */
    public function setRifidprod($rifidprod)
    {
        $this->rifidprod = $rifidprod;
    
        return $this;
    }

    /**
     * Get rifidprod
     *
     * @return integer 
     */
    public function getRifidprod()
    {
        return $this->rifidprod;
    }

    /**
     * Set idcliente
     *
     * @param integer $idcliente
     * @return ZfcmsProductsOrders
     */
    public function setIdcliente($idcliente)
    {
        $this->idcliente = $idcliente;
    
        return $this;
    }

    /**
     * Get idcliente
     *
     * @return integer 
     */
    public function getIdcliente()
    {
        return $this->idcliente;
    }

    /**
     * Set codord
     *
     * @param integer $codord
     * @return ZfcmsProductsOrders
     */
    public function setCodord($codord)
    {
        $this->codord = $codord;
    
        return $this;
    }

    /**
     * Get codord
     *
     * @return integer 
     */
    public function getCodord()
    {
        return $this->codord;
    }

    /**
     * Set visib
     *
     * @param string $visib
     * @return ZfcmsProductsOrders
     */
    public function setVisib($visib)
    {
        $this->visib = $visib;
    
        return $this;
    }

    /**
     * Get visib
     *
     * @return string 
     */
    public function getVisib()
    {
        return $this->visib;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return ZfcmsProductsOrders
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
     * Set formapagam
     *
     * @param string $formapagam
     * @return ZfcmsProductsOrders
     */
    public function setFormapagam($formapagam)
    {
        $this->formapagam = $formapagam;
    
        return $this;
    }

    /**
     * Get formapagam
     *
     * @return string 
     */
    public function getFormapagam()
    {
        return $this->formapagam;
    }
}