<?php
  // create routes object
  $route = new Route();
  // routes are regular expressions to load corisponding controller
  // default routes top level landing pages routes
    $route->add('/', 'homeController');
    $route->add('/login', 'loginController');
    $route->add('/logout', 'logoutController');
  // user routes
    $route->add('/user', 'actionUserDefault');
    $route->add('/user/profile', 'actionUserProfile');
    $route->add('/user/complete', 'actionComplete');
  // engineer routes
  if ($_SESSION['engineerLevel'] > 0 || $_SESSION['superuser'] == 1) {
    $route->add('/engineer', 'actionEngineerDefault');
    $route->add('/engineer/search', 'actionReportSearch');
    $route->add('/engineer/lockers', 'actionReportLockers');
    $route->add('/engineer/changecontrol', 'actionReportChangecontrol');
    $route->add('/engineer/outofhours', 'actionReportOutofhours');
    $route->add('/engineer/workrate', 'actionReportWorkrate');
    $route->add('/engineer/objectives', 'actionViewObjectives');
  }
  // manager routes
  if ($_SESSION['engineerLevel'] == 2 || $_SESSION['superuser'] == 1) {
    $route->add('/manager', 'actionManagerDefault');
    $route->add('/manager/report', 'actionManagerReports');
    $route->add('/manager/objectives', 'actionViewObjectives');
    $route->add('/manager/addobjectives','actionAddObjectives');
    $route->add('/manager/modifyobjectives','actionModifyObjectives');
    $route->add('/manager/report/escalated', 'actionReportEscalated');
    $route->add('/manager/report/unassigned', 'actionReportUnassigned');
    $route->add('/manager/report/assigned', 'actionReportAssigned');
    $route->add('/manager/report/open', 'actionReportOpen');
    $route->add('/manager/report/stagnate', 'actionReportStagnate');
    $route->add('/manager/report/7days', 'actionReport7days');
    $route->add('/manager/report/sentaway', 'actionReportSentaway');
    $route->add('/manager/report/onhold', 'actionReportOnhold');
    $route->add('/manager/report/closed', 'actionReportClosed');
    $route->add('/manager/report/all', 'actionReportAll');
    $route->add('/manager/report/invoice', 'actionReportInvoice');
    $route->add('/manager/report/search', 'actionReportSearch');
    $route->add('/manager/report/working-on', 'actionReportWorkingon');
    $route->add('/manager/report/jobsheet', 'actionReportJobsheet');
    $route->add('/manager/report/changecontrol', 'actionReportChangecontrol');
    $route->add('/manager/report/lockers', 'actionReportLockers');
    $route->add('/manager/report/scheduledtasks', 'actionReportScheduledtasks');
    $route->add('/manager/report/outofhours', 'actionReportOutofhours');
    $route->add('/manager/report/performanceobjectives', 'actionReportPerformanceobjectives');
  }
  // admin routes
  if ($_SESSION['superuser'] == 1) {
    $route->add('/admin', 'actionAdminDefault');
    $route->add('/admin/managehelpdesks', 'actionAdminManageHelpdesks');
    $route->add('/admin/manageengineers', 'actionAdminManageEngineers');
    $route->add('/admin/managelocations', 'actionAdminManageLocations');
    $route->add('/admin/manageadditional', 'actionAdminManageAdditional');
    $route->add('/admin/managecallreasons', 'actionAdminManageCallreasons');
    $route->add('/admin/managecatagories', 'actionAdminManageCatagories');
    $route->add('/admin/manageoutofhours', 'actionAdminManageOutofhours');
    $route->add('/admin/managequickresponses', 'actionAdminManageQuickresponses');
    $route->add('/admin/managesla', 'actionAdminManageSla');
    $route->add('/admin/complete', 'actionAdminComplete');
    $route->add('/admin/location', 'actionAdminModifyLocation');
    $route->add('/admin/category', 'actionAdminModifyCategory');
    $route->add('/admin/reason', 'actionAdminModifyReason');
    $route->add('/admin/outofhours', 'actionAdminModifyOutofhours');
    $route->add('/admin/quickresponse', 'actionAdminModifyQuickResponse');
    $route->add('/admin/helpdesk', 'actionAdminModifyHelpdesk');
    $route->add('/admin/sla', 'actionAdminModifySla');
    $route->add('/admin/engineer', 'actionAdminModifyEngineer');
    $route->add('/admin/additional', 'actionAdminModifyAdditional');
  }
  // report routes
    $route->add('/report', 'actionReportDefault');
    $route->add('/report/engineerbreakdown', 'actionReportEngineerbreakdown');
    $route->add('/report/helpdeskbreakdown', 'actionReportHelpdeskbreakdown');
    $route->add('/report/categorybreakdown', 'actionReportCategorybreakdown');
    $route->add('/report/urgencybreakdown', 'actionReportUrgencybreakdown');
    $route->add('/report/daybreakdown', 'actionReportDaybreakdown');
    $route->add('/report/plannedvs', 'actionReportPlannedvs');
    $route->add('/report/sla', 'actionReportSla');
    $route->add('/report/feedback', 'actionReportFeedback');
    $route->add('/report/workrate', 'actionReportWorkrate');
    $route->add('/report/assignednumbers', 'actionReportAssignednumbers');
    $route->add('/report/reason', 'actionReportReason');
    $route->add('/report/recentwork', 'actionReportRecentWork');
    $route->add('/report/outstanding', 'actionReportOutstanding');
    $route->add('/report/annualgraphs', 'actionReportAnnualgraphs');
  // ticket routes
    $route->add('/ticket', 'actionTicketDefault');
    $route->add('/ticket/add', 'actionAddTicket');
    $route->add('/ticket/update', 'actionUpdateTicket');
    $route->add('/ticket/updated', 'actionUpdatedTicket');
    $route->add('/ticket/view', 'actionViewTicket');
    $route->add('/ticket/view/\d*', 'actionViewTicket');
    $route->add('/ticket/assign', 'actionAssignTicket');
    $route->add('/ticket/forward', 'actionForwardTicket');
    $route->add('/ticket/feedback', 'actionFeedbackTicket');
    $route->add('/ticket/description', 'actionDescriptionTicket');
    $route->add('/ticket/category', 'actionCategoryTicket');
    $route->add('/ticket/additional', 'actionAdditionalTicket');
  // change control routes
  if ($_SESSION['engineerLevel'] > 0 || $_SESSION['superuser'] == 1) {
    $route->add('/changecontrol', 'actionAddChangeControl');
    $route->add('/changecontrol/add', 'actionAddChangeControl');
  // out of hours routes
    $route->add('/outofhours', 'actionAddOutofhours');
    $route->add('/outofhours/add', 'actionAddOutofhours');
  // scheduled task routes
    $route->add('/scheduledtask', 'actionAddScheduledtask');
    $route->add('/scheduledtask/add', 'actionAddScheduledtask');
    $route->add('/scheduledtask/modify', 'actionModifyScheduledtask');
    $route->add('/scheduledtask/delete', 'actionDeleteScheduledtask');
  }
  // digital sign routes
    $route->add('/digitalsign', 'actionDigitalSignDefault');
