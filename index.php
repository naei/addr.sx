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
    <meta charset="UTF-8">
    <title>addr.sx</title>
    <meta name="description" content="Displays your public IP address with a taste of 90's">
    <link rel="icon" href="./addr.sx.ico">
    <style>
      @import url(https://fonts.googleapis.com/css?family=Press+Start+2P);
      html, body { 
        margin: 0;
        background-color:#000020;
      }
      main {
        color: #E3CEAB;
        font-family: 'Press Start 2P', monospace;
        text-align: center;
        margin-top: 12%;
      }
      h1, h2 { font-weight:normal; }
      h1 { font-size: 36px; }
      h2 { font-size: 13px; }
      footer {
        width: 100%;
        height: 30%;
        background-image: url('./sor-city.gif');
        background-size: contain;
        background-repeat: repeat-x;
        background-position: left bottom;
        position: absolute;
        bottom: 0;
        left: 0;
      }
    </style>
  </head>
  <body>
    <main>
        <h1><?= $err1?:$ip ?></h1>
        <h2><?= $err2?:$host ?></h2>
    </main>
    <footer></footer>
  </body>
  <!-- Copyright © 2016 https://github.com/naei/addr.sx -->
</html>