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

#[Route('/admin/nft/crud')]
class NftCrudController extends AbstractController
{
    #[Route('/', name: 'app_nft_crud_index', methods: ['GET'])]
    public function index(NftRepository $nftRepository): Response
    {
        return $this->render('nft_crud/index.html.twig', [
            'nfts' => $nftRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nft_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nft = new Nft();
        $form = $this->createForm(NftType::class, $nft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nft);
            $entityManager->flush();

            return $this->redirectToRoute('app_nft_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft_crud/new.html.twig', [
            'nft' => $nft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_crud_show', methods: ['GET'])]
    public function show(Nft $nft): Response
    {
        return $this->render('nft_crud/show.html.twig', [
            'nft' => $nft,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nft_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Nft $nft, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NftType::class, $nft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nft_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft_crud/edit.html.twig', [
            'nft' => $nft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Nft $nft, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nft->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nft);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nft_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
