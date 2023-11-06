<?php

namespace App\Form;

use App\Entity\PurchaseNft;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseNftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('purchaseDate')
            ->add('nftPriceEth')
            ->add('nftPriceEur')
            ->add('userId')
            ->add('nft')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PurchaseNft::class,
        ]);
    }
}
