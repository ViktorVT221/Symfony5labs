<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    private static array $items = [
        ['id' => 1, 'name' => 'Item 1'],
        ['id' => 2, 'name' => 'Item 2'],
    ];

    #[Route('/items', name: 'items')]
    public function items(): Response
    {
        return $this->json(self::$items);
    }

    #[Route('/items/create', name: 'items_create')]
    public function create(): Response
    {
        $id = count(self::$items) + 1;

        self::$items[] = [
            'id' => $id,
            'name' => 'Item ' . $id,
        ];

        return $this->json(['status' => 'created']);
    }

    #[Route('/items/{id}', name: 'items_read')]
    public function read(int $id): Response
    {
        foreach (self::$items as $item) {
            if ($item['id'] === $id) {
                return $this->json($item);
            }
        }

        return $this->json(['error' => 'Not found']);
    }

    #[Route('/items/{id}/update', name: 'items_update')]
    public function update(int $id): Response
    {
        foreach (self::$items as &$item) {
            if ($item['id'] === $id) {
                $item['name'] = 'UPDATED ITEM ' . $id;
                return $this->json($item);
            }
        }

        return $this->json(['error' => 'Not found']);
    }

    #[Route('/items/{id}/delete', name: 'items_delete')]
    public function delete(int $id): Response
    {
        foreach (self::$items as $key => $item) {
            if ($item['id'] === $id) {
                unset(self::$items[$key]);
                return $this->json(['status' => 'deleted']);
            }
        }

        return $this->json(['error' => 'Not found']);
    }

}
