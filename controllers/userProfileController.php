<?php

class userProfileController {
  public function __construct()
  {
    //create new models for required data
    $userProfileModel = new userProfileModel();
    $locationModel = new locationModel();
    //create empty object to store data for template
    $templateData = new stdClass();

    //set report name
    $templateData->title = "My Profile";
    //set page details
    $templateData->details = "Your profile information can be updated, by providing this additional information, new tickets added to helpdesk will default to your settings, saving time when completing various forms.";

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
    $templateData->location = $locationModel->getListOfLocations();
    $templateData->reportResults = $userProfileModel->getuserProfileBysAMAccountName($_SESSION['sAMAccountName']);

    //pass complete data and template to view engine and render
    $view = new Page();
    $view->setTemplate('userProfileView');
    $view->setDataSrc($templateData);
    $view->render();
  }
}
