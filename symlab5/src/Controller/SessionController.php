<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Service\SessionService;
use App\Service\SessionValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sessions')]
class SessionController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(Request $request, SessionRepository $repo): Response
    {
        $requestData = $request->query->all();

        $itemsPerPage = isset($requestData['itemsPerPage'])
            ? (int)$requestData['itemsPerPage']
            : 10;

        $page = isset($requestData['page'])
            ? (int)$requestData['page']
            : 1;

        $sessionsData = $repo->getAllSessionsByFilter(
            $requestData,
            $itemsPerPage,
            $page
        );

        return $this->json($sessionsData);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id, SessionRepository $repo): Response
    {
        $session = $repo->find($id);

        if (!$session) {
            return $this->json(['error' => 'Session not found'], 404);
        }

        return $this->json($session);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request,
        SessionService $service,
        SessionValidator $validator
    ): Response {
        $data = json_decode($request->getContent(), true);

        if ($errors = $validator->validate($data)) {
            return $this->json($errors, 400);
        }

        return $this->json($service->create($data), 201);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        int $id,
        SessionRepository $repo,
        EntityManagerInterface $em
    ): Response {
        $session = $repo->find($id);

        if (!$session) {
            return $this->json(['error' => 'Session not found'], 404);
        }

        $em->remove($session);
        $em->flush();

        return $this->json(['status' => 'deleted']);
    }
}
