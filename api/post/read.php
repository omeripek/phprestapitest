<?php
// Headers
header('Access-Controll-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Post
$post = new Post($db);

// Post query
$result = $post->read();

// Get row count
$num = $result->rowCount();

// Check exist post
if($num > 0) {
    $post_arr = [];
    $post_arr['data'] = [];

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = [
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        ];

        // Push to 'data'
        array_push($post_arr['data'], $post_item);
    }

    echo json_encode($post_arr);

} else {
    echo json_encode(
        [
            'message' => 'No Posts Found'
        ]
    );
}