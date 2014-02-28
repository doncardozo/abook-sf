<?php

namespace AB\AbookBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ContactsRepository extends EntityRepository {

    public function fetchAll() {

        $em = $this->getEntityManager()->getConnection();

        $select = <<<SQL
                select 
                    id,
                    first_name firstName,
                    last_name lastName,
                    address address,
                    active                                     
                from contacts where active = 1 and deleted = 0;
    
SQL;
        return $em->fetchAll($select);
    }

    public function update(\AB\AbookBundle\Entity\Contacts $entity) {

        $em = $this->getEntityManager()->getConnection();
        $em->beginTransaction();
        return "ok";
        try {

            # Contacts
            $em->update("contacts", array(
                "first_name" => $entity->getFirstName(),
                "last_name" => $entity->getLastName(),
                "address" => $entity->getAddress(),
                "category_id" => $entity->getCategory()->getId(),
                "active" => $entity->getActive()
            ));

            $id = $em->lastInsertId();

            # Emails
            foreach ($entity->getEmails() as $listEmails) {

                foreach ($listEmails as $email) {

                    $em->insert("contacts_emails", array(
                        "contact_id" => $id,
                        "email" => $email->getEmail()
                    ));
                }
            }

            # Phones
            foreach ($entity->getPhones() as $listPhones) {

                foreach ($listPhones as $phone) {

                    $em->insert("contacts_phones", array(
                        "contact_id" => $id,
                        "phone_number" => $phone->getPhoneNumber()
                    ));
                }
            }

            $em->commit();
            return $id;
        } catch (Exception $ex) {
            $em->rollBack();
        }
    }

    public function create(\AB\AbookBundle\Entity\Contacts $entity) {

        $em = $this->getEntityManager()->getConnection();
        $em->beginTransaction();

        try {

            # Contacts
            $em->insert("contacts", array(
                "first_name" => $entity->getFirstName(),
                "last_name" => $entity->getLastName(),
                "address" => $entity->getAddress(),
                "category_id" => $entity->getCategory()->getId(),
                "active" => $entity->getActive()
            ));

            $id = $em->lastInsertId();

            # Emails
            foreach ($entity->getEmails() as $listEmails) {

                foreach ($listEmails as $email) {

                    $em->insert("contacts_emails", array(
                        "contact_id" => $id,
                        "email" => $email->getEmail()
                    ));
                }
            }

            # Phones
            foreach ($entity->getPhones() as $listPhones) {

                foreach ($listPhones as $phone) {

                    $em->insert("contacts_phones", array(
                        "contact_id" => $id,
                        "phone_number" => $phone->getPhoneNumber()
                    ));
                }
            }

            $em->commit();
            return $id;
        } catch (Exception $ex) {
            $em->rollBack();
        }
    }

    public function fetchEmaisByContactId($id) {

        $select = <<<SQL
                select 
                    id,
                    email,  
                    contact_id contact
                    active                                     
                from contacts_emails 
                    where 
                        id = 1 and
                        active = 1 and deleted = 0;
    
SQL;
    }

    public function fetchPhonesByContactId($id) {

        $select = <<<SQL
                select 
                    id,
                    phone_number phoneNumber,  
                    contact_id contact
                    active                                     
                from contacts_phones 
                    where 
                        id = 1 and
                        active = 1 and deleted = 0;
    
SQL;
    }

}
