<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation\Contracts;

use FilesystemExtended\Models\File;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasFileRelationInterface
{
    public const RELATION_FILE = 'file';
    public const ATTRIBUTE_FILE_ID = 'file_id';

    public function file(): BelongsTo;

    public function getFile(): ?File;

    public function setFile(?string $value): static;
}
