<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../data/product.php";

$request = $_SERVER['REQUEST_METHOD'];

$db = new Database();
$conn = $db->connection();

$product = new Product($conn);

$data = json_decode(file_get_contents("php://input"));

$response = [];

if ($request == 'POST') {
    if (
        !empty($data->id) &&
        !empty($data->judul_buku) &&
        !empty($data->pengarang) &&
        !empty($data->sinopsis)
    ) {
        $product->id = $data->id;
        $product->judul_buku = $data->judul_buku;
        $product->pengarang = $data->pengarang;
        $product->sinopsis = $data->sinopsis;

        $data = array(
            'id' => $product->id,
            'judul_buku' => $product->judul_buku,
            'pengarang' => $product->pengarang,
            'sinopsis' => $product->sinopsis,
        );

        if ($product->add()) {
            $response = array(
                'status' =>  array(
                    'messsage' => 'Success', 'code' => (http_response_code(200))
                ), 'data' => $data
            );
        } else {
            http_response_code(400);
            $response = array(
                'messsage' => 'Add Failed',
                'code' => http_response_code()
            );
        }
    } else {
        http_response_code(400);
        $response = array(
            'status' =>  array(
                'messsage' => 'Add Failed - Wrong Parameter', 'code' => http_response_code()
            )
        );
    }
} else {
    http_response_code(405);
    $response = array(
        'status' =>  array(
            'messsage' => 'Method Not Allowed', 'code' => http_response_code()
        )
    );
}

echo json_encode($response);
