<?php

class actionManagerReports {
  public function __construct()
  {
    // Dont need to populate $listdata as fixed partial in manager view
    // Dont need to populate $stats as fixed partial in manager view
    // Create routes for reports
    $generatereport = new Route();
    $generatereport->add('/', 'actionManagerDefault');
    $generatereport->add('/escalated', 'actionReportEscalated');
    $generatereport->add('/unassigned', 'actionReportUnassigned');
    $generatereport->process(3);

  }

}
