<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Repository\CategorieRepository;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TacheController extends AbstractController
{
    private $tacheRepository;
    private $categorieRepository;

    public function __construct(TacheRepository $tacheRepository, CategorieRepository $categorieRepository)
    {
        $this->tacheRepository = $tacheRepository;
        $this->categorieRepository = $categorieRepository;
    }

    
    #[Route('/taches', name:'add_tache', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $priority = $data['priority'];
        $description = $data['description'];
        $status = $data['status'];
        $createdBy = $data['createdBy'];
        $createdDate = $data['createdDate'];
        $updatedBy = $data['updatedBy'];
        $updatedDate = $data['updatedDate'];

        $categoryId = $data['category'];
        $category= $this->categorieRepository->findOneBy(['id' => $categoryId]);
       
        if (empty($name)) {
            throw new NotFoundHttpException('Bad request');
        }

        $this->tacheRepository->save($name, $priority, $description, $status,$createdBy,$createdDate,$updatedBy,$updatedDate,$category);

        return new JsonResponse(['status' => 'Tache crée!'], Response::HTTP_CREATED);
    }

   
    #[Route('/taches/{id}', name:'get_one_tache', methods: ['GET'])]
    public function getById($id): JsonResponse
    {
        $tache = $this->tacheRepository->findOneBy(['id' => $id]);

        if($tache == null) {
            return new JsonResponse(['status' => 'Tache introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'id' => $tache->getId(),
            'name' => $tache->getName(),
            'priority' => $tache->getPriority(),
            'description' => $tache->getDescription(),
            'status' => $tache->getStatus(),
            'createdBy' => $tache->getCreatedBy(),
            'createdDate' => $tache->getCreatedDate(),
            'updatedBy' => $tache->getUpdatedBy(),
            'updatedDate' => $tache->getUpdatedDate(),
            'category' => $tache->getCategory()            
            ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/taches', name:'get_all_taches', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $taches = $this->tacheRepository->findAll();
        $data = [];

        foreach ($taches as $tache) {
            $data[] = [
                'id' => $tache->getId(),
                'name' => $tache->getName(),
                'priority' => $tache->getPriority(),
                'description' => $tache->getDescription(),
                'status' => $tache->getStatus(),
                'createdBy' => $tache->getCreatedBy(),
                'createdDate' => $tache->getCreatedDate(),
                'updatedBy' => $tache->getUpdatedBy(),
                'updatedDate' => $tache->getUpdatedDate(),
                'category' => $tache->getCategory()            
                ];
            
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
    
    #[Route('/taches/{id}', name:'update_tache', methods: ['PUT'])]
    public function update($id, Request $request): JsonResponse
    {
        $tache = $this->tacheRepository->findOneBy(['id' => $id]);

        if($tache == null) {
            return new JsonResponse(['status' => 'Tache introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        empty($data['name']) ? true : $tache->setName($data['name']);
        empty($data['priority']) ? true : $tache->setPriority($data['priority']);
        empty($data['description']) ? true : $tache->setDescription($data['description']);
        empty($data['status']) ? true : $tache->setStatus($data['status']);
        empty($data['createdBy']) ? true : $tache->setCreatedBy($data['createdBy']);
        empty($data['createdDate']) ? true : $tache->setCreatedDate($data['createdDate']);
        empty($data['updatedBy']) ? true : $tache->setUpdatedBy($data['updatedBy']);
        empty($data['updatedDate']) ? true : $tache->setUpdatedDate($data['updatedDate']);

        $categoryId = $data['category'];
        $category= $this->categorieRepository->findOneBy(['id' => $categoryId]);
        $tache->setCategory($category);
 
        $updatedAnnonce = $this->tacheRepository->update($tache);

        return new JsonResponse(['status' => 'Tache mise à jour'], Response::HTTP_OK); 
    }

    
    #[Route('/taches/{id}', name:'delete_tache', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        $tache = $this->tacheRepository->findOneBy(['id' => $id]);

        if($tache == null) {
            return new JsonResponse(['status' => 'Tache introuvable!'], Response::HTTP_NOT_FOUND);
        }

        $this->tacheRepository->remove($tache);

        return new JsonResponse(['status' => 'Tache supprimée'], Response::HTTP_NO_CONTENT);
    }

}

