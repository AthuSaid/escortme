<?php


/**
* 
*/
class PictureService{
    
    const FILE_VAR = 'picture';

    private $logger;
    private $db;

    function __construct($logger, $db){
        $this->logger = $logger;
        $this->db = $db;
    }

    public function getGallery($userId){
        $pics = $this->db->select("esc_picture", "id", [
            "user_id" => $userId,
            "ORDER" => "created"
          ]);
        $gallery = array();
        if(count($pics) > 0)
            $gallery = $pics;
        return $gallery;
    }

    public function setProfilePicture($picId, $usrId){
        $profilePic = $this->db->select("esc_profil_picture", "*",
            ["user_id" => $usrId]);
        if(count($profilePic) == 0){
            $this->db->insert("esc_profil_picture",
                ["picture_id" => $picId, "user_id" => $usrId]);
        }
        else{
            $this->db->update("esc_profil_picture",
                ["picture_id" => $picId],
                ["user_id" => $usrId]);
        }
    }

    public function delete($picId, $usrId){
        $isProfilePic = $this->db->get("esc_profil_picture", "*",
            ["picture_id" => $picId, "user_id" => $usrId]);
        if($isProfilePic){
            $this->db->delete("esc_profil_picture",
                ["picture_id" => $picId, "user_id" => $usrId]);
        }

        $this->db->delete("esc_picture", ["id" => $picId]);

        unlink("../data/".$picId."-thumbnail.jpg");
        unlink("../data/".$picId."-full.jpg");
    }

    /**
     * Stores the uploaded picture in the data store
     * and resizes and crops it. Then saves to the db.
     * @param  [type] $httpFile [description]
     * @param  [type] $usrId    [description]
     * @return [type]           [description]
     */
    public function upload($httpFile, $usrId){

        //Check for error while uploading
        if($httpFile[self::FILE_VAR]['error'] > 0){
            throw new Exception("Fehler beim Upload");
        }

        //Get Data
        $fileName = $httpFile[self::FILE_VAR]['name'];
        $fileExtension = strrchr($fileName, ".");
        $fileType = $httpFile[self::FILE_VAR]['type'];
        $fileSiize = $httpFile[self::FILE_VAR]['size'];
        $fileTempPath = $httpFile[self::FILE_VAR]['tmp_name'];

        $picId = Uuid::next();

        //Validate
        $validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
        if(!in_array($fileExtension, $validExtensions)){
            throw new Exception("Kein gültiges Format");
        }

        //Croping the pic
        $manipulatorOrig = new ImageManipulator($fileTempPath);
        $origWidth = $manipulatorOrig->getWidth();
        $origHeight = $manipulatorOrig->getHeight();
        $xStart = 0;
        $yStart = 0;
        $xEnd = $origWidth;
        $yEnd = $origHeight;
        if($origWidth > $origHeight){
            $xStart = ($origWidth / 2) - ($origHeight / 2);
            $xEnd = $xStart + $origHeight;
        }
        if($origHeight > $origWidth){
            $yStart = ($origHeight / 2) - ($origWidth / 2);
            $yEnd = $yStart + $origWidth;
        }
        $manipulatorOrigCropped = $manipulatorOrig->crop($xStart, $yStart, $xEnd, $yEnd);

        //Resize to Full (800x800) and save
        $fullPath = "../data/".$picId."-full.jpg";
        $manipulatorFull = $manipulatorOrigCropped->resample(800, 800);
        $manipulatorFull->save($fullPath);

        //Resize to Thumbnail (128x128) and save
        $thumbnailPath = "../data/".$picId."-thumbnail.jpg";
        $manipulatorThumbnail = $manipulatorOrigCropped->resample(128, 128);
        $manipulatorThumbnail->save($thumbnailPath);
       
        //DB insert
        $this->db->insert("esc_picture", ["id" => $picId, "user_id" => $usrId]);

        return $picId;

    }
    
}

?>