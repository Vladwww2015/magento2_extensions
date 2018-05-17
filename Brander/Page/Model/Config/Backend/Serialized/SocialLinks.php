<?php

namespace Brander\Page\Model\Config\Backend\Serialized;

use Magento\Framework\Registry;
use Magento\Framework\Filesystem;
use Magento\Framework\Model\Context;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Config\Model\Config\Backend\Serialized\ArraySerialized;
use Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface;

/**
 * Class SocialLinks
 * @package Brander\Page\Model\Config\Backend\Serialized
 */
class SocialLinks extends ArraySerialized
{
    /**
     * @var RequestDataInterface
     */
    protected $_requestData;

    /**
     * @var Filesystem\Directory\WriteInterface
     */
    protected $_mediaDirectory;

    /**
     * @var UploaderFactory
     */
    protected $_uploaderFactory;

    /**
     * @var Database
     */
    protected $_coreFileStorageDatabase;

    /**
     * SocialLinks constructor.
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param Database $coreFileStorageDatabase
     * @param RequestDataInterface $requestData
     * @param UploaderFactory $uploaderFactory
     * @param Filesystem $filesystem
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param Json|null $serializer
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        Database $coreFileStorageDatabase,
        RequestDataInterface $requestData,
        UploaderFactory $uploaderFactory,
        Filesystem $filesystem,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        Json $serializer = null
    )
    {
        $this->_requestData             = $requestData;
        $this->_mediaDirectory          = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->_uploaderFactory         = $uploaderFactory;
        $this->_coreFileStorageDatabase = $coreFileStorageDatabase;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data, $serializer);
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $values = $this->getValue();
        $files = $this->getFileData();
        if (!empty($files)) {
            $uploadDir = $this->_getUploadDir();
            try {
                foreach ($files as $key => $file) {
                    /** @var Uploader $uploader */
                    $uploader = $this->_uploaderFactory->create(['fileId' => $file]);
                    $this->_prepareDeleteImage($key);
                    $uploader->setAllowedExtensions($this->_getAllowedExtensions());
                    $uploader->setAllowRenameFiles(true);
                    $uploader->addValidateCallback('size', $this, 'validateMaxSize');
                    $result = $uploader->save($uploadDir);
                    $values[$key]['image'] = $result['file'];
                }
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\LocalizedException(__('%1', $e->getMessage()));
            }
        }

        foreach ($values as $key => $value) {
            if (is_array($value) && !empty($value['image']['delete'])) {
                $this->_prepareDeleteImage($key);
                $values[$key]['image'] = '';
            }

            if(isset($values[$key]['image']) && is_array($values[$key]['image'])) {
                $data = explode('/', $values[$key]['image']['value']);
                $values[$key]['image'] = array_pop($data);
            }
        }

        $this->setValue($values);
        parent::beforeSave();
    }

    /**
     * @param $imageName
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function moveFileFromTmp($imageName)
    {
        $baseTmpPath = $this->_mediaDirectory->getAbsolutePath('tmp');
        $basePath = $this->_mediaDirectory->getAbsolutePath('brander_page/config/social_links');

        $baseImagePath = $this->getFilePath($basePath, $imageName['name']);
        $baseTmpImagePath = $this->getFilePath($baseTmpPath, $imageName['name']);

        try {
            $this->_coreFileStorageDatabase->copyFile(
                $baseTmpImagePath,
                $baseImagePath
            );
            $this->_mediaDirectory->renameFile(
                $baseTmpImagePath,
                $baseImagePath
            );
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }

        return $imageName;
    }

    /**
     * @param $path
     * @param $imageName
     * @return string
     */
    public function getFilePath($path, $imageName)
    {
        return rtrim($path, '/') . '/' . ltrim($imageName, '/');
    }

    /**
     * @param $key
     */
    protected function _prepareDeleteImage($key)
    {
        $values = $this->getValue();
        $file = isset($values[$key]['image']['value']) ?
            $this->getUploadDirPath($values[$key]['image']['value']) : null;

        if(file_exists($file) && !is_dir($file)) {
            unlink($file);
        }
    }

    protected function _prependScopeInfo($path)
    {
        $scopeInfo = $this->getScope();
        if (ScopeConfigInterface::SCOPE_TYPE_DEFAULT != $this->getScope()) {
            $scopeInfo .= '/' . $this->getScopeId();
        }
        return $scopeInfo . '/' . $path;
    }

    /**
     * @return bool
     */
    protected function _addWhetherScopeInfo()
    {
        $fieldConfig = $this->getFieldConfig();
        $dirParams = array_key_exists('upload_dir', $fieldConfig) ? $fieldConfig['upload_dir'] : [];
        return is_array($dirParams) && array_key_exists('scope_info', $dirParams) && $dirParams['scope_info'];
    }

    protected function _getAllowedExtensions()
    {
        return ['jpg', 'jpeg', 'gif', 'png'];
    }

    /**
     * @return array
     */
    protected function getFileData()
    {
        $files = [];

        $tmpNames = $this->_requestData->getTmpName($this->getPath()) ?: [];
        $names    = $this->_requestData->getName($this->getPath()) ?: [];

        foreach ($tmpNames as $key => $tmpName) {
            if(!empty($tmpName['image'])) {
                $files[$key]['tmp_name'] = $tmpName['image'];
            }
        }

        foreach ($names as $key => $name) {
            if(!empty($name['image'])) {
                $files[$key]['name'] = $name['image'];
            }
        }

        return $files;
    }

    /**
     * @return mixed|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getUploadDir()
    {
        $fieldConfig = $this->getFieldConfig();

        if (!array_key_exists('upload_dir', $fieldConfig)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The base directory to upload file is not specified.')
            );
        }

        if (is_array($fieldConfig['upload_dir'])) {
            $uploadDir = $fieldConfig['upload_dir']['value'];
            if (array_key_exists('scope_info', $fieldConfig['upload_dir'])
                && $fieldConfig['upload_dir']['scope_info']
            ) {
                $uploadDir = $this->_appendScopeInfo($uploadDir);
            }

            $uploadDir = $this->getUploadDirPath($uploadDir);
        } else {
            $uploadDir = (string)$fieldConfig['upload_dir'];
        }

        return $uploadDir;
    }

    /**
     * @param $uploadDir
     * @return string
     */
    protected function getUploadDirPath($uploadDir)
    {
        return $this->_mediaDirectory->getAbsolutePath($uploadDir);
    }

    /**
     * @param $path
     * @return string
     */
    protected function _appendScopeInfo($path)
    {
        $path .= '/' . $this->getScope();
        if (ScopeConfigInterface::SCOPE_TYPE_DEFAULT != $this->getScope()) {
            $path .= '/' . $this->getScopeId();
        }
        return $path;
    }
}
