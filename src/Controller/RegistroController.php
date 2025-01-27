<?php

namespace App\Controller;

use App\Service\RegistroService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/usuario')]
class RegistroController extends AbstractController
{
    private RegistroService $registroService;

    public function __construct(RegistroService $registroService)
    {
        $this->registroService = $registroService;
    }

    //metodo para registrar un nuevo usuario
    #[Route('/registrar', name: 'usuario_registrar', methods: ["POST"])]
    public function registrar(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),true);

        if($data === null){
            return new JsonResponse(['error' => 'Error al procesar los datos JSON'], JsonResponse::HTTP_BAD_REQUEST);
        }

        //obtener los valores de la solicitud
        $nick = $data['nick'] ?? null;
        $email = $data['email'] ?? null;
        $contrasena = $data['contraseña'] ?? null;
        $rol = $data['rol'] ?? 'rol_usuario'; //por defecto

        if(!$nick || !$email || !$contrasena) {
            return new JsonResponse(['error' => 'Faltan campos obligatorios'], JsonResponse::HTTP_BAD_REQUEST);
        }
        try {
            //Llamar al servicio para registrar el usuario
            $usuario = $this->registroService->register($nick, $email, $contrasena, $rol);
            return new JsonResponse([
                'id' => $usuario->getId(),
                'nick' => $usuario->getNick(),
                'email' => $usuario->getEmail(),
            ], JsonResponse::HTTP_CREATED);

        } catch (\Exception $e) {
            //manejar errores (usuario ya existente, etc.)
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}