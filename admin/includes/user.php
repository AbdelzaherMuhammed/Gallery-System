<?php

class User extends DbObject
{
    protected static $dbTable = 'users';
    protected static $dbTableFields = ['username', 'password', 'first_name', 'last_name' , 'image'];
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $image;
    public $tmpPath;
    public $uploadDirectory = 'images';
    public $imagePlaceholder = "https://via.placeholder.com/400?text=image";
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
                    unset($this->tmpPath);
                    return true;

            } else {
                $this->errors[] = 'The file directory probably doesn not have permission';
                return false;
            }


    }

    public function imagePathPlaceholder()
    {
        return (empty($this->image)) ? $this->imagePlaceholder:$this->uploadDirectory . DS . $this->image;
    }
    
    
    public static function verifyUser($username, $password)
    {
        global $database;

        $username = $database->escapeString($username);
        $password = $database->escapeString($password);

        $sql = "SELECT * FROM " . self::$dbTable . " WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $the_result_array = self::FindByQuery($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;

    }


    public function ajaxSaveUserImage($image_name, $user_id)
    {
        global $database;

        $image_name = $database->escapeString($image_name);
        $user_id = $database->escapeString($user_id);

        $this->image    = $image_name;
        $this->id       = $user_id;

        $sql = "UPDATE " .self::$dbTable . " SET image =  '{$this->image}' ";
        $sql .= "WHERE id= {$this->id} ";
        $updateImage = $database->query($sql);

        echo $this->imagePathPlaceholder();
    }


    public function deletePhoto()
    {
        if ($this->delete())
        {
            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->imagePathPlaceholder();
            return unlink($targetPath) ? true : false;
        } else {
            return false;
        }
    }


    public function photos()
    {
        return Photo::findByQuery("SELECT * FROM photos WHERE user_id= " .$this->id );
    }

} //End of user class







