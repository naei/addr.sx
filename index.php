<?php
/**
 *
 * addr.sx - https://github.com/naei/addr.sx
 * Displays your public IP address with a taste of 90's
 *
 */
if(isset($_GET['404'])) {
  header('HTTP/1.0 404 Not Found');
  $err1 = "404 Not Found";
  $err2 = "The requested URL does not exist";
} else {
  // get user's public IP address
  $ip = getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED')?:
        getenv('REMOTE_ADDR');
  if (strlen($ip) > 15) {
    $ip = substr($ip, 0, 20) . '<br>' . substr($ip, 20);
  }
  // get the current subdomain 
  $sub = array_shift((explode(".",$_SERVER['HTTP_HOST'])));
  // get the current user agent
  $agent = $_SERVER['HTTP_USER_AGENT'];
  // return plain text if the url is called from wget, curl or ip.addr.sx
  if (preg_match('/Wget|curl/',$agent) || $sub == 'ip') {
    header("Content-Type: text/plain");
    echo $ip;
    exit();
  }
  // get IP's host - if the IP contain multiple addresses, only the first one is kept
  $host = gethostbyaddr(explode(', ', $ip)[0]);
} ?>
<!DOCTYPE html>
<html>
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-11095228-7"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-11095228-7');
    </script>
    <meta charset="UTF-8">
    <title>addr.sx</title>
    <meta name="description" content="Displays your public IP address with a taste of 90's">
    <link rel="icon" href="./addr.sx.ico">
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
    <main>
        <h1><?= isset($err1) ? $err1 : $ip ?></h1>
        <h2><?= isset($err2) ? $err2 : $host ?></h2>
    </main>
    <footer>
        <div>
          © 2016-2024 <a href="https://github.com/naei/addr.sx" target="_blank">addr.sx</a>
        </div>
    </footer>
  </body>
  <!-- Copyright © 2016-2024 https://github.com/naei/addr.sx -->
</html>