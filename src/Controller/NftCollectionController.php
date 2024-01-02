<?php

namespace App\Controller;

use App\Entity\NftCollection;
use App\Form\NftCollectionType;
use App\Repository\NftCollectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nft/collection')]
class NftCollectionController extends AbstractController
{
    #[Route('/', name: 'app_nft_collection_index', methods: ['GET'])]
    public function index(NftCollectionRepository $nftCollectionRepository): Response
    {
        return $this->render('nft_collection/index.html.twig', [
            'nft_collections' => $nftCollectionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nft_collection_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nftCollection = new NftCollection();
        $form = $this->createForm(NftCollectionType::class, $nftCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nftCollection);
            $entityManager->flush();

            return $this->redirectToRoute('app_nft_collection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft_collection/new.html.twig', [
            'nft_collection' => $nftCollection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_collection_show', methods: ['GET'])]
    public function show(NftCollection $nftCollection): Response
    {
        return $this->render('nft_collection/show.html.twig', [
            'nft_collection' => $nftCollection,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nft_collection_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NftCollection $nftCollection, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NftCollectionType::class, $nftCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nft_collection_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft_collection/edit.html.twig', [
            'nft_collection' => $nftCollection,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_collection_delete', methods: ['POST'])]
    public function delete(Request $request, NftCollection $nftCollection, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nftCollection->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nftCollection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nft_collection_index', [], Response::HTTP_SEE_OTHER);
    }
}
