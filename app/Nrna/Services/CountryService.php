<?php
namespace App\Nrna\Services;

use App\Nrna\Repositories\Country\CountryRepositoryInterface;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Class CountryService
 * @package App\Nrna\Services
 */
class CountryService
{
    /**
     * @var uploadPath
     */
    private $uploadPath;
    /**
     * @var CountryRepositoryInterface
     */
    private $country;
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var Filesystem
     */
    private $file;

    /**
     * constructor
     * @param CountryRepositoryInterface $country
     * @param Storage                    $storage
     * @param Filesystem                 $file
     */
    function __construct(CountryRepositoryInterface $country, Storage $storage, Filesystem $file)
    {
        $this->country    = $country;
        $this->storage    = $storage;
        $this->uploadPath = public_path('uploads/country');
        $this->file       = $file;
    }

    /**
     * @param $formData
     * @return Country|bool
     */
    public function save($formData)
    {
        $imageName = $this->upload($formData['image']);
        if (is_null($imageName)) {
            return false;
        }
        $formData['image'] = $imageName;

        return $this->country->save($formData);
    }


    /**
     * @param int $limit
     * @return Collection
     */
    public function all($limit = 15)
    {
        return $this->country->getAll($limit);
    }

    /**
     * @param $id
     * @return Country
     */
    public function find($id)
    {
        try {
            return $this->country->find($id);
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * @param $id
     * @param $formData
     * @return bool
     */
    public function update($id, $formData)
    {
        $formData = array_except($formData, ['_token', '_method']);
        $country  = $this->find($id);
        if (isset($formData['image'])) {
            $this->file->delete(sprintf('%s/%s', $this->uploadPath, $country->image));
            $formData['image'] = $this->upload($formData['image']);
        }

        return $this->country->update($formData);
    }

    /**
     * @param $id
     * @return int
     */
    public
    function delete(
        $id
    ) {
        return $this->country->delete($id);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public
    function upload(
        UploadedFile $file
    ) {
        $fileName    = $file->getClientOriginalName();
        $file_type   = $file->getClientOriginalExtension();
        $newFileName = sprintf("%s.%s", sha1($fileName . time()), $file_type);
        if ($file->move($this->uploadPath, $newFileName)) {
            return $newFileName;
        }

        return null;
    }
}