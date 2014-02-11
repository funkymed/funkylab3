<?php
include "includes/php/bddconf.php";
session_start();
if(isset($_SESSION[sessionName]['user'])):
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <base href="<?php echo url_root; ?>admin/" />
    <title>Backoffice Connect-Factory</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta name="robots" content="index, follow" />
    <!-- JS -->
    <script type="text/javascript" src="includes/js/protoculous-packer.js"></script>
    <script type="text/javascript" src="includes/js/tinymce/tiny_mce.js"></script>
    <script type="text/javascript" src="includes/js/main.js"></script>
    <!--[if lt IE 7]>
    <link type="text/css" rel="stylesheet" href="css/ie7.css" media="screen"/>
    <![endif]-->
</head>
<body>
<div id="top">
    <div style="position:absolute;top:25px;left:95px;" id="ajaxloader">
        <img src="images/ajax-loaderblue.gif" alt="logo"/>
    </div>
</div>
<div id="side" style="overflow:hidden;overflow-x:hidden;">
    <div class="content" id="accordeon"></div>
</div>
<div id="main"></div>
</body>
</html>
<?php else: ?>
<script type="text/javascript">
    document.location="index.html"
</script>
<?php endif; ?>