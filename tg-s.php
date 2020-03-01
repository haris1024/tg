<?php

if (($_SERVER['REQUEST_METHOD'] === 'POST') && 
    ($_SERVER['CONTENT_TYPE'] === 'application/json') &&
    ($_SERVER['HTTP_X_KEY'] === '51mpl3_53cr3t_k3y') &&
    isset($_SERVER['HTTP_X_TOKEN'])) {
    
  $token = $_SERVER['HTTP_X_TOKEN'];
  $json = file_get_contents('php://input');

  try {
    $url = $url = "https://api.telegram.org/bot".$token."/sendMessage";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              'Content-Type: application/json',
              'Content-Length: ' . strlen($json)
      )
    );

    if (curl_exec($ch) === false) {
      throw new Exception($url . ' - ' . curl_error($ch));
    } else {
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      if ($httpCode != '200') {
        throw new Exception($url . ' Http code: ' . $httpCode);
      }
    }

    curl_close($ch);
  } catch(Exception $e) {
    error_log( 'Error posting to Telegram. '. $e->getMessage() );
  }
  
}

?>
