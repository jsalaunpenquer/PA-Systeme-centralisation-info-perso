<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;
use App\Entity\Categorie;
use App\Form\FolderType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Security;

class FolderController extends AbstractController
{
    protected $entityManager;
    protected $translator;
    protected $repository;

    // Set up all necessary variable
    protected function initialise()
    {
        $this->entityManager = $this->getDoctrine()->getManager();
        $this->repository = $this->entityManager->getRepository('App:Categorie');
        $this->translator = Translator::class;
    }

    public function addAction(Request $request, Security $security)
    {
        // Set up required variables
        $this->initialise();
        $user = $security->getUser();


        // New object
        $folder = new Categorie();
        $date = date('m/d/Y h:i:s a', time());

        // Build the form
        $form = $this->get('form.factory')->create(FolderType::class, $folder);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            // Check form data is valid
            if ($form->isValid())
            {
                $folder->setTypeDeCategorie($request->attributes->get('type'));
                $folder->setUserCategorie($user);
                // Save data to database
                $this->entityManager->persist($folder);
                    foreach ($folder->getDocuments() as $document)
                    {
                        $document->setdateDeParution(new \DateTime());
                        $document->setCheminAbsolue($document->getUploadDir());
                    }
                $this->entityManager->flush();

                $this->addFlash('notice', "Okkkk");

                // Redirect to view page
                return $this->redirectToRoute('folder_view', array(
                    'id'	=>	$folder->getIdCategorie(),
                ));
            }
        }
        // If we are here it means that either
        //	- request is GET (user has just landed on the page and has not filled the form)
        //	- request is POST (form has invalid data)
        return $this->render(
            'Pages/add.html.twig',
            array (
                'form'	=>	$form->createView(),
            )
        );
    }

    public function editAction(Request $request, Categorie $folder)
    {
        // Set up required variables
        $this->initialise();

        // Build the form
        $form = $this->get('form.factory')->create(FolderType::class, $folder);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            // Check form data is valid
            if ($form->isValid())
            {
                // Save data to database
                $this->entityManager->persist($folder);
                $this->entityManager->flush();

                // Inform user
                $flashBag = $this->translator->trans('folder_edit_success', array(), 'flash');
                $request->getSession()->getFlashBag()->add('notice', $flashBag);

                // Redirect to view page
                return $this->redirectToRoute('folder_view', array(
                    'id'	=>	$folder->getIdCategorie(),
                ));
            }
        }
        // If we are here it means that either
        //	- request is GET (user has just landed on the page and has not filled the form)
        //	- request is POST (form has invalid data)
        return $this->render(
            'pages/edit.html.twig',
            array (
                'form'		=>	$form->createView(),
                'folder'	=>	$folder
            )
        );
    }

    public function viewAction(Request $request, UserInterface $user)
    {
        // Set up required variables
        $this->initialise();
        $id = $user->getId();
        $folders = $this->entityManager
            ->getRepository(Categorie::class)
            ->findByUser($id);
                return $this->render(
                    'pages/view.html.twig',
                    array(
                        'folders' => $folders,
                    )
                );

        }
}