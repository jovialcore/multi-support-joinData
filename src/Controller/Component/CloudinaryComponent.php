<?php

declare(strict_types=1);

namespace CakeCloudinary\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Cloudinary;

/**
 * Cloudinary component
 * Reference:
 * https://cloudinary.com/documentation/php_image_and_video_upload#server_side_upload
 *
 * another useful resource : https://cloudinary.com/documentation/image_upload_api_reference#upload
 */
class CloudinaryComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    private $cloudinary;

    protected $response;


    public function __construct()
    {
        $this->startUpCloudinary();
    }


    public function initialize(array $config): void
    {
    }


    // retrieve cloudinray config  and instantiate the default php sdk cloudinary class
    public function startUpCloudinary()
    {
        $cloudinaryConfig = Configure::read('cloudinary.default');

        $this->cloudinary = new Cloudinary($cloudinaryConfig);
    }


    // wrap the cloudinary upload functionality

    public function uploadApi()
    {
        return $this->cloudinary->uploadApi();
    }

    // wrap the adminApi functionality

    public function adminApi()
    {
        return $this->cloudinary->adminApi();
    }


    // upload a file to ccloudinary account

    public function upload($file, array $options = [])
    {
        return $this->response = $this->uploadApi()->upload($file, $options);
    }

    // upload any typeof file to cloudinary account

    public function uploadFile($file, array $options = [])
    {
        $anyFileParams  = ['resource_type' =>  'auto'];

        $options = array_merge($options, $anyFileParams);

        return $this->response = $this->uploadApi()->upload($file, $options);
    }


    // delete an image  from cloudinray account

    public function deleteImage($image, array $options = [])
    {
        return $this->response = $this->uploadApi()->destroy($image, $options);
    }

    // delete video from cloudinary

    public function deleteVideo($video, array $options = [])
    {
        $videoparam  = ['resource_type' =>  'video'];

        $options = array_merge($options, $videoparam);

        return $this->response = $this->uploadApi()->destroy($video, $options);
    }

    /**
     * TO dos:
     * Create collages
     * tags
     * context,
     * text api,
     *
     * and some functionalities like image video creation, and creation of collages that doesn't support collages yet
     *
     */
}
