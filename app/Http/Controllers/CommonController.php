<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Helpers\CommonHelper;

class CommonController extends Controller
{
    protected $commonHelper;

    public function __construct(CommonHelper $commonHelper)
    {
        $this->commonHelper = $commonHelper;
    }

    /**
     *  @return JsonResponse
     */
    public function getActiveUsers(): JsonResponse
    {
        return response()->json( $this->commonHelper->getActiveUsers());
    }
}
