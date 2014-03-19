<?php

namespace AB\AbookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactsPhones
 *
 * @ORM\Table(name="contacts_phones", indexes={@ORM\Index(name="fk_contacts_phones_Contacts1_idx", columns={"contact_id"})})
 * @ORM\Entity(repositoryClass="AB\AbookBundle\Entity\Repository\ContactsPhonesRepository")
 */
class ContactsPhones
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
     * @ORM\Column(name="phone_number", type="string", length=45, nullable=true)
     */
    private $phoneNumber;

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
     * @var \Contacts
     *
     * @ORM\ManyToOne(targetEntity="Contacts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * })
     */
    private $contact;

    public function setId($id){
        $this->id = $id;
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return ContactsPhones
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return ContactsPhones
     */
    public function setActive($active)
    {
        $this->active = $active;

        return (bool)$this;
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
     * @return ContactsPhones
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
     * Set contact
     *
     * @param \AB\AbookBundle\Entity\Contacts $contact
     * @return ContactsPhones
     */
    public function setContact(\AB\AbookBundle\Entity\Contacts $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \AB\AbookBundle\Entity\Contacts 
     */
    public function getContact()
    {
        return $this->contact;
    }
}
