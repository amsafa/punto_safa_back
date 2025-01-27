<?php

namespace App\Service;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;


class RegistroService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    private ValidatorInterface $validator;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->validator= $validator;
    }

    //Metodo para registrar un nuevo usuario
    public function register(string $nick, string $email, string $password, string $rol): Usuario
    {
        //Validacion de nick
        $nickExistente = $this->entityManager->getRepository(Usuario::class)->findOneBy(['nick' => $nick]);
        if($nickExistente){
            throw new \Exception('El nombre de usuario ya está en uso');
        }

        //Validacion de contraseña (minimo 6 caracteres
        if(strlen($password) < 6){
            throw new \Exception('La contraseña debe tener al menos 6 caracteres');
        }

        //Validación de email (formato correcto)
        $emailConstraint = new Assert\Email();
        $emailConstraint->message = 'El correo electrónico no es válido';
        $violations = $this->validator->validate($email, $emailConstraint);

        if (count($violations) > 0) {
            throw new \Exception('El correo electrónico no es válido');
        }

        //validación de email único
        $usuarioExistente = $this->entityManager->getRepository(Usuario::class)->findOneBy(['email' => $email]);
        if ($usuarioExistente) {
            throw new \Exception('El correo electrónico ya está en uso');
        }



        $usuario = new Usuario();
        $usuario-> setNick($nick);
        $usuario-> setEmail($email);
        $usuario->setRol($rol);

        //Encriptar la contraseña usando el PasswordHasher
        $hashedPassword = $this->passwordHasher->hashPassword($usuario, $password);
        $usuario->setContrasena($hashedPassword);

        //Guardar el nuevo usuario en la bbdd
        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $usuario;
    }

    //Otros metodos
}