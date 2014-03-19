<?php

$hit_count = @file_get_contents('count.txt');
$hit_count++;
@file_put_contents('count.txt', $hit_count);
header('Location: ../downloads/Jagrit-Bachpan.apk');
?>
<script type="text/javascript">

  window.location.replace("http://projectjagriti.org");
  //window.location.replace("http://projectjagriti.org");
</script>
