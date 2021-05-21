<?php


namespace App\Services\UserService;


use App\Enums\CsvColumnIndexEnum;
use App\Enums\LogReferenceEnum;
use App\Repositories\ExternalUserRepository\ExternalUserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserService implements UserServiceInterface
{
    private $filename;
    /**
     * @var ExternalUserRepositoryInterface
     */
    private $externalUserRepository;

    /**
     * UserService constructor.
     * @param ExternalUserRepositoryInterface $externalUserRepository
     */
    public function __construct(
        ExternalUserRepositoryInterface $externalUserRepository
    )
    {
        $this->externalUserRepository = $externalUserRepository;
    }

    /**
     * Importer handler
     * @param UploadedFile $file
     */
    public function importer(UploadedFile $file): void
    {
        $this->setFilename(
            $file->getClientOriginalName()
        );

        $this->storeFile(
            $file
        );

        $usersData  = [];
        $row        = 0;

        if (($handle = fopen($file->getPathname(), 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, config('csv.length.user_service'), ";")) !== FALSE) {
                $email          = (isset($data[CsvColumnIndexEnum::EMAIL]) && !empty($data[CsvColumnIndexEnum::EMAIL])) ? $data[CsvColumnIndexEnum::EMAIL] : null;
                $lastName       = (isset($data[CsvColumnIndexEnum::LAST_NAME]) && !empty($data[CsvColumnIndexEnum::LAST_NAME])) ? $data[CsvColumnIndexEnum::LAST_NAME] : null;
                $firstName      = (isset($data[CsvColumnIndexEnum::FIRST_NAME]) && !empty($data[CsvColumnIndexEnum::FIRST_NAME])) ? $data[CsvColumnIndexEnum::FIRST_NAME] : null;
                $fiscalCode     = (isset($data[CsvColumnIndexEnum::FISCAL_CODE]) && !empty($data[CsvColumnIndexEnum::FISCAL_CODE])) ? $data[CsvColumnIndexEnum::FISCAL_CODE] : null;
                $description    = (isset($data[CsvColumnIndexEnum::DESCRIPTION]) && !empty($data[CsvColumnIndexEnum::DESCRIPTION])) ? $data[CsvColumnIndexEnum::DESCRIPTION] : null;
                $lastAccessDate = (isset($data[CsvColumnIndexEnum::LAST_ACCESS_DATE]) && !empty($data[CsvColumnIndexEnum::LAST_ACCESS_DATE])) ? $data[CsvColumnIndexEnum::LAST_ACCESS_DATE] : null;

                $item = [
                    'email'             => $email,
                    'first_name'        => $firstName,
                    'last_name'         => $lastName,
                    'fiscal_code'       => $fiscalCode,
                    'description'       => $description,
                    'last_access_date'  => $lastAccessDate,
                ];

                $validator = Validator::make($item,[
                    'email'             => 'required|email',
                    'first_name'        => 'nullable|string|max:32',
                    'last_name'         => 'nullable|string|max:32',
                    'fiscal_code'       => 'nullable|string|digits:9',
                    'description'       => 'nullable|string|max:255',
                    'last_access_date'  => 'nullable|date_format:Y-m-d H:i:s'
                ]);

                if ($validator->fails()) {
                    $message = json_encode([
                                   'class'      => get_class($this),
                                   'method'     => __FUNCTION__,
                                   'debug'      => [
                                       'row'    => $row,
                                       'data'   => $data,
                                       'file'   => $this->getFilename()
                                   ],
                                   'errors'     => $validator->errors()->toArray(),
                                   'log_reference' => LogReferenceEnum::IMPORT_USERS_INVALID_DATA
                               ]);

                    Log::warning($message);

                    continue;
                }

                $usersData[] = $item;

                $row++;
            }

            fclose($handle);
        }

        if (empty($usersData)) {
            $message = json_encode([
                           'class'     => get_class($this),
                           'method'    => __FUNCTION__,
                           'debug'     => [
                               'file'   => $this->getFilename()
                           ],
                           'log_reference' => LogReferenceEnum::IMPORT_USERS_EMPTY_DATA
                       ]);

            Log::warning($message);

            return;
        }

        $this->storeUsersByChunks($usersData);
    }

    /**
     * Set filename
     * @note adds prefix to avoid override of files
     * @param string $filename
     */
    private function setFilename(string $filename): void
    {
        $this->filename = Str::uuid() . $filename;
    }

    /**
     * Get filename
     * @return string
     */
    private function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Store users by chunks
     * @param array $users
     */
    private function storeUsersByChunks(array $users): void
    {
        $userChunks = array_chunk(
            $users,
            config('chunk.user_service')
        );

        $target = [
            'email'
        ];

        $fields = [
            'email',
            'first_name',
            'last_name',
            'fiscal_code',
            'description',
            'last_access_date',
        ];

        foreach ($userChunks as $userChunk) {
            $this->externalUserRepository->upsert(
                $userChunk,
                $target,
                $fields
            );
        }
    }

    /**
     * Store file as back-up
     * @param UploadedFile $file
     */
    private function storeFile(UploadedFile $file): void
    {
        Storage::disk('local')->put(
            $this->getFilename(),
            $file->getContent()
        );
    }
}
