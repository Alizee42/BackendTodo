<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    
    #[Route('/categories', name:'add_categorie', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
       
        if (empty($name)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->categorieRepository->save($name);

        return new JsonResponse(['status' => 'categorie crée!'], Response::HTTP_CREATED);
    }

   
    #[Route('/categories/{id}', name:'get_one_categorie', methods: ['GET'])]
    public function getById($id): JsonResponse
    {
        $categorie = $this->categorieRepository->findOneBy(['id' => $id]);

        if($categorie == null) {
            return new JsonResponse(['status' => 'Categorie introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $categorie->getId(),
            'name' => $categorie->getName()
            
            ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/categories', name:'get_all_categories', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $categories = $this->categorieRepository->findAll();
        $data = [];

        foreach ($categories as $categorie) {
            $data[] = [
                'id' => $categorie->getId(),
                'name' => $categorie->getName(),
                ];
            
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    
    #[Route('/categories/{id}', name:'update_categorie', methods: ['PUT'])]
    public function update($id, Request $request): JsonResponse
    {
        $categorie = $this->categorieRepository->findOneBy(['id' => $id]);

        if($categorie == null) {
            return new JsonResponse(['status' => 'Categorie introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['name']) ? true : $categorie->setName($data['name']);
 
        $updatedAnnonce = $this->categorieRepository->update($categorie);

        return new JsonResponse(['status' => 'Categorie mise à jour'], Response::HTTP_OK); 
    }

    
    #[Route('/categories/{id}', name:'delete_categorie', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $categorie = $this->categorieRepository->findOneBy(['id' => $id]);

        if($categorie == null) {
            return new JsonResponse(['status' => 'Categorie introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $this->categorieRepository->remove($categorie);

        return new JsonResponse(['status' => 'Categorie supprimée'], Response::HTTP_NO_CONTENT);
    }

}
