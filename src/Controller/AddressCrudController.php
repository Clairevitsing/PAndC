<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/address/crud')]
class AddressCrudController extends AbstractController
{
    #[Route('/', name: 'app_address_crud_index', methods: ['GET'])]
    public function index(AddressRepository $addressRepository): Response
    {
        return $this->render('address_crud/index.html.twig', [
            'addresses' => $addressRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_address_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('app_address_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address_crud/new.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_address_crud_show', methods: ['GET'])]
    public function show(Address $address): Response
    {
        return $this->render('address_crud/show.html.twig', [
            'address' => $address,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_address_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Address $address, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_address_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address_crud/edit.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_address_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Address $address, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$address->getId(), $request->request->get('_token'))) {
            $entityManager->remove($address);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_address_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
