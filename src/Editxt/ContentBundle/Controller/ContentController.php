<?php

namespace Editxt\ContentBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Editxt\ContentBundle\Form\ContentFilterType;
use Editxt\ContentBundle\Repository\ContentItemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Editxt\ContentBundle\ContentItemEvent;
use Editxt\ContentBundle\Entity\Content;
use Editxt\ContentBundle\Form\ContentType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Content controller.
 *
 */
class ContentController extends Controller
{

    /**
     * Lists all Content entities.
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

        $paginator = $this->get('editxt.content.provider')->getContentList(
            $filters,
            $this->get('request')->query->get('page'),
            40);

        return $this->render('ContentBundle:Content:index.html.twig', array(
            'filter_form' => $filtersForm->createView(),
            'entities' => $paginator
        ));
    }
    /**
     * Creates a new Content entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Content();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        $this->getIssetItems($entity);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('content_show', array('id' => $entity->getId())));
        }

        return $this->render('ContentBundle:Content:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
            new ContentFilterType(),
            null,
            array(
                'action' => $this->generateUrl('content'),
                'attr' => array(
                    'class' => '',
                    'name' => ''
                ),
            )
        );

        return $form;
    }

    /**
     * Creates a form to create a Content entity.
     *
     * @param Content $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Content $entity)
    {
        $form = $this->createForm(new ContentType(), $entity, array(
            'action' => $this->generateUrl('content_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Content entity.
     *
     */
    public function newAction()
    {
        $entity = new Content();
        $form   = $this->createCreateForm($entity);

        return $this->render('ContentBundle:Content:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Content entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ContentBundle:Content')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ContentBundle:Content:show.html.twig', array(
            'entity'      => $entity,
            'form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Content entity.
     *
     */
    public function pdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ContentBundle:Content')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
        }

        $html = $this->renderView('ContentBundle:Content:pdf.html.twig', array(
            'entity'      => $entity,
        ));

        $mpdfService = $this->get('tfox.mpdfport');
        return $mpdfService->generatePdfResponse($html);
    }

    /**
     * Displays a form to edit an existing Content entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ContentBundle:Content')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('ContentBundle:Content:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Content entity.
    *
    * @param Content $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Content $entity)
    {
        $form = $this->createForm(new ContentType(), $entity, array(
            'action' => $this->generateUrl('content_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Content entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ContentBundle:Content')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
        }

        //save original contentRelated from db to compare with data from Form
        $originalContentsRelated = new ArrayCollection();
        foreach ($entity->getContentRelated() as $contentRelated) {
            $originalContentsRelated->add($contentRelated);
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $this->getIssetItems($entity);

        if ($editForm->isValid()) {

            //If contentRelated was deleted in admin, delete it in db
            foreach ($originalContentsRelated as $contentRelated) {
                if (false === $entity->getContentRelated()->contains($contentRelated)) {
                    $em->remove($contentRelated);
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('content_show', array('id' => $id)));
        }

        return $this->render('ContentBundle:Content:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView()
        ));
    }

    /**
     * Form to delete a Content entity.
     *
     */
    public function deleteFormAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ContentBundle:Content')->find($id);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ContentBundle:Content:delete.html.twig', array(
            'entity' => $entity,
            'form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Content entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ContentBundle:Content')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Content entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('content'));
    }

    /**
     * Creates a form to delete a Content entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('content_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'red')))
            ->getForm()
        ;
    }

    private function getIssetItems(Content $entity) {

        $itemRepository = $this->container->get('editxt.content_item.repository');
        $contentRelateds = $entity->getContentRelated();
        foreach($contentRelateds as &$contentRelated) {

            $id = $contentRelated->getItem()->getItemId();
            if ($id) {

                $itemFromDb = $itemRepository->find($id);

                $itemFromDb->setBody($contentRelated->getItem()->getBody())
                    ->setTitle($contentRelated->getItem()->getTitle())
                    ->setTags($contentRelated->getItem()->getTags())
                    ->setSubTitles($contentRelated->getItem()->getSubTitles());


                !$itemFromDb ?:$contentRelated->setItem($itemFromDb);
            }
        }
    }
}
