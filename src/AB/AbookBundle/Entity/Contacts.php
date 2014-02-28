<?php

namespace AB\AbookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Contacts
 *
 * @ORM\Table(name="contacts", indexes={@ORM\Index(name="fk_Contacts_Categories_idx", columns={"category_id"})})
 * @ORM\Entity(repositoryClass="AB\AbookBundle\Entity\Repository\ContactsRepository")
 */
class Contacts
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
     * @ORM\Column(name="first_name", type="string", length=80, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=80, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=80, nullable=true)
     */
    private $address;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = '1';

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted = '0';

    /**
     * @var \Categories
     *
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;


    /**
     * @var Doctrine\Common\Collections\ArrayCollection 
     */
    private $emails;
    
    /**
     * @var Doctrine\Common\Collections\ArrayCollection 
     */
    private $phones;
    
    
    public function __construct() {
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     * @return Contacts
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Contacts
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Contacts
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set active
     *
     * @param int $active
     * @return Contacts
     */
    public function setActive($active)
    {
        $this->active = (bool)$active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return (bool)$this->active;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Contacts
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set category
     *
     * @param \AB\AbookBundle\Entity\Categories $category
     * @return Contacts
     */
    public function setCategory(\AB\AbookBundle\Entity\Categories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AB\AbookBundle\Entity\Categories 
     */
    public function getCategory()
    {
        return $this->category;
    }
    
    public function getEmails() {
        return $this->emails;
    }
    
    public function addEmail(\AB\AbookBundle\Entity\ContactsEmails $email) {     
        
        $email->setContact($this);
        if(!$this->emails instanceof ArrayCollection){
            $this->emails = new ArrayCollection();
        }
        $this->emails->add($email);
    }
    
    public function removeEmail(\AB\AbookBundle\Entity\ContactsEmails $email){
        $this->emails->removeElement($email);
    }

    public function getPhones() {
        return $this->phones;
    }
    
    public function addPhone(\AB\AbookBundle\Entity\ContactsPhones $phone) {
        
        $phone->getContact($this);        
        if(!$this->phones instanceof ArrayCollection){
            $this->phones = new ArrayCollection();
        }
        
        $this->phones->add($phone);
    }
    
    public function removePhone(\AB\AbookBundle\Entity\ContactsPhone $phone){
        $this->phones->removeElement($phone);
    }
}
