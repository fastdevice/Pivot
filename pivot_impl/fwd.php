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

$resTo_json = '{
  "module": "resources",
  "data": {
    "to_did": "",
    "timeout": 50,
    "use_local_resources": false
  }
}';


$app->get('/fwd/{to}/{from}',
      function ($to, $from) use ($app, $resToFrom_json, $failedRequest_json) {

         if (is_numeric($to) and is_numeric($from))
         {
            $jsonArray = json_decode($resToFrom_json); // convert to json object
            $jsonArray->children->_->data->to_did = $app->escape($to);
            $jsonArray->data->caller_id_number = $app->escape($from);
            return json_encode($jsonArray);
         }
         else
         {
            // Error - Failed Request
            $jsonArray = json_decode($failedRequest_json); // convert to json object
            $jsonArray->payload->value1 = $app->escape($to);
            $jsonArray->payload->value2 = $app->escape($from);
            $jsonArray->error->code = "9";
            $jsonArray->error->message = "value not numeric string.";
            return json_encode($jsonArray);
         }
         // Exit
     }
);

$app->get('/fwd/{to}',
      function ($to) use ($app, $resTo_json, $failedRequest_json) {

         if (is_numeric($to))
         {
            $jsonArray = json_decode($resTo_json); // convert to json object
            $jsonArray->data->to_did = $app->escape($to);
            return json_encode($jsonArray);
         }
         else
         {
            // Error - Failed Request
            $jsonArray = json_decode($failedRequest_json); // convert to json object
            $jsonArray->payload->value1 = $app->escape($to);
            $jsonArray->error->code = "9";
            $jsonArray->error->message = "value not numeric string.";
            return json_encode($jsonArray);
         }
         // Exit

      }
);

?>
