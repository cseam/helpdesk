<?php
  // create routes object
  $route = new routeController();
  // routes are regular expressions to load corisponding controller
  // default routes top level landing pages routes
    $route->add('/', 'homeController');
    $route->add('/login', 'loginController');
    $route->add('/logout', 'logoutController');
  // user routes
    $route->add('/user', 'userDefaultController');
    $route->add('/user/profile', 'userProfileController');
    $route->add('/user/complete', 'actionCompleteController');
  // engineer routes
  if (@$_SESSION['engineerLevel'] > 0 || @$_SESSION['superuser'] == 1) {
    $route->add('/engineer', 'engineerDefaultController');
    $route->add('/engineer/search', 'reportSearchController');
    $route->add('/engineer/lockers', 'reportLockersController');
    $route->add('/engineer/changecontrol', 'reportChangeControlController');
    $route->add('/engineer/outofhours', 'reportOutOfHoursController');
    $route->add('/engineer/workrate', 'reportWorkrateController');
    $route->add('/engineer/objectives/\d*', 'viewObjectivesController'); //numerical wildcard route
  }
  // manager routes
  if (@$_SESSION['engineerLevel'] == 2 || @$_SESSION['superuser'] == 1) {
    $route->add('/manager', 'managerDefaultController');
    $route->add('/manager/objectives/\d*', 'viewObjectivesController'); //numerical wildcard route
    $route->add('/manager/addobjectives', 'addObjectivesController');
    $route->add('/manager/modifyobjectives/\d*', 'modifyObjectivesController'); //numerical wildcard route
    $route->add('/manager/report/escalated', 'reportEscalatedController');
    $route->add('/manager/report/unassigned', 'reportUnassignedController');
    $route->add('/manager/report/assigned', 'reportAssignedController');
    $route->add('/manager/report/open', 'reportOpenController');
    $route->add('/manager/report/stagnate', 'reportStagnateController');
    $route->add('/manager/report/7days', 'report7daysController');
    $route->add('/manager/report/sentaway', 'reportSentAwayController');
    $route->add('/manager/report/onhold', 'reportOnHoldController');
    $route->add('/manager/report/closed', 'reportClosedController');
    $route->add('/manager/report/all', 'reportAllController');
    $route->add('/manager/report/invoice', 'reportInvoiceController');
    $route->add('/manager/report/search', 'reportSearchController');
    $route->add('/manager/report/working-on', 'reportWorkingOnController');
    $route->add('/manager/report/jobsheet', 'reportJobSheetController');
    $route->add('/manager/report/changecontrol', 'reportChangeControlController');
    $route->add('/manager/report/lockers', 'reportLockersController');
    $route->add('/manager/report/scheduledtasks', 'reportScheduledTasksController');
    $route->add('/manager/report/outofhours', 'reportOutOfHoursController');
    $route->add('/manager/report/performanceobjectives', 'reportPerformanceObjectivesController');
    $route->add('/manager/report/recentwork/\d*', 'reportRecentWorkController'); //numerical wildcard route
    $route->add('/manager/report/compliance', 'reportComplianceController');
  }
  // admin routes
  if (@$_SESSION['superuser'] == 1) {
    // for superusers only
    $route->add('/admin', 'adminDefaultController');
    $route->add('/admin/managehelpdesks', 'adminManageHelpdesksController');
    $route->add('/admin/manageengineers', 'adminManageEngineersController');
    $route->add('/admin/managelocations', 'adminManageLocationsController');
    $route->add('/admin/manageadditional', 'adminManageAdditionalController');
    $route->add('/admin/managecallreasons', 'adminManageCallReasonsController');
    $route->add('/admin/managecatagories', 'adminManageCatagoriesController');
    $route->add('/admin/manageoutofhours', 'adminManageOutOfHoursController');
    $route->add('/admin/managequickresponses', 'adminManageQuickResponsesController');
    $route->add('/admin/managesla', 'adminManageSLAController');
    $route->add('/admin/complete', 'adminActionCompleteController');
    $route->add('/admin/location/\d*', 'adminModifyLocationController'); //numerical wildcard route
    $route->add('/admin/location/add', 'adminModifyLocationController');
    $route->add('/admin/category/\d*', 'adminModifyCategoryController'); //numerical wildcard route
    $route->add('/admin/category/add', 'adminModifyCategoryController');
    $route->add('/admin/reason/\d*', 'adminModifyReasonController'); //numerical wildcard route
    $route->add('/admin/reason/add', 'adminModifyReasonController');
    $route->add('/admin/outofhours/\d*', 'adminModifyOutOfHoursController'); //numerical wildcard route
    $route->add('/admin/outofhours/add', 'adminModifyOutOfHoursController');
    $route->add('/admin/quickresponse/\d*', 'adminModifyQuickResponseController'); //numerical wildcard route
    $route->add('/admin/quickresponse/add', 'adminModifyQuickResponseController');
    $route->add('/admin/helpdesk/\d*', 'adminModifyHelpdeskController'); //numerical wildcard route
    $route->add('/admin/helpdesk/add', 'adminModifyHelpdeskController');
    $route->add('/admin/sla/\d*', 'adminModifySLAController'); //numerical wildcard route
    $route->add('/admin/sla/add', 'adminModifySLAController');
    $route->add('/admin/engineer/\d*', 'adminModifyEngineerController'); //numerical wildcard route
    $route->add('/admin/engineer/add', 'adminModifyEngineerController');
    $route->add('/admin/additional/\d*', 'adminModifyAdditionalController'); //numerical wildcard route
    $route->add('/admin/additional/add', 'adminModifyAdditionalController');
  }
  // report routes
    $route->add('/report', 'reportDefaultController');
    $route->add('/report/engineerbreakdown', 'reportEngineerBreakdownController');
    $route->add('/report/helpdeskbreakdown', 'reportHelpdeskBreakdownController');
    $route->add('/report/categorybreakdown', 'reportCategoryBreakdownController');
    $route->add('/report/urgencybreakdown', 'reportUrgencyBreakdownController');
    $route->add('/report/daybreakdown', 'reportDayBreakdownController');
    $route->add('/report/plannedvs', 'reportPlannedVsController');
    $route->add('/report/workrate', 'reportWorkrateController');
    $route->add('/report/assignednumbers', 'reportAssignedNumbersController');
    $route->add('/report/reason', 'reportReasonController');
    $route->add('/report/outstanding', 'reportOutstandingController');
    $route->add('/report/annualgraphs', 'reportAnnualGraphsController');
    $route->add('/report/settings', 'reportSettingsController');
  if (@$_SESSION['engineerLevel'] == 2 || @$_SESSION['superuser'] == 1) {
    // reports for managers only
    $route->add('/report/feedback', 'reportFeedbackController');
    $route->add('/report/feedback/\d*', 'reportFeedbackListController'); //numerical wildcard route
    $route->add('/report/sla', 'reportSlaController');
  }
  // ticket routes
    $route->add('/ticket/add', 'addTicketController');
    $route->add('/ticket/update', 'updateTicketController');
    $route->add('/ticket/updated', 'viewUpdatedTicketController');
    $route->add('/ticket/view/\d*', 'viewTicketController'); //numerical wildcard route
    $route->add('/ticket/assign/\d*', 'assignTicketController'); //numerical wildcard route
    $route->add('/ticket/forward/\d*', 'forwardTicketController'); //numerical wildcard route
    $route->add('/ticket/feedback/\d*', 'feedbackTicketController'); //numerical wildcard route
    $route->add('/ticket/description/\d*', 'formDescriptionTicketController'); //numerical wildcard route
    $route->add('/ticket/category/\d*', 'formCategoryTicketController'); //numerical wildcard route
    $route->add('/ticket/additional/\d*', 'formAdditionalTicketController'); //numerical wildcard route
    $route->add('/ticket/schedule/\d*', 'scheduleController'); //numerical wildcard route
  // change control routes
  if (@$_SESSION['engineerLevel'] > 0 || @$_SESSION['superuser'] == 1) {
    $route->add('/changecontrol', 'addChangeControlController');
    $route->add('/changecontrol/add', 'addChangeControlController');
  // out of hours routes
    $route->add('/outofhours', 'addOutOfHoursController');
    $route->add('/outofhours/add', 'addOutOfHoursController');
  // scheduled task routes
    $route->add('/scheduledtask', 'addScheduledTaskController');
    $route->add('/scheduledtask/add', 'addScheduledTaskController');
    $route->add('/scheduledtask/modify/\d*', 'modifyScheduledTaskController');
    $route->add('/scheduledtask/delete/\d*', 'deleteScheduledTaskController'); //numerical wildcard route
  }
  // digital sign routes
    $route->add('/digitalsign', 'digitalSignDefaultController');
