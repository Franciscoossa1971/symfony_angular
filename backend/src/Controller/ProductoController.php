<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/producto')]
class ProductoController extends AbstractController
{
    #[Route('', name: 'api_producto_index', methods: ['GET'])]
    public function index(ProductoRepository $productoRepository): JsonResponse
    {
        $productos = $productoRepository->findAll();

        $data = array_map(fn(Producto $producto) => [
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'cantidad' => $producto->getCantidad(),
        ], $productos);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'api_producto_show', methods: ['GET'])]
    public function show(Producto $producto): JsonResponse
    {
        return $this->json([
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'cantidad' => $producto->getCantidad(),
        ]);
    }

    #[Route('', name: 'api_producto_new', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        $producto = $serializer->deserialize($request->getContent(), Producto::class, 'json');

        $errors = $validator->validate($producto);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($producto);
        $entityManager->flush();

        return $this->json([
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'cantidad' => $producto->getCantidad(),
        ], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'api_producto_edit', methods: ['PUT'])]
    public function update(
        Request $request,
        Producto $producto,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        $serializer->deserialize($request->getContent(), Producto::class, 'json', ['object_to_populate' => $producto]);

        $errors = $validator->validate($producto);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->flush();

        return $this->json([
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'precio' => $producto->getPrecio(),
            'cantidad' => $producto->getCantidad(),
        ], Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'api_producto_delete', methods: ['DELETE'])]
    public function delete(Producto $producto, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($producto);
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
