<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: X-Requested-With');
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../data/product.php";

$request = $_SERVER['REQUEST_METHOD'];

$db = new Database();
$conn = $db->connection();

$product = new Product($conn);
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

$product->get();

$response = [];

if ($request == 'GET') {
    if ($product->id != null) {
        $data = array(
            'id' => $product->id,
            'judul_buku' => $product->judul_buku,
            'pengarang' => $product->pengarang,'
            'sinopsis' => $product->sinopsis,
        );
        $response = array(
            'status' =>  array(
                'messsage' => 'Success', 'code' => (http_response_code(200))
            ), 'data' => $data
        );
    } else {
        http_response_code(404);
        $response = array(
            'status' =>  array(
                'messsage' => 'No Data Found', 'code' => http_response_code()
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
