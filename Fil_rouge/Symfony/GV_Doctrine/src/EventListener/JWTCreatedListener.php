<?php
// src/EventListener/JWTCreatedListener.php

namespace App\EventListener;

use App\Entity\Utilisateur; // Importez votre entité User
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Monolog\Handler\Curl\Util;

class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user = $event->getUser();
        $payload = $event->getData();
        
        // Vérifier que c'est bien votre entité User
        if ($user instanceof Utilisateur) {
            // Maintenant vous pouvez accéder à getId()
            $payload['id'] = $user->getId();
            
            // Vous pouvez aussi ajouter d'autres informations
            // $payload['firstname'] = $user->getFirstname();
            // $payload['lastname'] = $user->getLastname();
        }
        
        $event->setData($payload);
    }
}