<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_category_index', methods: ['GET' ])]
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
            'category' => $category,
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

        // if ($request->getMethod() === 'POST') {
        //     $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        // }
       

       $form = $this->createForm(CategoryType::class, $category);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
            $category = $categoryRepository->save($category, true);
            $this->addFlash('notice', 'The category has been updated');

            return $this->redirectToRoute('app_category_index',[],Response::HTTP_SEE_OTHER );
       }
       
       return $this->renderForm('category/edit.html.twig',[
           'category' => $category,
           'form' => $form,
       ]);

    }

    #[Route('/category/show/{id}', name: 'app_category_show', methods: ['GET' ])]
    public function showCategory(CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);

        if (! $category) {
            throw new NotFoundHttpException('No category found for id');
        }

        return $this->render('category/show.html.twig',[
            'category' => $category,
        ]);
    }


    #[Route('/category/delete/{id}', name: 'app_category_delete', methods: ['GET','POST'])]
    public function deleteCategory(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
