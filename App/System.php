<?php


namespace App;


class System
{

    public $currentDir;
    public $baseDir;
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
     * @return mixed
     */
    public function getDirList($path = '/')
    {
        $this->dirLog['path'] = $path;
        if ($path != '/') {
            $newPath = $this->baseDir . '/' . $path;

            if (file_exists($newPath)) {

                $fileList = scandir($newPath);
                $folders = [];
                foreach ($fileList as $folder) {

                    if (is_dir($this->baseDir . '/' . $path . '/' . $folder)) {
                        array_push($folders, $folder);
                    }
                }
                $this->dirList = $folders;
                $this->dirLog['message'] = 'Found ' . count($fileList) . ' files';
            } else {
                $this->dirLog['message'] = 'No file found in directory';
            }
            echo '<pre>';
            print_r($this->dirList);
            exit;

        } else {
            $newPath = $this->baseDir . '/' . $path;
            $fileList = scandir($newPath);
            $folders = [];
            foreach ($fileList as $folder) {
                if (is_dir($folder)) {
                    array_push($folders, $folder);
                }
            }
            $this->dirList = $folders;
        }

        return $this->dirList;
    }

    /**
     * Escape (.) and (..) from File list and return again
     * @param $files
     * @return array
     */
    private function escapeDot($files)
    {
        $files = array_diff($files, array('.', '..'));
        return $files;
    }


}