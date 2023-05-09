<?php

namespace App\Http\Controllers\Base;

use App\Common\ActionResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\Session;

class BaseController extends RoutingController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){}

    /**
     * Return success response in json format
     * 
     * @param string|ActionResponse $message_or_response
     * @param array $data
     */
    protected function jsonSuccess($message_or_response = '', $data = [])
    {
        if ($message_or_response instanceof ActionResponse) {
            $message = $message_or_response->message();
            $data = $message_or_response->data();
        } else {
            $message = !empty($message) ? $message : '';
        }

        Session::flash('message', $message);
        Session::flash('alert-class', 'alert-success');

        return response()->json([
            'success'   => true,
            'message'   => $message,
            'data'      => $data,
        ], 200);
    }

    /**
     * Return error response in json format
     * 
     * @param string|ActionResponse $message_or_response
     * @param int $error_code
     */
    protected function jsonError($message_or_response = 'Something went wrong', $error_code = 400)
    {
        if ($message_or_response instanceof ActionResponse) {
            $message = $message_or_response->message();
        } else {
            $message = __($message_or_response);
        }

        Session::flash('message', $message);
        Session::flash('alert-class', 'alert-danger');
        
        return response()->json([
            'success'   => false,
            'message'   => $message,
        ], $error_code); // Status code here
    }

    /**
     * Return success/error response in json format
     * @param ActionResponse $res
     */
    protected function jsonResponse($res)
    {
        if ($res->isError()) {
            return $this->jsonError($res);
        } else {
            return $this->jsonSuccess($res);
        }
    }
}
