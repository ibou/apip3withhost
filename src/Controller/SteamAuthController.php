<?php

declare(strict_types=1);

namespace App\Controller;

use App\Message\SteamAuthorizeCommand;
use App\Message\SteamAuthorizeCommand\DataFactory;
use App\Message\SteamAuthorizeCommand\DataStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

#[AsController]
class SteamAuthController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly DataStorage $dataStorage,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $id = Uuid::v7()->toBase32();
            $this->dataStorage->write($id, (new DataFactory())->createFromArray($request->query->all()));
            $this->bus->dispatch(new SteamAuthorizeCommand($id));
        } catch (\InvalidArgumentException $exception)
        {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['id' => $id], Response::HTTP_ACCEPTED);
    }
}
