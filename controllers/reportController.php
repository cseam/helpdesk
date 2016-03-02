<?php

class reportController {
  public function __construct()
  {
    // create route for reports
    $generatereport = new Route();
    $generatereport->add('/', 'actionReportDefault');
    $generatereport->add('/engineerbreakdown', 'actionReportEngineerbreakdown');
    $generatereport->add('/helpdeskbreakdown', 'actionReportHelpdeskbreakdown');
    $generatereport->add('/categorybreakdown', 'actionReportCategorybreakdown');
    $generatereport->add('/urgencybreakdown', 'actionReportUrgencybreakdown');
    $generatereport->add('/plannedvs', 'actionReportPlannedvs');
    $generatereport->add('/sla', 'actionReportSla');
    $generatereport->add('/feedback', 'actionReportFeedback');
    $generatereport->add('/workrate', 'actionReportWorkrate');
    $generatereport->add('/assignednumbers', 'actionReportAssignednumbers');
    $generatereport->add('/reason', 'actionReportReason');
    $generatereport->process(2);
  }

}
