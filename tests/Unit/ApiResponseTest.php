<?php

namespace Tests\Unit;

use App\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class ApiResponseTest
{   
    /** @test */
    public function it_returns_a_success_response()
    {
        $data = ['key' => 'value'];
        $message = "Success";
        $response = ApiResponse::success($data, $message);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $response->getData(true));
    }
}
