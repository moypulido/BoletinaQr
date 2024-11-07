<?php

namespace Tests\Unit;

use App\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

class ApiResponseTest
{
    public function runTests()
    {
        echo "Running ApiResponse Tests...\n";

        $this->testSuccessResponse();
        $this->testCreatedResponse();
        $this->testBadRequestResponse();
        $this->testUnauthorizedResponse();
        
        echo "All tests completed.\n";
    }

    public function testSuccessResponse()
    {
        $data = ['key' => 'value'];
        $message = "Success";
        $response = ApiResponse::success($data, $message);

        if (!($response instanceof JsonResponse)) {
            echo "Failed: testSuccessResponse - Expected instance of JsonResponse\n";
        }

        if ($response->getStatusCode() !== 200) {
            echo "Failed: testSuccessResponse - Expected status code 200\n";
        }

        $expectedData = [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];

        if ($response->getData(true) !== $expectedData) {
            echo "Failed: testSuccessResponse - Response data does not match expected data\n";
        }
    }

    public function testCreatedResponse()
    {
        $data = ['id' => 1];
        $message = "Resource created";
        $response = ApiResponse::created($data, $message);

        if (!($response instanceof JsonResponse)) {
            echo "Failed: testCreatedResponse - Expected instance of JsonResponse\n";
        }

        if ($response->getStatusCode() !== 201) {
            echo "Failed: testCreatedResponse - Expected status code 201\n";
        }

        $expectedData = [
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ];

        if ($response->getData(true) !== $expectedData) {
            echo "Failed: testCreatedResponse - Response data does not match expected data\n";
        }
    }

    public function testBadRequestResponse()
    {
        $data = ['error' => 'Invalid input'];
        $message = "Bad Request";
        $response = ApiResponse::badRequest($data, $message);

        if (!($response instanceof JsonResponse)) {
            echo "Failed: testBadRequestResponse - Expected instance of JsonResponse\n";
        }

        if ($response->getStatusCode() !== 400) {
            echo "Failed: testBadRequestResponse - Expected status code 400\n";
        }

        $expectedData = [
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ];

        if ($response->getData(true) !== $expectedData) {
            echo "Failed: testBadRequestResponse - Response data does not match expected data\n";
        }
    }

    public function testUnauthorizedResponse()
    {
        $data = ['error' => 'Not authorized'];
        $message = "Unauthorized";
        $response = ApiResponse::unauthorized($data, $message);

        if (!($response instanceof JsonResponse)) {
            echo "Failed: testUnauthorizedResponse - Expected instance of JsonResponse\n";
        }

        if ($response->getStatusCode() !== 401) {
            echo "Failed: testUnauthorizedResponse - Expected status code 401\n";
        }

        $expectedData = [
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ];

        if ($response->getData(true) !== $expectedData) {
            echo "Failed: testUnauthorizedResponse - Response data does not match expected data\n";
        }
    }
}

// Ejecutar las pruebas manualmente
$test = new ApiResponseTest();
$test->runTests();
