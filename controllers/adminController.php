<?php

class adminController {
  public function __construct()
  {
    //check engineer level before processing routes
    if ($_SESSION['superuser'] != 1) {
      $error = new stdClass();
      $error->title = "403 Forbidden";
      $error->message = "Opps! you dont have permission to view this page.";
      require_once "views/errorView.php";
      exit;
    }
    // look for methods or render default routes
    // create methods object.
    $methods = new Route();
    $methods->add('/', 'actionAdminDefault');
    $methods->add('/managehelpdesks', 'actionAdminManageHelpdesks');
    $methods->add('/manageengineers', 'actionAdminManageEngineers');
    $methods->add('/managelocations', 'actionAdminManageLocations');
    $methods->add('/manageadditional', 'actionAdminManageAdditional');
    $methods->add('/managecallreasons', 'actionAdminManageCallreasons');
    $methods->add('/managecatagories', 'actionAdminManageCatagories');
    $methods->add('/manageoutofhours', 'actionAdminManageOutofhours');
    $methods->add('/managequickresponses', 'actionAdminManageQuickresponses');
    $methods->add('/managesla', 'actionAdminManageSla');
    $methods->add('/complete', 'actionAdminComplete');
    $methods->add('/location', 'actionAdminModifyLocation');
    $methods->add('/category', 'actionAdminModifyCategory');
    $methods->add('/reason', 'actionAdminModifyReason');
    $methods->add('/outofhours', 'actionAdminModifyOutofhours');
    $methods->add('/quickresponse', 'actionAdminModifyQuickResponse');
    $methods->add('/helpdesk', 'actionAdminModifyHelpdesk');
    $methods->process(2);
  }

}
