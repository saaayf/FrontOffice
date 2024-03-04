<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    // ... (other methods)

    public function loadUserByIdentifier($identifier): UserInterface
    {
        // Load a User object from your data source or throw UserNotFoundException.
        // The $identifier argument may not actually be a username:
        // it is whatever value is being returned by the getUserIdentifier()
        // method in your User class.
        
        // Example: Assuming you have a UserRepository, adjust this part accordingly
        $user = $this->userRepository->findOneBy(['email' => $identifier]);

        if (!$user) {
            throw new UserNotFoundException(sprintf('User with identifier "%s" not found.', $identifier));
        }

        return $user;
    }

    // ... (other methods)

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        // Return a User object after making sure its data is "fresh".
        // Or throw a UsernameNotFoundException if the user no longer exists.

        // Example: Assuming you have a UserRepository, adjust this part accordingly
        $freshUser = $this->userRepository->find($user->getId());

        if (!$freshUser) {
            throw new UsernameNotFoundException(sprintf('User with ID "%s" not found.', $user->getId()));
        }

        return $freshUser;
    }

    // ... (other methods)

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: when hashed passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newHashedPassword);

        // Example: Assuming you have a UserRepository, adjust this part accordingly
        $user->setPassword($newHashedPassword);
        $this->userRepository->save($user); // Adjust this according to your repository method
    }
}
