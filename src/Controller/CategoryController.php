<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category', methods: ['GET' ])]
    public function indexCategory(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig',[
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/new', name: 'app_category_new', methods: ['GET','POST' ])]
    public function createCategory(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($this->$request);

        if($form->isSubmitted() && $form->isValid()){
             $categoryRepository->save($category, true);

             return $this->redirectToRoute('app_category_index',[],Response::HTTP_SEE_OTHER );
        }
        
        return $this->renderForm('category/new.html.twig',[
            'categories' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/category/edit/{id}', name: 'app_category_edit', methods: ['GET','POST' ])]
    public function editCategory(Request $request, CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);

        if (! $category) {
            throw new NotFoundHttpException('No category found for id');
        }

        if ($request->getMethod() === 'POST') {
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        }
       

       $form = $this->createForm(CategoryType::class, $category);
       $form->handleRequest($this->$request);

       if($form->isSubmitted() && $form->isValid()){
            $category = $categoryRepository->save($category, true);
            $this->addFlash('notice', 'The category has been updated');

            return $this->redirectToRoute('app_category_index',[],Response::HTTP_SEE_OTHER );
       }
       
       return $this->renderForm('category/edit.html.twig',[
           'categories' => $category,
           'form' => $form,
       ]);

    }

    #[Route('/category/delete/{id}', name: 'category_delete', methods: ['GET','POST'])]
    public function deleteAction(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        $entityManager->remove($category);
        $entityManager->flush();

    }
}
