<?php

declare(strict_types=1);

namespace Drom\Model;

final class Comment
{
    public function __construct(
        private readonly ?int    $id,
        private readonly ?string $name,
        private readonly ?string $text
    )
    {
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
     * @param Comment $other The other comment to compare.
     * @return bool True if the comments are equal, false otherwise.
     */
    public function equals(Comment $other): bool
    {
        if ($this->id !== $other->id) {
            return false;
        }

        if ($this->name !== $other->name) {
            return false;
        }

        if ($this->text !== $other->text) {
            return false;
        }

        return true;
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
