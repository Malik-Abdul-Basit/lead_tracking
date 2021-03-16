<?php

include_once('../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $email = $object->email;
    $password = $object->password;

    if (empty($email)) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'Email field is required.']);
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'Invalid Email Address.']);
    } else if (strpos($email, '*') !== false) {
        echo json_encode(["code" => 422, "errorMessageEmail" => 'special characters not allowed.']);
    } else if (empty($password)) {
        echo json_encode(["code" => 422, "errorMessagePassword" => 'Password field is required.']);
    } else {
        $password = md5($password);
        $select = "
            SELECT u.id AS user_id, u.email AS user_email, u.email_verified_at, u.status, u.deleted_at AS user_delete,
            u.company_id, co.deleted_at AS company_delete, co.status AS company_status,
            u.branch_id, b.deleted_at AS branch_delete, b.status AS branch_status
            FROM
                users AS u
            INNER JOIN 
                branches AS b
                ON u.branch_id = b.id
            INNER JOIN 
                companies AS co
                ON u.company_id = co.id
            WHERE u.email='{$email}' AND u.password='{$password}'";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            if ($result = mysqli_fetch_object($query)) {
                if (!empty($result->company_delete)) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your company has been deleted.']);
                } else if ($result->company_status != config("companies.status.value.working")) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your company has been closed.']);
                } else if (!empty($result->branch_delete)) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your branch has been deleted.']);
                } else if ($result->branch_status != config("branches.status.value.working")) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your branch has been closed.']);
                } else if (!empty($result->user_delete)) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your account has been deleted.']);
                } else if ($result->status == config("users.status.value.pending")) {
                    echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your account is under approval.']);
                } else {
                    if ($result->status == config("users.status.value.activated")) {

                        $_SESSION['company_id'] = $result->company_id;
                        $_SESSION['branch_id'] = $result->branch_id;
                        $_SESSION['employee_id'] = $result->user_id;

                        if (empty($result->email_verified_at)) {
                            $select = "SELECT `id`, `signed_url` FROM `email_verification_details` WHERE `user_id`='{$result->user_id}' AND `deleted_at` IS NULL";
                            $query = mysqli_query($db, $select);
                            if (mysqli_num_rows($query) == 0) {
                                $verification_code = generatePassword(12, true, false);
                                $signed_url = generatePassword(56, true, false);
                                $insert = "INSERT INTO `email_verification_details`(`id`, `user_id`, `verification_code`, `signed_url`) VALUES (NULL, '{$result->user_id}', '{$verification_code}', '{$signed_url}')";
                                mysqli_query($db, $insert);
                            }
                            sendEmailVerificationEmail($result->user_id);
                            echo json_encode(["code" => 200, "page" => 'email_confirmation']);
                        } else {
                            $_SESSION['user_id'] = $result->user_id;
                            echo json_encode(["code" => 200, "page" => 'admin/dashboard']);
                        }
                    } else {
                        echo json_encode(["code" => 405, "accessDeniedMessage" => 'Your account is ' . strtolower(config("users.status.title." . $result->status)) . '.']);
                    }
                }
            }
        } else {
            echo json_encode(["code" => 405, "accessDeniedMessage" => 'The email or password is incorrect.']);
        }
    }
}
?>