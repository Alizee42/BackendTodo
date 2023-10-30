<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthentificationController extends AbstractController
{
    private $UtilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->UtilisateurRepository = $utilisateurRepository;
    }

    #[Route('/login', name:'login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];

        $utilisateur = $this->UtilisateurRepository->findOneBy(
            [
                'email' => $email,
                'password' => $password
            ]
        );

        if($utilisateur == null) {
            return new JsonResponse(['status' => 'Email ou mot de passe invalide'], Response::HTTP_UNAUTHORIZED);
        }

        $message = "Compte utilisateur trouvé";

        if($utilisateur->getRole() == "administrateur") {
            $message = "Compte administrateur trouvé";
        } else if($utilisateur->getRole() == "client") {
            $message = "Compte client trouvé";
        }

        return new JsonResponse(['status' => $message], Response::HTTP_OK);
    }
}
