<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZfcmsComuniStatoCivileArticoli
 *
 * @ORM\Table(name="zfcms_comuni_stato_civile_articoli", indexes={@ORM\Index(name="utente_id", columns={"utente_id"}), @ORM\Index(name="sezione_id", columns={"sezione_id"})})
 * @ORM\Entity
 */
class ZfcmsComuniStatoCivileArticoli
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titolo", type="text", length=65535, nullable=false)
     */
    private $titolo;

    /**
     * @var integer
     *
     * @ORM\Column(name="progressivo", type="integer", nullable=false)
     */
    private $progressivo;

    /**
     * @var integer
     *
     * @ORM\Column(name="anno", type="integer", nullable=false)
     */
    private $anno;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="date", nullable=false)
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ora", type="time", nullable=false)
     */
    private $ora;

    /**
     * @var integer
     *
     * @ORM\Column(name="attivo", type="integer", nullable=false)
     */
    private $attivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scadenza", type="date", nullable=false)
     */
    private $scadenza;

    /**
     * @var integer
     *
     * @ORM\Column(name="homepage_flag", type="integer", nullable=false)
     */
    private $homepageFlag;

    /**
     * @var integer
     *
     * @ORM\Column(name="allegati_numero", type="integer", nullable=false)
     */
    private $allegatiNumero;

    /**
     * @var integer
     *
     * @ORM\Column(name="box_notizie", type="integer", nullable=false)
     */
    private $boxNotizie;

    /**
     * @var \Application\Entity\ZfcmsComuniStatoCivileSezioni
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ZfcmsComuniStatoCivileSezioni")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sezione_id", referencedColumnName="id")
     * })
     */
    private $sezione;

    /**
     * @var \Application\Entity\ZfcmsUsers
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ZfcmsUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="utente_id", referencedColumnName="id")
     * })
     */
    private $utente;



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
     * Set titolo
     *
     * @param string $titolo
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setTitolo($titolo)
    {
        $this->titolo = $titolo;
    
        return $this;
    }

    /**
     * Get titolo
     *
     * @return string
     */
    public function getTitolo()
    {
        return $this->titolo;
    }

    /**
     * Set progressivo
     *
     * @param integer $progressivo
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setProgressivo($progressivo)
    {
        $this->progressivo = $progressivo;
    
        return $this;
    }

    /**
     * Get progressivo
     *
     * @return integer
     */
    public function getProgressivo()
    {
        return $this->progressivo;
    }

    /**
     * Set anno
     *
     * @param integer $anno
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;
    
        return $this;
    }

    /**
     * Get anno
     *
     * @return integer
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set ora
     *
     * @param \DateTime $ora
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setOra($ora)
    {
        $this->ora = $ora;
    
        return $this;
    }

    /**
     * Get ora
     *
     * @return \DateTime
     */
    public function getOra()
    {
        return $this->ora;
    }

    /**
     * Set attivo
     *
     * @param integer $attivo
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setAttivo($attivo)
    {
        $this->attivo = $attivo;
    
        return $this;
    }

    /**
     * Get attivo
     *
     * @return integer
     */
    public function getAttivo()
    {
        return $this->attivo;
    }

    /**
     * Set scadenza
     *
     * @param \DateTime $scadenza
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setScadenza($scadenza)
    {
        $this->scadenza = $scadenza;
    
        return $this;
    }

    /**
     * Get scadenza
     *
     * @return \DateTime
     */
    public function getScadenza()
    {
        return $this->scadenza;
    }

    /**
     * Set homepageFlag
     *
     * @param integer $homepageFlag
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setHomepageFlag($homepageFlag)
    {
        $this->homepageFlag = $homepageFlag;
    
        return $this;
    }

    /**
     * Get homepageFlag
     *
     * @return integer
     */
    public function getHomepageFlag()
    {
        return $this->homepageFlag;
    }

    /**
     * Set allegatiNumero
     *
     * @param integer $allegatiNumero
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setAllegatiNumero($allegatiNumero)
    {
        $this->allegatiNumero = $allegatiNumero;
    
        return $this;
    }

    /**
     * Get allegatiNumero
     *
     * @return integer
     */
    public function getAllegatiNumero()
    {
        return $this->allegatiNumero;
    }

    /**
     * Set boxNotizie
     *
     * @param integer $boxNotizie
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setBoxNotizie($boxNotizie)
    {
        $this->boxNotizie = $boxNotizie;
    
        return $this;
    }

    /**
     * Get boxNotizie
     *
     * @return integer
     */
    public function getBoxNotizie()
    {
        return $this->boxNotizie;
    }

    /**
     * Set sezione
     *
     * @param \Application\Entity\ZfcmsComuniStatoCivileSezioni $sezione
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setSezione(\Application\Entity\ZfcmsComuniStatoCivileSezioni $sezione = null)
    {
        $this->sezione = $sezione;
    
        return $this;
    }

    /**
     * Get sezione
     *
     * @return \Application\Entity\ZfcmsComuniStatoCivileSezioni
     */
    public function getSezione()
    {
        return $this->sezione;
    }

    /**
     * Set utente
     *
     * @param \Application\Entity\ZfcmsUsers $utente
     *
     * @return ZfcmsComuniStatoCivileArticoli
     */
    public function setUtente(\Application\Entity\ZfcmsUsers $utente = null)
    {
        $this->utente = $utente;
    
        return $this;
    }

    /**
     * Get utente
     *
     * @return \Application\Entity\ZfcmsUsers
     */
    public function getUtente()
    {
        return $this->utente;
    }
}
