<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\User;
use App\Message\SteamAuthorizeCommand\AuthDataRepository;
use App\Repository\UserRepository;
use App\Service\SteamService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
readonly class SteamAuthorizeCommandHandler
{
    public function __construct(
        private AuthDataRepository       $authDataRepository,
        private SteamService             $steamService,
        private UserRepository           $userRepository,
        private EntityManagerInterface   $entityManager,
        private JWTTokenManagerInterface $tokenManager,
    ) {
    }

    public function __invoke(SteamAuthorizeCommand $command): void
    {
        $authData = $this->authDataRepository->read($command->uuid);

        $isAuthenticated = $this->steamService->check($authData);

        $token = $isAuthenticated ? $this->createToken($authData) : null;

        $authData = $authData->makeFinishedProcessing($token);
        $this->authDataRepository->write($authData->uuid, $authData, true);
    }

    private function createNewUser(string $steamId): User
    {
        $user = new User(
            Uuid::v7(),
            Uuid::v7(),
            $steamId,
            [],
        );
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    private function createToken(SteamAuthorizeCommand\AuthData $authData): string
    {
        $steamId = $authData->parseSteamId();
        $user = $this->userRepository->findOneBySteamId($steamId);
        if (!$user) {
            $user = $this->createNewUser($steamId);
        }

        return $this->tokenManager->create($user);
    }
}