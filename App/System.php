<?php


namespace App;


class System
{

    public $baseDir;
    public $currentDir;
    public $dirList;
    public $fileList;
    public $dirLog;


    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function getProperties()
    {
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaseDir()
    {
        return $this->baseDir;
    }

    /**
     * @return mixed
     */
    public function getCurrentDir()
    {
        return $this->currentDir;
    }

    /**
     * @param string $path
     * @return System
     */
    public function getFilelist($path = '/')
    {
        $this->dirLog['path'] = $path;
        if ($path != '/') {
            $newPath = $this->baseDir . '/' . $path;
            $fileList = [];
            if (file_exists($newPath)) {
                $fileList = scandir($newPath);
                $this->dirLog['message'] = 'Found ' . count($fileList) . ' files';
            } else {
                $this->dirLog['message'] = 'No file found in directory';
            }
            $this->fileList = $fileList;

        } else {
            $newPath = $this->baseDir . '/' . $path;
            $this->fileList = scandir($newPath);
        }

        return $this;
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function getDirList($path = '/')
    {
        $this->dirLog['path'] = $path;
        $this->currentDir = $this->baseDir .$path . '/';

        if ($path != '/') {
            $newPath = $this->baseDir . '/' . $path;

            if (file_exists($newPath)) {

                $fileList = scandir($newPath);
                $folders = [];
                $files = [];
                foreach ($fileList as $folder) {

                    if (is_dir($this->baseDir . '/' . $path . '/' . $folder) && $folder !== '.' && $folder !== '..') {
                        array_push($folders, $folder);
                    }

                    if (is_file($this->baseDir . '/' . $path . '/' . $folder) && $folder !== '.' && $folder !== '..') {
                        array_push($files, $folder);
                        $this->fileList = $files;
                    }

                }
                $this->dirList = $folders;
                $this->dirLog['message'] = [
                    'Found total ' . count($fileList) . $this->formatWord(count($fileList), 'file'),
                    'Found ' . count($folders) . $this->formatWord(count($folders), 'folder'),
                    'Found ' . count($files) . $this->formatWord(count($files), 'file'),
                ];
            } else {
                return $this->dirLog['message'] = 'No file found in directory';
            }

        } else {
            $newPath = $this->baseDir . '/' . $path;
            $fileList = scandir($newPath);
            $folders = [];
            foreach ($fileList as $folder) {
                if (is_dir($this->baseDir . '/' . $path . '/' . $folder) && $folder !== '.' && $folder !== '..') {
                    array_push($folders, $folder);
                }
            }
            $this->dirList = $this->escapeDot($folders);
        }

        return $this;

    }

    /**
     * Escape (.) and (..) from File list and return again
     * @param $size
     * @param $word
     * @return string
     */
    private function formatWord($size, $word)
    {
        if ($size == 1) {
            return ' ' . $word;
        } else {
            return ' ' . $word . 's';
        }
    }

}