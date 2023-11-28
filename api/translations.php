<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/TranslationUnit.php';

const DB_HOST = 'localhost:3306';
const DB_NAME = 'denyudin_robert_cat';
const DB_USERNAME = 'root';
const DB_PASSWORD = 'root';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];
$uri = trim($_SERVER['REQUEST_URI'], '/api/translations.php');

@[$id] = explode('/', $uri);
$id = !empty($id) ? (int) $id : null;

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);

$translationUnitModel = new TranslationUnit($pdo);
$historyTranslationUnitModel = new HistoryTranslationUnits($pdo);
$controller = new TranslationsController($translationUnitModel, $historyTranslationUnitModel);

header('Content-Type: application/json');
switch ($method) {
    case 'GET':
        if ($id !== null) {
            echo $controller->handleGetById($id);
        } else {
            echo $controller->handleGetAll();
        }
        break;
    case 'POST':
        echo $controller->handlePost();
        break;
    case 'PUT':
        echo $controller->handlePut($id);
        break;
    default:
        http_response_code(405);
        echo 'Method Not Allowed';
}
