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
      footer>div {
        color: #999;
        font-size: 12px;
        position: fixed;
        bottom: 0;
        left: 5px;
      }
      footer>div>a {
        color: #999;
      }
      /* modal */
      .modal {
        position: fixed;
        background-color: rgba(0, 0, 0, 0.4);
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 999;
        opacity: 0;
        pointer-events: none;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
        transition: all 0.3s;
      }
      .modal:target {
        opacity: 1;
        pointer-events: auto;
      }
      .modal>div {
        width: 400px;
        max-width: 86%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        color: #ffffff;
        background: #031428;
        font-size: 12px;
        text-align: center;
        border: 2px solid #0e3849;
      }
      .modal img {
        padding: 13px;
        width: 150px;
      }
      .modal header {
        font-weight: bold;
      }
      .modal-close {
        color: #aaa;
        line-height: 30px;
        font-size: 16px;
        font-weight: bold;
        position: absolute;
        right: 10px;
        text-align: right;
        top: 0;
        width: 70px;
        text-decoration: none;
      }
      .modal-close:hover {
        color: #000;
      }
    </style>
  </head>
  <body>
    <main>
        <h1><?= $err1?:$ip ?></h1>
        <h2><?= $err2?:$host ?></h2>
    </main>
    <div id="donate-modal" class="modal">
      <div>
        <a href="#" class="modal-close">×</a>
        <div>
            <br>
            Thank you for using this website!<br>
            If you like this project, feel free to donate. :)<br>
            <img src="./donate-btc-qr.png"><br>
            BTC address: bc1qef67tx0jx6fhg2dp2y62mqkyq6lhusz68vgk24
        </div>
      </div>
    </div>
    <footer>
        <div>
          Copyright © 2016-2020 <a href="https://github.com/naei/addr.sx" target="_blank">addr.sx</a> &nbsp;|&nbsp; <a class="donate" href="#donate-modal">Thank you for your support.</a>
        </div>
    </footer>
  </body>
  <!-- Copyright © 2016-2020 https://github.com/naei/addr.sx -->
</html>