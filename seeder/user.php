<?php

require_once("../connection.php");

$stmt = $pdo->prepare("INSERT INTO `users` (role, firstName, lastName, email, phone, profile_image, password)
    VALUES (:role, :firstName, :lastName, :email, :phone, :profile_image, :password)");

$users = [
    ['admin', 'admin', 'admin', 'admin@admin.admin', '0000000000', file_get_contents("../default_profile/default.png"), password_hash('admin', PASSWORD_DEFAULT)],
    ['sell', 'Peter', 'Griffin', 'peter.griffin@example.com', '123-456-7890', file_get_contents("../default_profile/default.png"), password_hash('Joshua1234', PASSWORD_DEFAULT)],
    ['sell', 'Lois', 'Griffin', 'lois.griffin@example.com', '234-567-8901', file_get_contents("../default_profile/default.png"), password_hash('Joshua1234', PASSWORD_DEFAULT)],
    ['sell', 'Stewie', 'Griffin', 'stewie.griffin@example.com', '345-678-9012', file_get_contents("../default_profile/default.png"), password_hash('Joshua1234', PASSWORD_DEFAULT)],
    ['sell', 'Brian', 'Griffin', 'brian.griffin@example.com', '456-789-0123', file_get_contents("../default_profile/default.png"), password_hash('Joshua1234', PASSWORD_DEFAULT)],
    ['buy', 'Meg', 'Griffin', 'meg.griffin@example.com', '567-890-1234', file_get_contents("../default_profile/default.png"), password_hash('Joshua1234', PASSWORD_DEFAULT)],
    ['buy', 'John', 'Doe', 'john.doe@example.com', '678-901-2345', file_get_contents("../default_profile/default.png"), password_hash('SecurePass1', PASSWORD_DEFAULT)],
    ['buy', 'Jane', 'Doe', 'jane.doe@example.com', '789-012-3456', file_get_contents("../default_profile/default.png"), password_hash('SecurePass2', PASSWORD_DEFAULT)],
    ['buy', 'Alice', 'Johnson', 'alice.johnson@example.com', '890-123-4567', file_get_contents("../default_profile/default.png"), password_hash('SecurePass3', PASSWORD_DEFAULT)],
    ['sell', 'Bob', 'Smith', 'bob.smith@example.com', '901-234-5678', file_get_contents("../default_profile/default.png"), password_hash('SecurePass4', PASSWORD_DEFAULT)],
    ['buy', 'Charlie', 'Brown', 'charlie.brown@example.com', '012-345-6789', file_get_contents("../default_profile/default.png"), password_hash('SecurePass5', PASSWORD_DEFAULT)],
    ['sell', 'David', 'Clark', 'david.clark@example.com', '123-456-7891', file_get_contents("../default_profile/default.png"), password_hash('SecurePass6', PASSWORD_DEFAULT)],
    ['buy', 'Emma', 'Wilson', 'emma.wilson@example.com', '234-567-8902', file_get_contents("../default_profile/default.png"), password_hash('SecurePass7', PASSWORD_DEFAULT)],
    ['sell', 'Frank', 'Miller', 'frank.miller@example.com', '345-678-9013', file_get_contents("../default_profile/default.png"), password_hash('SecurePass8', PASSWORD_DEFAULT)],
    ['buy', 'Grace', 'Lee', 'grace.lee@example.com', '456-789-0124', file_get_contents("../default_profile/default.png"), password_hash('SecurePass9', PASSWORD_DEFAULT)],
    ['buy', 'Hannah', 'Martin', 'hannah.martin@example.com', '567-890-1235', file_get_contents("../default_profile/default.png"), password_hash('SecurePass10', PASSWORD_DEFAULT)],
    ['sell', 'Isaac', 'Newton', 'isaac.newton@example.com', '678-901-2346', file_get_contents("../default_profile/default.png"), password_hash('SecurePass11', PASSWORD_DEFAULT)],
    ['buy', 'Jack', 'Taylor', 'jack.taylor@example.com', '789-012-3457', file_get_contents("../default_profile/default.png"), password_hash('SecurePass12', PASSWORD_DEFAULT)],
    ['buy', 'Karen', 'Walker', 'karen.walker@example.com', '890-123-4568', file_get_contents("../default_profile/default.png"), password_hash('SecurePass13', PASSWORD_DEFAULT)],
    ['buy', 'Liam', 'Scott', 'liam.scott@example.com', '901-234-5679', file_get_contents("../default_profile/default.png"), password_hash('SecurePass14', PASSWORD_DEFAULT)],
    ['sell', 'Mia', 'Evans', 'mia.evans@example.com', '012-345-6790', file_get_contents("../default_profile/default.png"), password_hash('SecurePass15', PASSWORD_DEFAULT)],
    ['buy', 'Noah', 'Harris', 'noah.harris@example.com', '123-456-7892', file_get_contents("../default_profile/default.png"), password_hash('SecurePass16', PASSWORD_DEFAULT)],
    ['sell', 'Olivia', 'Clark', 'olivia.clark@example.com', '234-567-8903', file_get_contents("../default_profile/default.png"), password_hash('SecurePass17', PASSWORD_DEFAULT)],
    ['buy', 'Walter', 'White', 'walter.white@example.com', '345-678-9014', file_get_contents("../default_profile/default.png"), password_hash('SecurePass18', PASSWORD_DEFAULT)],
    ['sell', 'Quinn', 'Green', 'quinn.green@example.com', '456-789-0125', file_get_contents("../default_profile/default.png"), password_hash('SecurePass19', PASSWORD_DEFAULT)],
    ['buy', 'Ryan', 'King', 'ryan.king@example.com', '567-890-1236', file_get_contents("../default_profile/default.png"), password_hash('SecurePass20', PASSWORD_DEFAULT)],
    ['admin', 'Joshua', 'Kool', '177300@student.horizoncollege.nl', '0633869930', file_get_contents("../default_profile/default.png"), password_hash('Joshua1234', PASSWORD_DEFAULT)]
];


foreach ($users as $user) {
    $stmt->bindParam(':role', $user[0]);
    $stmt->bindParam(':firstName', $user[1]);
    $stmt->bindParam(':lastName', $user[2]);
    $stmt->bindParam(':email', $user[3]);
    $stmt->bindParam(':phone', $user[4]);
    $stmt->bindParam(':profile_image', $user[5]);
    $stmt->bindParam(':password', $user[6]);
    
    $stmt->execute();
}
?>