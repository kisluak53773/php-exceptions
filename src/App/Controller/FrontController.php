<?php

declare(strict_types=1);

namespace App\Controller;

use Exception;

class FrontController
{
    public function home(): void
    {
        try {
            $result = "data";
            $response = ['success' => true, 'result' => $result];
        } catch (Exception $e) {
            $response = ['error' => true, 'message' => 'Ошибка: ' . $e->getMessage()];
            http_response_code(500);
        }

        echo json_encode($response);
    }
}