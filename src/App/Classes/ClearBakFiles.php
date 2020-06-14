<?php

namespace App\Classes;

/**
 * Class ClearBakFiles
 */
class ClearBakFiles
{
    /**
     * @var bool $isRemove
     */
    public $isRemove;

    /**
     * ClearBakFiles constructor.
     *
     * @param bool $isRemove
     */
    public function __construct(bool $isRemove)
    {
        $this->isRemove = $isRemove;
    }

    /**
     * Clear Bak files
     *
     * @param string $path
     *
     * @return bool
     */
    public function clear(string $path): bool
    {
        $empty = true;

        $dirContents = $this->getDirContents($path);
        $bakFiles = preg_grep('~\.bak$~', $dirContents);
        foreach ($bakFiles as $key => $bakFile) {
            if (!in_array(preg_replace('~\.bak$~', '.doc', $bakFile), $dirContents)) {
                unlink($bakFile);
                unset($dirContents[$key]);
            }
        }

        foreach ($dirContents as $content) {
            $empty &= is_dir($content) && $this->clear($content);
        }

        return $this->isRemove && $empty && rmdir($path);
    }

    /**
     * Get Dir files|dir
     *
     * @param string $path
     *
     * @return array
     */
    private function getDirContents(string $path): array
    {
        return glob($path . DIRECTORY_SEPARATOR . '*');
    }
}
