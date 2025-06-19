<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AdresseLivraisonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresseLivraison', TextareaType::class, [
                'label' => 'Adresse de livraison',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'adresse de livraison est requise',
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'L\'adresse de livraison ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Callback([$this, 'validateAdresse']),
                ],
                'attr' => [
                    'placeholder' => 'Adresse complète de livraison',
                    'rows' => 4,
                    'class' => 'form-control'
                ],
                'help' => 'Saisissez votre adresse complète où seront livrées vos commandes'
            ]);
    }

  
    public function validateAdresse($value, ExecutionContextInterface $context): void
    {
        if (empty($value)) {
            return; 
        }

        $trimmedValue = trim($value);
        
        if (strlen($trimmedValue) < 10) {
            $context->buildViolation('L\'adresse de livraison doit contenir au moins 10 caractères')
                ->addViolation();
            return;
        }

        if (!preg_match('/\d/', $trimmedValue)) {
            $context->buildViolation('L\'adresse de livraison doit contenir un numéro')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}