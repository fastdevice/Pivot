<?php

$resToFrom_json = '{
  "children": {
    "_": {
      "module": "resources",
      "data": {
        "to_did": "",
        "timeout": 50,
        "use_local_resources": false
      }
    }
  },
  "module": "set_cid",
  "data": {
    "caller_id_number": ""
  }
}';


$app->get('/dcid/',
      function () use ($app, $resToFrom_json, $failedRequest_json) {

         $request = \filter_input(\INPUT_GET, "To", FILTER_SANITIZE_STRING);
         // group digits to array
         $dial_array = explode('*', $request);
         
         // assign digit groupings
         // $feature_code = $dial_array['1'];
         $from = $dial_array['2'];
         $to = $dial_array['3'];
         
         if (is_numeric($to) and is_numeric($from) and (sizeof($dial_array) < 5))
         {
            $jsonArray = json_decode($resToFrom_json); // convert to json object
            $jsonArray->children->_->data->to_did = $app->escape($to);
            $jsonArray->data->caller_id_number = $app->escape($from);
            error_log ("JSON : " . json_encode($jsonArray) . "\r\n", 3, './event.log');
            return json_encode($jsonArray);
         }
         else
         {
            // Error - Failed Request
            $jsonArray = json_decode($failedRequest_json); // convert to json object
            $jsonArray->payload->value1 = $app->escape($to);
            $jsonArray->payload->value2 = $app->escape($from);
            $jsonArray->error->code = "9";
            $jsonArray->error->message = "Invalid Format";
            error_log ("ERROR : " . json_encode($jsonArray) . "\r\n", 3, './event.log');
            return json_encode($jsonArray);
         }
         // Exit
     }
);
