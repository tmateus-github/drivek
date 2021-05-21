<?php


namespace App\Services\UserService;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UserServiceInterface
{
    public function importer(UploadedFile $file): void;
}
