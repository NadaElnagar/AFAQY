<?php


namespace App\Http\Services;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;


class ResponseService
{
    public function responseWithSuccess($data){
        $status = \Illuminate\Http\Response::HTTP_OK;
        $success['status'] = true;
        if($data != null) $success['data'] = $data;
        return response()->json($success, $status);
    }
    public function responseWithFailure($status , $message)
    {
        $fail['status'] = false;
        if($message != null ) $fail['message'] = $message;

        return response()->json($fail, $status);
    }
}
