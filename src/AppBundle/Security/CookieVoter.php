<?php
/**
 * Created by PhpStorm.
 * User: Robertas
 * Date: 12/10/2017
 * Time: 9:28 PM
 */

namespace AppBundle\Security;


use AppBundle\Entity\Book;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CookieVoter extends Voter
{

    const VIEW = 'view';
    const EDIT = 'edit';

    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        if (!$subject instanceof Book) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Book $book */
        $book = $subject;

        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($book, $user);
            case self::EDIT:
                return $this->canEdit($book, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Book $book, User $user)
    {
        if ($this->canEdit($book, $user)) {
            return true;
        }

        // the Post object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        //return !$book->isPrivate();
        return !$book->getAuthor();
    }

    private function canEdit(Book $book, User $user)
    {
        return $user === $book->getUserEmail();
    }

}