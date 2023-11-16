<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;
use App\Models\CollageModel;

class Controller extends BaseController
{
    /**
     * Undocumented function
     *
     * @return Response
     */
    public function index(): Response
    {
        return (new CollageModel)->getCollage();
    }
}
