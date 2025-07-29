<?php

declare(strict_types=1);

namespace PaymentReport\Processes\DownloadReport;

use App\Models\Casts\CastableJsonValue;
use App\Models\Casts\CastableJsonValueInterface;
use App\Models\Contracts\UserInterface;
use App\Repositories\Files\FileRepositoryInterface;
use App\Repositories\Users\UserRepositoryInterface;
use FilesystemExtended\Models\File;
use InvalidArgumentException;

final class ProcessData extends CastableJsonValue implements CastableJsonValueInterface
{
    private function __construct(
        private readonly array $fileIds,
        private readonly int $performerId,
        private readonly string $resultedFileName,
    ) {
    }

    public static function make(
        array $fileIds,
        int $performerId,
        string $resultedFileName,
    ): self {
        return new self($fileIds, $performerId, $resultedFileName);
    }

    public function toArray(): array
    {
        return [
            'file_ids' => $this->fileIds,
            'performer_id' => $this->performerId,
            'resulted_file_name' => $this->resultedFileName,
        ];
    }

    public static function fromArray(array $parameters): static
    {
        if (!isset($parameters['file_ids'])) {
            throw new InvalidArgumentException('Missing required parameter: file_ids');
        }

        if (!isset($parameters['performer_id'])) {
            throw new InvalidArgumentException('Missing required parameter: performer_id');
        }

        if (!isset($parameters['resulted_file_name'])) {
            throw new InvalidArgumentException('Missing required parameter: resulted_file_name');
        }

        return new self($parameters['file_ids'], $parameters['performer_id'], $parameters['resulted_file_name']);
    }

    public function getFileIds(): array
    {
        return $this->fileIds;
    }

    public function getResultedFileName(): string
    {
        return $this->resultedFileName;
    }

    public function getResultedFile(): File
    {
        /** @var FileRepositoryInterface $fileRepository */
        $fileRepository = app(FileRepositoryInterface::class);

        return $fileRepository->getByName($this->resultedFileName);
    }

    public function getPerformerId(): int
    {
        return $this->performerId;
    }

    // TODO remove it.
    public function getPerformerUser(): UserInterface
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);

        /** @type  UserInterface */
        return $userRepository->getById($this->performerId);
    }
}
