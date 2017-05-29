<?php

namespace Selleet\Infrastructure\BuildingBlocks\EventStore;

use LogicException;
use RuntimeException;
use SplFileObject;

class InFileEventStore implements EventStore
{
    private $directory;

    /**
     * @param string $directory Directory for storing the event store file (one file per stream name)
     */
    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            throw new \InvalidArgumentException($this->directory.' is not an existing directory.');
        }

        $this->directory = $directory;
    }

    public function commit(Stream $stream): void
    {
        if ($stream->isEmpty()) {
            return;
        }

        $fileObject = new SplFileObject($this->getFilename($stream->getStreamName()), 'a');

        if (false === $fileObject->flock(LOCK_EX)) {
            throw new LogicException(
                sprintf('Cannot lock file "%s".'), $this->getFilename($stream->getStreamName())
            );
        }

        foreach ($stream->getStreamEvents() as $event) {
            $fileObject->fwrite(serialize($event)."\n");
        }

        $fileObject->flock(LOCK_UN);
    }

    public function load(StreamName $streamName): Stream
    {
        try {
            $fileObject = new SplFileObject($this->getFilename($streamName), 'r');
            $fileObject->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD | SplFileObject::DROP_NEW_LINE);

            $events = [];
            foreach ($fileObject as $event) {
                $events[] = unserialize($event);
            }
        } catch (RuntimeException $e) {
            $events = [];
        }

        return new Stream($streamName, $events);
    }

    private function getFilename(StreamName $streamName): string
    {
        return $this->directory.'/'.$streamName.'.txt';
    }
}
