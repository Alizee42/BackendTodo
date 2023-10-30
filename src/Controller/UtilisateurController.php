<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    private $utilisateurRepository;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }

    
    #[Route('/utilisateurs', name:'add_utilisateur', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'];
        $password = $data['password'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $role =  $data['role'];
               
        if (empty($username)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->utilisateurRepository->save($username, $password, $firstname, $lastname,$email);

        return new JsonResponse(['status' => 'Utilisateur crée!'], Response::HTTP_CREATED);
    }

   
    #[Route('/utilisateurs/{id}', name:'get_one_utilisateur', methods: ['GET'])]
    public function getById($id): JsonResponse
    {
        $utilisateur = $this->utilisateurRepository->findOneBy(['id' => $id]);

        if($utilisateur == null) {
            return new JsonResponse(['status' => 'Utilisateur introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $utilisateur->getId(),
            'username' => $utilisateur->getUsername(),
            'password' => $utilisateur->getPassword(),
            'firstname' => $utilisateur->getFirstname(),
            'lastname' => $utilisateur->getLastname(),
            'email' => $utilisateur->getEmail(), 
            'role' => $utilisateur->getRole(),                    
            ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/utilisateurs', name:'get_all_utilisateurs', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $utilisateurs = $this->utilisateurRepository->findAll();
        $data = [];

        foreach ($utilisateurs as $utilisateur) {
            $data[] = [
                'id' => $utilisateur->getId(),
                'username' => $utilisateur->getUsername(),
                'password' => $utilisateur->getPassword(),
                'firstname' => $utilisateur->getFirstname(),
                'lastname' => $utilisateur->getLastname(),
                'email' => $utilisateur->getEmail(), 
                'role' => $utilisateur->getRole(),                           
                ];
            
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
    
    #[Route('/utilisateurs/{id}', name:'update_utilisateur', methods: ['PUT'])]
    public function update($id, Request $request): JsonResponse
    {
        $utilisateur = $this->utilisateurRepository->findOneBy(['id' => $id]);

        if($utilisateur == null) {
            return new JsonResponse(['status' => 'Utilisateur introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['name']) ? true : $utilisateur->setUsername($data['username']);
 
        $updatedAnnonce = $this->utilisateurRepository->update($utilisateur);

        return new JsonResponse(['status' => 'Utilisateur mise à jour'], Response::HTTP_OK); 
    }

    
    #[Route('/utilisateurs/{id}', name:'delete_utilisateur', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $tache = $this->utilisateurRepository->findOneBy(['id' => $id]);

        if($tache == null) {
            return new JsonResponse(['status' => 'Utilisateur introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $this->utilisateurRepository->remove($tache);

        return new JsonResponse(['status' => 'Utilisateur supprimée'], Response::HTTP_NO_CONTENT);
    }

}