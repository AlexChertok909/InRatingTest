<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\CommonHelper;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{
    protected $commonHelper;

    public function __construct(CommonHelper $commonHelper)
    {
        $this->commonHelper = $commonHelper;
    }

    /**
     * @return JsonResponse
     */
    public function getActiveUsers(): JsonResponse
    {
        return response()->json($this->commonHelper->getActiveUsers());
    }

    /**
     * @return JsonResponse
     */
    public function getUserComments(): JsonResponse
    {
        $checkValidator = Validator::make(request()->toArray(), [
            'user_id' => 'required|integer|digits_between:1,11|min:1',
        ]);;

        if ($checkValidator->fails())
            return response()->json(['error' => implode(" ", $checkValidator->errors()->all())], 400);

        return response()->json($this->commonHelper->getUserComments(request('user_id')));
    }
}
