<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AdresseFacturationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('adresseFacturation', TextareaType::class, [
            'label' => false,
            'required' => true,
            'constraints' => [
                new NotBlank(['message' => 'L\'adresse de facturation est requise']),
                new Length([
                    'max' => 255,
                    'maxMessage' => 'L\'adresse ne peut pas dépasser {{ limit }} caractères'
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z0-9\s,.\'-]+$/u',
                    'message' => 'Seuls les lettres, chiffres, espaces et les caractères , . \' - sont autorisés'
                ]),
                new Callback([$this, 'validateAdresse']),
            ],
            'attr' => [
                'placeholder' => 'Adresse complète de facturation',
                'rows' => 4,
                'class' => 'form-control'
            ],
            'help' => 'Exemple : 8 boulevard des Instruments, 69007 Lyon'
        ]);
    }

    public function validateAdresse($value, ExecutionContextInterface $context): void
    {
        if (empty($value)) return;

        $trimmed = trim($value);
        if (strlen($trimmed) < 10) {
            $context->buildViolation('L\'adresse doit contenir au moins 10 caractères')
                ->addViolation();
        }
        if (!preg_match('/\d/', $trimmed)) {
            $context->buildViolation('L\'adresse doit contenir un numéro')
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Utilisateur::class]);
    }
}