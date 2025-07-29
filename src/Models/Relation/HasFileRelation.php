<?php

declare(strict_types=1);

namespace PaymentReport\Models\Relation;

use FilesystemExtended\Models\File;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasFileRelation
{
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, self::ATTRIBUTE_FILE_ID);
    }

    public function getFile(): ?File
    {
        return $this->getRelationValue(self::RELATION_FILE);
    }

    public function getFileId(): ?string
    {
        return $this->getAttributeValue(self::ATTRIBUTE_FILE_ID);
    }

    public function setFile(?string $value): static
    {
        $this->setAttribute(self::ATTRIBUTE_FILE_ID, $value);

        return $this;
    }
}
