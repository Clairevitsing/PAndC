<?php

namespace App\Controller;

use App\Entity\PurchaseNft;
use App\Form\PurchaseNftType;
use App\Repository\PurchaseNftRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/purchase/nft/crud')]
class PurchaseNftCrudController extends AbstractController
{
    #[Route('/', name: 'app_purchase_nft_crud_index', methods: ['GET'])]
    public function index(PurchaseNftRepository $purchaseNftRepository): Response
    {
        return $this->render('purchase_nft_crud/index.html.twig', [
            'purchase_nfts' => $purchaseNftRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_purchase_nft_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $purchaseNft = new PurchaseNft();
        $form = $this->createForm(PurchaseNftType::class, $purchaseNft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($purchaseNft);
            $entityManager->flush();

            return $this->redirectToRoute('app_purchase_nft_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('purchase_nft_crud/new.html.twig', [
            'purchase_nft' => $purchaseNft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_purchase_nft_crud_show', methods: ['GET'])]
    public function show(PurchaseNft $purchaseNft): Response
    {
        return $this->render('purchase_nft_crud/show.html.twig', [
            'purchase_nft' => $purchaseNft,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_purchase_nft_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PurchaseNft $purchaseNft, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PurchaseNftType::class, $purchaseNft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_purchase_nft_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('purchase_nft_crud/edit.html.twig', [
            'purchase_nft' => $purchaseNft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_purchase_nft_crud_delete', methods: ['POST'])]
    public function delete(Request $request, PurchaseNft $purchaseNft, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchaseNft->getId(), $request->request->get('_token'))) {
            $entityManager->remove($purchaseNft);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_purchase_nft_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
