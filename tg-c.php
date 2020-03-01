<?php
  $token = '1234567890:AbcdefgHijklmnOpqrstUvwxyz';
  $chatid = '1234567890';
  $json = json_encode(
    array(
	  "method" => "sendMessage",
    "chat_id" => $chatid,
    "text" => "Message from the <b>client</b>",
    "parse_mode" => "html",
    "disable_web_page_preview" => "True"
    )
  );

  try {
    $url = 'http://127.0.0.1/tg-s.php';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, 
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json),
            'X-Key: ' . '51mpl3_s3cr3t_k3y',
            'X-Token: ' . $token
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
    error_log( 'Error posting to server. '. $e->getMessage() );
  }
    }

?>
