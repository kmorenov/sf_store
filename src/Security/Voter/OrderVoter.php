<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Security\Core\Security;

class OrderVoter extends Voter
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html]
        dump('in support');
        dump($attribute);
//        dump($subject[0] instanceof \App\Entity\Orders);
        return in_array($attribute, ['ROLE_SUPER_ADMIN', 'ROLE_ADMIN']);
//        && ($subject[0] instanceof \App\Entity\Orders || $subject[0] instanceof \App\Entity\Products);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        dump($attribute);
        switch ($attribute) {
            case 'ROLE_SUPER_ADMIN':
                dump('rsa');
                return $this->render('order/index.html.twig', compact('orders'));
                return true;
                // logic to determine if the user can EDIT
                // return true or false
            case 'ROLE_ADMIN':
                dump('ra');
                return true;
            // logic to determine if the user can VIEW
            // return true or false
            case 'ROLE_USER':
                dump('ru');
                return false;
            default:
                dump('default');
                return false;
        }

        dump('ret false');
        return false;
    }
}
