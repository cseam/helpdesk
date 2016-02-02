<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo CODENAME ?></title>
  <link rel="shortcut icon" href="/public/images/BRANDING-favicon.svg" sizes="any" type="image/svg+xml" />
  <link rel="mask-icon" href="/public/images/BRANDING-favicon.svg" color="#0e1011">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <meta name="robots" content="nofollow" />
  <!-- stylesheets -->
  <link rel="stylesheet" type="text/css" href="/public/css/reset.css" />
  <link rel="stylesheet" type="text/css" href="/public/css/style.css" />
  <link rel="stylesheet" type="text/css" href="/public/css/sidr.css" />
  <link rel="stylesheet" type="text/css" href="/public/css/print.css" media="print" />
  <!-- jquery library -->
  <script src="/public/javascript/jquery-2.1.3.min.js" type="text/javascript"></script>
  <!-- custom javascript functions -->
  <script src="/public/javascript/custom.js" type="text/javascript"></script>
  <!-- Google Analytics -->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-59019267-1', 'auto');
    ga('send', 'pageview');
  </script>
  <!-- Responsive chart js -->
  <!--<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">-->
  <link rel="stylesheet" href="/public/css/chartist.min.css" />
  <!--<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>-->
  <script src="/public/javascript/chartist.min.js"></script>
  <!-- Forms simple client validation -->
  <script src="/public/javascript/jquery.validate.min.js" type="text/javascript"></script>
  <!-- Side popout slider for hamburger menu on mobile -->
  <script src="/public/javascript/jquery.sidr.min.js" type="text/javascript"></script>
</head>

<body>
  <div class="section">
    <div id="branding">
      <img src="/public/images/BRANDING-CLC_Logo_PANTONE.svg" style="width:auto;height:10vh;float:left;" alt="clc logo" />
      <?php require_once "views/partials/navigation.php" ?>
    </div>
