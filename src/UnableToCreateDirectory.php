

<?php

declare(strict_types=1);

namespace League\Flysystem;

use RuntimeException;
use Throwable;

final class UnableToCreateDirectory extends RuntimeException implements FilesystemOperationFailed
{
    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $reason = '';

    public static function atLocation(string $dirname, string $errorMessage = '', ?Throwable $previous = null): UnableToCreateDirectory
    {
        $message = "Unable to create a directory at {$dirname}. {$errorMessage}";
        $e = new static(rtrim($message), 0, $previous);
        $e->location = $dirname;
        $e->reason = $errorMessage;

        return $e;
    }

    public static function dueToFailure(string $dirname, Throwable $previous): UnableToCreateDirectory
    {
        $message = "Unable to create a directory at {$dirname}. {$previous->reason()}";
        $e = new static(rtrim($message), 0, $previous);
        $e->location = $dirname;
        $e->reason = $previous->reason();

        return $e;
    }

    public function operation(): string
    {
        return FilesystemOperationFailed::OPERATION_CREATE_DIRECTORY;
    }

    public function reason(): string
    {
        return $this->reason;
    }

    public function location(): string
    {
        return $this->location;
    }
}
