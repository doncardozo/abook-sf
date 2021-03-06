<?php

namespace AB\AbookBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AB\AbookBundle\Entity\Contacts;
use AB\AbookBundle\Form\ContactsType;

/**
 * Contacts controller.
 *
 * @Route("/contacts")
 */
class ContactsController extends Controller
{

    /**
     * Lists all Contacts entities.
     *
     * @Route("/", name="contacts")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AbookBundle:Contacts')->fetchAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Contacts entity.
     *
     * @Route("/", name="contacts_create")
     * @Method("POST")
     * @Template("AbookBundle:Contacts:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Contacts();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $id = $em->getRepository('AbookBundle:Contacts')->create($entity);
            
            return $this->redirect($this->generateUrl('contacts_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Contacts entity.
    *
    * @param Contacts $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Contacts $entity)
    {
        $form = $this->createForm(new ContactsType(), $entity, array(
            'action' => $this->generateUrl('contacts_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Contacts entity.
     *
     * @Route("/new", name="contacts_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contacts();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Contacts entity.
     *
     * @Route("/{id}", name="contacts_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AbookBundle:Contacts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contacts entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Contacts entity.
     *
     * @Route("/{id}/edit", name="contacts_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AbookBundle:Contacts')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contacts entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Contacts entity.
    *
    * @param Contacts $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Contacts $entity)
    {
        $form = $this->createForm(new ContactsType(), $entity, array(
            'action' => $this->generateUrl('contacts_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Contacts entity.
     *
     * @Route("/{id}", name="contacts_update")
     * @Method("PUT")
     * @Template("AbookBundle:Contacts:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AbookBundle:Contacts')->find($id);
                
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contacts entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $status = $em->getRepository('AbookBundle:Contacts')->update($entity);
            
            return $this->redirect($this->generateUrl('contacts_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Contacts entity.
     *
     * @Route("/{id}", name="contacts_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AbookBundle:Contacts')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contacts entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contacts'));
    }

    /**
     * Creates a form to delete a Contacts entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contacts_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
