<?php

declare(strict_types=1);

namespace PaymentReport\Http\Controllers\Api;

use App\Traits\ResponseHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OAA;

#[OAA\Info(
    version: '1.0.0',
    title: 'GWCL OpenApi Payment Report documentation',
    license: new OAA\License(
        name: 'Apache 2.0',
        url: 'http://www.apache.org/licenses/LICENSE-2.0.html',
    )
)]

#[OAA\SecurityScheme(
    securityScheme: 'bearer_token',
    type: 'http',
    scheme: 'bearer'
)]

/**
 * @OAA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="GWCL API Server"
 * )
 */
abstract class ApiController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use ResponseHelper;
}
