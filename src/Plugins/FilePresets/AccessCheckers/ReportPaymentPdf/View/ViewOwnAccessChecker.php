<?php

declare(strict_types=1);

namespace PaymentReport\Plugins\FilePresets\AccessCheckers\ReportPaymentPdf\View;

use App\Models\Contracts\UserInterface;
use PaymentReport\Actions\Contracts\FindPaymentReportByFileActionInterface;
use FilesystemExtended\Models\Contracts\FileInterface;
use FilesystemExtended\Plugins\FilePresets\AccessCheckers\Contracts\AccessCheckerInterface;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ViewOwnAccessChecker implements AccessCheckerInterface
{
    public function __construct(private readonly FindPaymentReportByFileActionInterface $findPaymentReportByFileAction)
    {
    }

    /**
     * @param FileInterface $file
     * @param array{user: UserInterface} $context
     *
     * @return Response
     */
    public function check(FileInterface $file, array $context = []): Response
    {
        try {
            $entity = $this->findPaymentReportByFileAction->handle($file->getKey());

            return $entity->getCreatedById() === $context['user']->getKey() ? Response::allow() : Response::deny();
        } catch (ModelNotFoundException) {
            return Response::deny();
        }
    }
}
