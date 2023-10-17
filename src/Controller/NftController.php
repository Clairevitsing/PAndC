<?php

namespace App\Controller;

use App\Entity\Nft;
use App\Form\NftType;
use App\Repository\NftRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NftController extends AbstractController
{
    #[Route('/nfts', name: 'app_nft_index', methods: ['GET' ])]
    public function index(NftRepository $nftRepository): Response
    {
        return $this->render('nft/index.html.twig',[
            'nfts' => $nftRepository->findAll(),   
        ]);
    }

    #[Route('/nft/new', name: 'app_nft_new', methods: ['GET','POST' ])]
    public function createNft(Request $request, NftRepository $nftRepository): Response
    {
        $nft = new Nft();
        $form = $this->createForm(NftType::class, $nft);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
             $nftRepository->save($nft, true);

             return $this->redirectToRoute('app_nft_index',[],Response::HTTP_SEE_OTHER );
        }
        
        return $this->renderForm('nft/new.html.twig',[
            'nft' => $nft,
            'form' => $form,
        ]);
    }

    #[Route('/nft/edit/{id}', name: 'app_nft_edit', methods: ['GET','POST' ])]
    public function editCategory(Request $request, NftRepository $nftRepository, int $id): Response
    {
        $nft = $nftRepository->find($id);

        if (! $nft) {
            throw new NotFoundHttpException('No nft found for id');
        }

        // if ($request->getMethod() === 'POST') {
        //     $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        // }
       

       $form = $this->createForm(nftType::class, $nft);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
            $category = $nftRepository->save($nft, true);
            $this->addFlash('notice', 'The category has been updated');

            return $this->redirectToRoute('app_category_index',[],Response::HTTP_SEE_OTHER );
       }
       
       return $this->renderForm('category/edit.html.twig',[
           'nft' => $nft,
           'form' => $form,
       ]);

    }

    #[Route('/nft/show/{id}', name: 'app_nft_show', methods: ['GET' ])]
    public function showCategory(NftRepository $nftRepository, int $id): Response
    {
        $nft = $nftRepository->find($id);

        if (! $nft) {
            throw new NotFoundHttpException('No nft found for id');
        }

        return $this->render('nft/show.html.twig',[
            'nft' => $nft,
        ]);
    }


    #[Route('/nft/delete/{id}', name: 'app_nft_delete', methods: ['GET','POST'])]
    public function deleteNft(Request $request, Nft $nft, NftRepository $nftRepository): Response
    {
        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        if ($this->isCsrfTokenValid('delete'.$nft->getId(), $request->request->get('_token'))) {
            $nftRepository->remove($nft, true);
        }

        return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);

    }
}
