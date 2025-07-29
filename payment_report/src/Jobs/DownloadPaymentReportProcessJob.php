<?php

declare(strict_types=1);

namespace PaymentReport\Jobs;

use App\Helpers\ZipGenerateServiceInterface;
use App\Repositories\Files\FileRepositoryInterface;
use FilesystemExtended\Models\Contracts\FileInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use PaymentReport\Providers\QueueDefinitionsProvider;
use Processes\Jobs\ProcessJob;
use Processes\Models\Process\Contracts\ProcessInterface;

class DownloadPaymentReportProcessJob extends ProcessJob
{
    private FileRepositoryInterface $fileRepository;
    private ZipGenerateServiceInterface $zipService;

    public function __construct(
        ProcessInterface $process,
        private readonly string $fileId,
        private readonly FileInterface $zipArchive,
    ) {
        return parent::__construct($process);
    }

    public static function getQueueName(): string
    {
        return QueueDefinitionsProvider::QUEUE_NAME;
    }

    public function process(): void
    {
        /** @var FileInterface $file */
        $file = $this->fileRepository->getById($this->fileId);

        $this->zipService->addFilesToZip($this->zipArchive, Arr::wrap($file));
    }

    protected function resolveDependencies(Application $app): void
    {
        $this->zipService = $app->make(ZipGenerateServiceInterface::class);
        $this->fileRepository = $app->make(FileRepositoryInterface::class);
    }
}
