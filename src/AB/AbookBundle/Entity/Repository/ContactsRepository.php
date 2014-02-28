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
    
    public function create(\AB\AbookBundle\Entity\Contacts $entity){
        
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
            foreach($entity->getEmails() as $listEmails){

                foreach ($listEmails as $email){
                    
                    $em->insert("contacts_emails", array(
                        "contact_id" => $id,
                        "email" => $email->getEmail()
                    ));
                    
                }                
                
            }
 
            # Phones
            foreach($entity->getPhones() as $listPhones){

                foreach ($listPhones as $phone){
                    
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

}
