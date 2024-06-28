<?php

declare(strict_types=1);

namespace Drom\Model;

final readonly class CommentDto
{
    public function __construct(
        private ?int    $id,
        private ?string $name,
        private ?string $text,
    ) {
    }

    /**
     * Get the comment ID.
     *
     * @return int|null The comment ID.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the comment name.
     *
     * @return string|null The comment name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Get the comment text.
     *
     * @return string|null The comment text.
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Check if the comment is equal to another comment.
     *
     * @param CommentDto $other The other comment to compare.
     * @return bool True if the comments are equal, false otherwise.
     */
    public function equals(CommentDto $other): bool
    {
        return $this->id === $other->id &&
            $this->name === $other->name &&
            $this->text === $other->text;
    }

    /**
     * Convert the comment to JSON.
     *
     * @return string The JSON representation of the comment.
     */
    public function toJson(): string
    {
        return json_encode(get_object_vars($this));
    }
}
