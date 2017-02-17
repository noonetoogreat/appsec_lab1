<?php
class UploadForm extends DbConn
{
    public function insertImage($Photoname, $File_Name, $File_Ext, $File_Name_Hash, $User, $UploadTime, $Comment)
    {
        $conf = new GlobalConf;

        $success = '';
        try {

            $db = new DbConn;
            $tbl_images = $db->tbl_images;
            $stmt = $db->conn->prepare("INSERT INTO ".$tbl_images." (id, imagename, filename, filetype, filename_hash, user, uploadtime, comment, server_uploadtime) VALUES (NULL, :imagename, :filename, :filetype, :filename_hash, :user, :uploadtime, :comment, CURRENT_TIMESTAMP)");
            $stmt->bindParam(':imagename', $Photoname);
            $stmt->bindParam(':filename', $File_Name);
            $stmt->bindParam(':filetype', $File_Ext);
            $stmt->bindParam(':filename_hash', $File_Name_Hash);
            $stmt->bindParam(':user', $User);
            $stmt->bindParam(':uploadtime', $UploadTime);
            $stmt->bindParam(':comment', $Comment);
            $stmt->execute();

            $success = "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>File Upload Success</div>";

        } catch (PDOException $e) {
            echo $e->getMessage();
            $err = "Error: " . $e->getMessage();

        }
            
        $err = '';

        return $success;
    }


}
