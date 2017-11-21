<?php


$say_json = '{"module":"tts", "data": {"text":""}}';


$app->get('/say/{text}',
      function ($text) use ($app, $say_json, $failedRequest_json) {

         if (!empty($text))
         {
            $jsonArray = json_decode($say_json); // convert to json object
            $jsonArray->data->text = $app->escape($text);
            return json_encode($jsonArray);
         }
         else
         {
            // Error - Failed Request
            $jsonArray = json_decode($failedRequest_json); // convert to json object
            $jsonArray->payload->value1 = $app->escape($text);
            $jsonArray->error->code = "9";
            $jsonArray->error->message = "missing string.";
            return json_encode($jsonArray);
         }
         // Exit

      }
);
