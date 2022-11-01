<?php

namespace App\Helpers;

  class ResponseHelper{

      public static function responseValidation($errors)
      {
        return response()->json([
            'status' => false,
            'message' => (!is_object($errors)) ? $errors : $errors->all(),
            'data' => null
        ], 422);
      }

      public static function responseError($msg, $code, $data = null)
      {
          return response()->json([
              'status' => false,
              'message' => $msg,
              'data' => $data,
          ], $code);
      }

      public static function responseSuccess($msg = null)
      {
          return response()->json([
              'status' => true,
              'message' => $msg,
          ], 200);
      }

      public static function responseSuccessWithData($msg = null, $data = null)
      {
          return response()->json([
              'status' => true,
              'message' => $msg,
              'data' => $data
          ], 200);
      }

      public static function responseCreated($msg = null, $data = null)
      {
          return response()->json([
              'status' => true,
              'message' => $msg,
              'data' => $data
          ], 201);
      }

      public static function responseServer()
      {
          return response()->json([
              'status' => false,
          ], 500);
      }
  }
