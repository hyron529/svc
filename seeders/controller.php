<?php
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $category = json_decode(file_get_contents('php://input'), true);

        switch($category['id']) {
            case 'seeappointment':
                echo json_encode(['page' => '/svc/web/appointment.php']);
                break;
            case 'modifiedemail':
                echo json_encode(['page' => '/svc/web/emailModified.php']);
                break;
            case 'modifiedpassword':
                echo json_encode(['page' => '/svc/web/passwordModified.php']);
                break;
                
        }
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>