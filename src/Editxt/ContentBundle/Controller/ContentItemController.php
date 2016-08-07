<?php

namespace Editxt\ContentBundle\Controller;

use Editxt\ContentBundle\Form\ContentItemFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Editxt\ContentBundle\ContentItemEvent;
use Editxt\ContentBundle\Event\ContentItemPreAddEvent;
use Editxt\ContentBundle\Entity\ContentItem;
use Editxt\ContentBundle\Form\ContentItemType;

/**
 * ContentItem controller.
 *
 */
class ContentItemController extends Controller
{

    /**
     * Lists all ContentItem entities.
     *
     */
    public function indexAction(Request $request)
    {
        $filtersForm = $this->createFilterForm();
        $filtersForm->handleRequest($request);

        $filters = array();
        if($filtersForm->isValid()) {
            $filters = $filtersForm->getData();
        }

        $paginator = $this->get('editxt.content_item.provider')->getContentItemList(
            $filters,
            $this->get('request')->query->get('page'),
            20);


        return $this->render('ContentBundle:ContentItem:index.html.twig', array(
            'filter_form' => $filtersForm->createView(),
            'entities' => $paginator,
        ));
    }

    /**
     * Creates a form to filter a Content entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFilterForm()
    {
        $form = $this->get('form.factory')->createNamed(
            '',
            new ContentItemFilterType(),
            null,
            array(
                'action' => $this->generateUrl('item'),
                'attr' => array(
                    'class' => '',
                    'name' => ''
                ),
            )
        );

        return $form;
    }

    /**
     * Creates a new ContentItem entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ContentItem();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('item_show', array('id' => $entity->getId())));
        }

        return $this->render('ContentBundle:ContentItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a ContentItem entity.
     *
     * @param ContentItem $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ContentItem $entity)
    {
        $form = $this->createForm(new ContentItemType(), $entity, array(
            'action' => $this->generateUrl('item_create'),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Displays a form to create a new ContentItem entity.
     *
     */
    public function newAction()
    {
        $entity = new ContentItem();
        $form   = $this->createCreateForm($entity);

        return $this->render('ContentBundle:ContentItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ContentItem entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ContentBundle:ContentItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ContentBundle:ContentItem:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ContentItem entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ContentBundle:ContentItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentItem entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('ContentBundle:ContentItem:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ContentItem entity.
    *
    * @param ContentItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContentItem $entity)
    {
        $form = $this->createForm(new ContentItemType(), $entity, array(
            'action' => $this->generateUrl('item_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing ContentItem entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ContentBundle:ContentItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('item_edit', array('id' => $id)));
        }

        return $this->render('ContentBundle:ContentItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Form to delete a Content entity.
     *
     */
    public function deleteFormAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ContentBundle:ContentItem')->find($id);
        $contentRelated = $this->get('editxt.content_related.repository')->getRelatedByItem($id);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ContentBundle:ContentItem:delete.html.twig', array(
            'entity' => $entity,
            'contentRelated' => $contentRelated,
            'form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ContentItem entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ContentBundle:ContentItem')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ContentItem entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('item'));
    }

    /**
     * Creates a form to delete a ContentItem entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('item_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'red')))
            ->getForm()
        ;
    }
}
