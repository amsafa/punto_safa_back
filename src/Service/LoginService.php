<?php

namespace App\Service;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class LoginService
{
    private EntityManagerInterface $entityManager;
    private PasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, PasswordHasherInterface $passwordHasher)
    {
        $this->entityManager= $entityManager;
        $this-> passwordHasher= $passwordHasher;
    }

    //Metodo para verificar las credenciales del usuario al hacer login
    public function login(string $email, string $password): Usuario
    {
        //Buscar el usuario por el email
        $usuario = $this->entityManager->getRepository(Usuario::class)->findOneBy(['email'=>$email]);


        // Verifica si el usuario no existe o si la contraseña proporcionada no coincide con la que se registra.
        if (!$usuario || !$this->passwordHasher->verify($usuario->getContrasena(), $password)) {
            throw new BadCredentialsException('Credenciales incorrectas');
        }

        return $usuario;
    }
}