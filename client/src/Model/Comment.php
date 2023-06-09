<?php

declare(strict_types=1);

namespace Drom\Model;

final class Comment
{
    public function __construct(
        private readonly int|string|null $id,
        private readonly ?string         $name,
        private readonly ?string         $text
    ) {
    }

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }
}