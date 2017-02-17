<?php
class ImageObject extends DbConn {

    // Get images for Home page
	public function getImages($minimum, $maximum) {
		$conf = new GlobalConf;

		$success = '';
        try {

            $db = new DbConn;
            $tbl_images = $db->tbl_images;
            $tbl_members = $db->tbl_members;

            $stmt = $db->conn->prepare("SELECT * FROM (SELECT * FROM ".$tbl_images." ORDER BY server_uploadtime DESC LIMIT :minimum, :maximum ) sub ORDER BY server_uploadtime ASC");
            $stmt->bindParam(':minimum', intval($minimum), PDO::PARAM_INT);
            $stmt->bindParam(':maximum', intval($maximum), PDO::PARAM_INT);
            
            $result = $stmt->execute();

            $output = array();
            if ($result) {
            	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            		$image = array();
                    $stmt2 = $db->conn->prepare("SELECT * FROM ".$tbl_members." WHERE id = :user");
                    $stmt2->bindParam(':user', $row['user']);
                    $stmt2->execute();
                    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            		$image['filename'] = 'tmp/'.$row['filename_hash'];
            		$image['comment'] = $row['comment'];
                    $image['user'] = $result2['username'];
                    $image['date'] = $row['server_uploadtime'];
            		array_push($output, $image);
            	}
            }
            
            $stmt3 = $db->conn->prepare("SELECT COUNT(*) as count FROM ".$tbl_images);
            $stmt3->execute();
            $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);

            $success = array(true, $result3['count'], $output);

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }
            
        $err = '';

        return $success;
	}

    // Get images for Profile Page
    public function getOwnImages() {
        $conf = new GlobalConf;

        $success = '';
        try {

            $db = new DbConn;
            $tbl_images = $db->tbl_images;
            $tbl_members = $db->tbl_members;

            $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_images." WHERE user = :user");
            $stmt->bindParam(':user', $_SESSION['user_id']);
            
            $result = $stmt->execute();

            $output = array();
            if ($result) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $image = array();

                    $image['filename'] = $row['filename_hash'];
                    $image['url'] = 'tmp/'.$row['filename_hash'];
                    $image['comment'] = $row['comment'];
                    array_push($output, $image);
                }
            }

            $success = array(true, $stmt->rowCount(), $output);

        } catch (PDOException $e) {
            //echo $e->getMessage();
            //$err = "Error: " . $e->getMessage();
            $success = array(false, NULL, NULL);
        }
            
        $err = '';

        return $success;
    }

    // Delete an image
    public function deleteImage($image) {
        $conf = new GlobalConf;

        $success = '';
        try {

            $db = new DbConn;
            $tbl_images = $db->tbl_images;
            $tbl_members = $db->tbl_members;

            $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_images." WHERE filename_hash = :filename");
            $stmt->bindParam(':filename', $image);
            
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['user'] == $_SESSION['user_id']) {
                $stmt2 = $db->conn->prepare("DELETE FROM ".$tbl_images." WHERE filename_hash = :filename");
                $stmt2->bindParam(':filename', $image);
                $stmt2->execute();

                $success = array(true, NULL, NULL);
            }
            else {
               $success = array(false, NULL, NULL); 
            }
            

        } catch (PDOException $e) {
            echo $e->getMessage();
            $err = "Error: " . $e->getMessage();

        }
            
        $err = '';

        return $success;
    }

    // Update Comment 
    public function updateComment($image, $comment) {
        $conf = new GlobalConf;

        $success = '';
        try {

            $db = new DbConn;
            $tbl_images = $db->tbl_images;
            $tbl_members = $db->tbl_members;

            $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_images." WHERE filename_hash = :filename");
            $stmt->bindParam(':filename', $image);
            
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['user'] == $_SESSION['user_id']) {
                $stmt2 = $db->conn->prepare("UPDATE ".$tbl_images." SET comment = :comment WHERE id = :image_id;");
                $stmt2->bindParam(':image_id', $result['id']);
                $stmt2->bindParam(':comment', $comment);
                $stmt2->execute();
            }

            $success = array(true, NULL, NULL);

        } catch (PDOException $e) {
            echo $e->getMessage();
            $err = "Error: " . $e->getMessage();

        }
            
        $err = '';

        return $success;
    }
}