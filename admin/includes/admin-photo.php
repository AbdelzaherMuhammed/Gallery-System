<?php

class Photo extends DbObject
{
    protected static $dbTable = 'photos';
    protected static $dbTableFields = ['title', 'description', 'image', 'type', 'size', 'caption', 'alternate_text', 'user_id'];
    public $id;
    public $user_id;
    public $title;
    public $caption;
    public $alternate_text;
    public $description;
    public $image;
    public $type;
    public $size;
    public $tmpPath;
    public $uploadDirectory = "images";


    // This is passing $_FILES['uploaded_file'] as an argument
    public $errors = [];
    public $errorMessageArray = array(
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
    );

    public function setFile($file)
    {

        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = 'There was no file uploaded here !';
            return false;
        } elseif ($file['error'] != 0) {
            $this->errors[] = $this->errorMessageArray[$file['error']];
            return false;
        } else {
            $this->image = basename($file['name']);
            $this->tmpPath = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }

    }


    public function saveInfo()
    {
        if ($this->id) {
            $this->update();
        } else {

            if (!empty($this->errors)) {
                return false;
            }

            if (empty($this->image) || empty($this->tmpPath)) {
                $this->errors[] = 'The file is not available';
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->uploadDirectory . DS . $this->image;

            if (file_exists($target_path)) {
                $this->errors[] = "The file {$this->image} already exists";
                return false;
            }


            if (move_uploaded_file($this->tmpPath, $target_path)) {

                if ($this->create()) {
                    unset($this->tmpPath);
                    return true;
                }
            } else {
                $this->errors[] = 'The file directory probably doesn not have permission';
                return false;
            }

        }
    }


    public function picturePath()
    {
        return $this->uploadDirectory . DS .$this->image;
    }


    public static function displaySideBarData($photo_id)
    {
        $photo = Photo::findById($photo_id);

        $output = "<a class='thumbnail' href='#'><img src='{$photo->picturePAth()}' width='100' alt=''></a>";
        $output .= "<p>Image name : {$photo->image}</p>";
        $output .= "<p>Image type : {$photo->type}</p>";
        $output .= "<p>Image Size : {$photo->size} bytes</p>";

        echo $output;
    }





    public function deletePhoto()
    {
        if ($this->delete())
        {
            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->picturePath();
            return unlink($targetPath) ? true : false;
        } else {
            return false;
        }
    }


}