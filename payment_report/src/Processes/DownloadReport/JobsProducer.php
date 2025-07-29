<?php

declare(strict_types=1);

namespace PaymentReport\Processes\DownloadReport;

use Exception;
use FilesystemExtended\Models\Contracts\FileInterface;
use FilesystemExtended\Plugins\FilePresets\FilePresetFactory;
use FilesystemExtended\Services\Contracts\FileStorageManagerInterface;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\UploadedFile;
use PaymentReport\Jobs\DownloadPaymentReportProcessJob;
use PaymentReport\Plugins\FilePresets\PaymentReportArchive;
use Processes\Models\Process\Contracts\ProcessInterface;
use Processes\Process\JobsProducers\Contracts\JobsProducerInterface;
use ZipArchive;

class JobsProducer implements JobsProducerInterface
{
    public function __construct(
        private readonly FilePresetFactory $factory,
        private readonly FilesystemManager $filesystemManager,
    ) {
    }

    /**
     * @throws Exception
     */
    public function getJobs(ProcessInterface $process): array
    {
        /** @var ProcessData $data */
        $data = $process->getData();

        $zip = $this->createEmptyZip($data->getResultedFileName());

        return array_map(
            function (string $fileId) use ($process, $zip): DownloadPaymentReportProcessJob {
                return new DownloadPaymentReportProcessJob($process, $fileId, $zip);
            },
            $data->getFileIds()
        );
    }

    /**
     * @throws Exception
     */
    private function createEmptyZip(string $fileName): FileInterface
    {
        $tmpPath = $this->filesystemManager->disk(FileStorageManagerInterface::STORAGE_TEMPORARY)->path($fileName);

        $zipArchive = new ZipArchive();

        if ($zipArchive->open($tmpPath, ZipArchive::CREATE) !== true) {
            throw new Exception("Cannot create ZIP file at $tmpPath");
        }

        $zipArchive->addEmptyDir(pathinfo($fileName, PATHINFO_FILENAME));

        $zipArchive->close();

        $preset = $this->factory->getInstanceByName(PaymentReportArchive::NAME);

        return $preset->store(new UploadedFile($tmpPath, $fileName, 'application/zip'));
    }
}
