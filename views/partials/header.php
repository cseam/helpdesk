<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo CODENAME ?></title>
  <link rel="shortcut icon" href="/public/images/BRANDING-favicon.svg" sizes="any" type="image/svg+xml" />
  <link rel="apple-touch-icon" href="/public/images/BRANDING-favicon.svg" sizes="any" type="image/svg+xml" />
  <link rel="mask-icon" href="/public/images/BRANDING-favicon.svg" color="#0e1011">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <meta name="robots" content="nofollow" />
  <!-- critical path inline styles -->
  <style>
    /* development held on critical path css due to browser support */
  </style>
  <!-- additional stylesheets -->
  <!-- <link rel="preload" as="style" href="/public/css/reset.css" onload="this.rel='stylesheet'" /> -->
  <link rel="stylesheet" type="text/css" href="/public/css/reset.css" />
  <!-- <link rel="preload" as="style" href="/public/css/style.css" onload="this.rel='stylesheet'" /> -->
  <link rel="stylesheet" type="text/css" href="/public/css/style.css?version=1.2" />
  <!-- <link rel="preload" as="style" href="/public/css/sidr.css" onload="this.rel='stylesheet'" /> -->
  <link rel="stylesheet" type="text/css" href="/public/css/sidr.css" />
  <link rel="stylesheet" type="text/css" href="/public/css/print.css" media="print" />
  <!-- jquery library -->
  <script src="/public/javascript/jquery-2.1.3.min.js" type="text/javascript"></script>
  <!-- custom javascript functions -->
  <script src="/public/javascript/custom.js" type="text/javascript"></script>
  <!-- Google Analytics -->
  <?php include "views/partials/googleAnalytics.php"; ?>
  <!-- Responsive chart js -->
  <!--<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">-->
  <link rel="stylesheet" href="/public/css/chartist.min.css" />
  <!--<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>-->
  <script src="/public/javascript/chartist.min.js"></script>
  <!-- Forms simple client validation -->
  <script src="/public/javascript/jquery.validate.min.js" type="text/javascript"></script>
  <!-- Side popout slider for hamburger menu on mobile -->
  <script src="/public/javascript/jquery.sidr.min.js" type="text/javascript"></script>
  <!-- table sorting jquery plugin for simple sortting on reports -->
  <script src="/public/javascript/jquery.tablesorter.min.js" type="text/javascript"></script>
  <script src="/public/javascript/jquery.ddtf.js" type="text/javascript"></script>
</head>

<body>
  <div class="section">
    <div id="branding">
      <?php if (file_exists("public/images/BRANDING-Logo.svg")) {
        //load custom logo
        echo "<img src=\"/public/images/BRANDING-Logo.svg\" style=\"width:auto;height:10vh;float:left;\" alt=\"logo\" />";
      } else {
        // else user default logo
        echo "<img src=\"/public/images/BRANDING-Default_Logo.svg\" style=\"width:auto;height:10vh;float:left;\" alt=\"logo\" />";
      }; ?>
      <?php require_once "views/partials/navigation.php" ?>
    </div>
