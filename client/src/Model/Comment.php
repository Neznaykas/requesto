<?php

declare(strict_types=1);

namespace Drom\Model;

final class Comment
{
    public function __construct(
        private readonly ?int $id,
        private ?string $name,
        private ?string $text
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

    public function setName(string $name): Comment
    {
        $this->name = $name;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Comment
    {
        $this->text = $text;
        return $this;
    }

    public function asString(): string
    {
        return $this->id . $this->name . $this->text;
    }

    public function equals(self $other): bool
    {
        return $this->asString() === $other->asString();
    }

    public function toJson(): string
    {
        return json_encode(get_object_vars($this));
    }
}