<?php

class userProfileController {
  public function __construct()
  {
    //load content for left side of page
    $left = new leftpageController();
    //create new models for required data
    $pagedata = new stdClass();
    $userProfileModel = new userProfileModel();
    $locationModel = new locationModel();
    //set report name
    $pagedata->title = "My Profile";
    //set page details
    $pagedata->details = "Your profile information can be updated, by providing this additional information, new tickets added to helpdesk will default to your settings, saving time when completing various forms.";

    //Post Update Locations
      if ($_POST) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $switch = $_POST["button_value"];
        SWITCH ($switch) {
          CASE "add":
            // upsert locations
            $object = new stdClass();
            $object->id = empty($_POST["id"]) ? null : htmlspecialchars($_POST["id"]);
            $object->sAMAccountName = htmlspecialchars($_SESSION['sAMAccountName']);
            $object->contactName = htmlspecialchars($_POST["contactName"]);
            $object->contactEmail = htmlspecialchars($_POST["contactEmail"]);
            $object->contactTel = htmlspecialchars($_POST["contactTel"]);
            $object->location = htmlspecialchars($_POST["location"]);
            $object->notify = htmlspecialchars($_POST["notify"]);
            $userProfileModel->upsertUserProfile($object);
            // update profile picture
              $upload_code = $ext = null;
              if (is_uploaded_file($_FILES['attachment']['tmp_name']))  {
                //define uploads folder from config
                $upload = ROOT . "/uploads/profile_images/" . $_SESSION['sAMAccountName'] . ".jpg";
                //define temp upload location
                $tmp_path = $_FILES["attachment"]["tmp_name"];
                //check file is jpeg
                if (mime_content_type($tmp_path) == "image/jpeg") {
                  //resize image
                  $resize_tmp = imagecreatefromjpeg($tmp_path);
                  $resize_scl = imagescale($resize_tmp, 200, 300);
                  imagejpeg($resize_scl, $tmp_path);
                  imagedestroy($resize_tmp);
                  imagedestroy($resize_scl);
                  //move file from temp location to uploads folder
                  move_uploaded_file($tmp_path, $upload);
                }
              }
            // PRG Redirect
            header('Location: /user/complete');
            exit;
          break;
        }
      }

    //populate user profile
    $pagedata->location = $locationModel->getListOfLocations();
    $pagedata->reportResults = $userProfileModel->getuserProfileBysAMAccountName($_SESSION['sAMAccountName']);

    // render page
    require_once "views/userProfileView.php";
  }
}
