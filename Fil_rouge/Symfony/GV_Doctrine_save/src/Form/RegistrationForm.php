<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class RegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une adresse email',
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir une adresse email valide',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'exemple@email.com'
                ]
            ])
            
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom',
                    ]),
                    new Length([
                        'max' => 80,
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                        'message' => 'Le nom ne peut contenir que des lettres, espaces, apostrophes et tirets',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Votre nom'
                ]
            ])
            
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre prénom',
                    ]),
                    new Length([
                        'max' => 80,
                        'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\'-]+$/',
                        'message' => 'Le prénom ne peut contenir que des lettres, espaces, apostrophes et tirets',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]
            ])
            
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 30,
                        'maxMessage' => 'Le numéro de téléphone ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Callback([$this, 'validateTelephone']),
                ],
                'attr' => [
                    'placeholder' => '01 23 45 67 89'
                ]
            ])
            
            ->add('adresseLivraison', TextareaType::class, [
                'label' => 'Adresse de livraison',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'L\'adresse de livraison ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9À-ÿ\s,.\'-]+$/u',
                        'message' => 'Seuls les lettres, chiffres, espaces et les caractères , . \' - sont autorisés',
                    ]),
                    new Callback([$this, 'validateAdresse']),
                ],
                'attr' => [
                    'placeholder' => 'Adresse complète de livraison',
                    'rows' => 3
                ],
                'help' => 'Exemple : 8 boulevard des Instruments, 69007 Lyon'
            ])
            
            ->add('adresseFacturation', TextareaType::class, [
                'label' => 'Adresse de facturation',
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'L\'adresse de facturation ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9À-ÿ\s,.\'-]+$/u',
                        'message' => 'Seuls les lettres, chiffres, espaces et les caractères , . \' - sont autorisés',
                    ]),
                    new Callback([$this, 'validateAdresse']),
                ],
                'attr' => [
                    'placeholder' => 'Adresse complète de facturation',
                    'rows' => 3
                ],
                'help' => 'Optionnel - Si vide, l\'adresse de livraison sera utilisée'
            ])
            
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les conditions d\'utilisation',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions d\'utilisation.',
                    ]),
                ],
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit']);
    }

   
    public function onPreSubmit(FormEvent $event): void
    {
        $data = $event->getData();

        if (isset($data['nom']) && !empty($data['nom'])) {
            $data['nom'] = $this->formatName($data['nom']);
        }

        if (isset($data['prenom']) && !empty($data['prenom'])) {
            $data['prenom'] = $this->formatName($data['prenom']);
        }

        $event->setData($data);
    }

    /**
     * Copie l'adresse de livraison vers l'adresse de facturation si cette dernière est vide
     */
    public function onPostSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $utilisateur = $form->getData();

        if ($utilisateur instanceof Utilisateur) {
            $adresseLivraison = $utilisateur->getAdresseLivraison();
            $adresseFacturation = $utilisateur->getAdresseFacturation();

            // Si l'adresse de facturation est vide mais qu'il y a une adresse de livraison
            if (empty(trim($adresseFacturation)) && !empty(trim($adresseLivraison))) {
                $utilisateur->setAdresseFacturation($adresseLivraison);
            }
        }
    }

    
    private function formatName(string $name): string
    {
      
        $name = trim($name);
      
        $name = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
        
       
        $name = preg_replace('/\bDe\b/', 'de', $name);
        $name = preg_replace('/\bDu\b/', 'du', $name);
        $name = preg_replace('/\bLa\b/', 'la', $name);
        $name = preg_replace('/\bLe\b/', 'le', $name);
        $name = preg_replace('/\bVan\b/', 'van', $name);
        $name = preg_replace('/\bVon\b/', 'von', $name);
        
        return $name;
    }

   
    public function validateTelephone($value, ExecutionContextInterface $context): void
    {
        if (empty($value)) {
            return; 
        }

        $cleanPhone = preg_replace('/[-.\s]/', '', $value);
        
        
        if (!preg_match('/^(?:(?:\+33|0)[1-9](?:[0-9]{8}))$/', $cleanPhone) && 
            !preg_match('/^0[1-9][0-9]{8}$/', $cleanPhone)) {
            $context->buildViolation('Format de téléphone invalide (ex: 01 23 45 67 89)')
                ->addViolation();
        }
    }

   
    public function validateAdresse($value, ExecutionContextInterface $context): void
    {
        if (empty($value)) {
            return; 
        }

        $trimmedValue = trim($value);
        
        if (strlen($trimmedValue) < 10) {
            $context->buildViolation('L\'adresse doit contenir au moins 10 caractères')
                ->addViolation();
            return;
        }

        if (!preg_match('/\d/', $trimmedValue)) {
            $context->buildViolation('L\'adresse doit contenir un numéro')
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