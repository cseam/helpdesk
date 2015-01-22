<?php
session_start();
session_destroy();
die("<script>location.href = '/'</script>");
?>