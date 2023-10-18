<?php

namespace App\Controller;

use App\Entity\NftPrice;
use App\Form\NftPriceType;
use App\Repository\NftPriceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nft/price/crud')]
class NftPriceCrudController extends AbstractController
{
    #[Route('/', name: 'app_nft_price_crud_index', methods: ['GET'])]
    public function index(NftPriceRepository $nftPriceRepository): Response
    {
        return $this->render('nft_price_crud/index.html.twig', [
            'nft_prices' => $nftPriceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nft_price_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nftPrice = new NftPrice();
        $form = $this->createForm(NftPriceType::class, $nftPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nftPrice);
            $entityManager->flush();

            return $this->redirectToRoute('app_nft_price_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft_price_crud/new.html.twig', [
            'nft_price' => $nftPrice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_price_crud_show', methods: ['GET'])]
    public function show(NftPrice $nftPrice): Response
    {
        return $this->render('nft_price_crud/show.html.twig', [
            'nft_price' => $nftPrice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nft_price_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NftPrice $nftPrice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NftPriceType::class, $nftPrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nft_price_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft_price_crud/edit.html.twig', [
            'nft_price' => $nftPrice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_price_crud_delete', methods: ['POST'])]
    public function delete(Request $request, NftPrice $nftPrice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nftPrice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nftPrice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nft_price_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
