<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** permet de générer dess formulaires
 * ce fichier est généré depuis make:form
 * ici on génère un formulaire sur l'entité Annonce
 */
class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** le builder permet de configurer le formulaire
         * si on enlève un add, le champs du formulaire ne s'affichera pas et ne sera
         * pas sauvegardé
         */
        $builder
            ->add('title')
            ->add('slug')
            ->add('content')
            ->add('createAt')
            ->add('enable')
            ->add('category')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
