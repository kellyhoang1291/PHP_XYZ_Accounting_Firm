<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'model/database_mysqli.php';
require 'model/functions.inc.php';


$clients = get_clients();
$events = get_events();
$notifications = get_notifications();
$employees = get_employees();
$logs = get_logs();


$page = '';


if (isset($_GET['page']) && !empty($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            //logout
            case "logout";
                if (session_destroy()) {
                    unset($_SESSION["username"]);
                    unset($_SESSION["password"]);
                    $page = "";
                }
                break;
            //login
            case "login";
                $username = $_POST['username'];
                $password = $_POST['password'];
                $select = mysqli_query($db_con, "SELECT * FROM employees WHERE employee_email  = '$username' AND employee_status = 'Active'");
                $row = mysqli_fetch_array($select);

                if (is_array($row)) {
                    $msg = '';
                    $password_hash = $row['employee_password'];

                    //compare passwords
                    if (password_verify($password, $password_hash)) {
                        $msg = "login successful";
                        $_SESSION['username'] = $row['employee_email'];
                        $_SESSION['password'] =  $row['employee_password'];
                        header("Location:?page=clients");
                    } else {
                        $msg = "Incorrect password - Login failed!";
                    }
                } else {
                    echo '<script type = "text/javascript">';
                    echo 'alert("Invalid username or password!");';
                    echo '</script>';
                }
                break;
            //create client
            case "client_create";
                $company_name = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_STRING);
                $business_number = filter_input(INPUT_POST, 'business_number', FILTER_SANITIZE_STRING);
                $client_first_name = filter_input(INPUT_POST, 'client_first_name', FILTER_SANITIZE_STRING);
                $client_last_name = filter_input(INPUT_POST, 'client_last_name', FILTER_SANITIZE_STRING);
                $client_phone_number = filter_input(INPUT_POST, 'client_phone_number', FILTER_SANITIZE_STRING);
                $client_cell_number = filter_input(INPUT_POST, 'client_cell_number', FILTER_SANITIZE_STRING);
                $carrier = filter_input(INPUT_POST, 'carrier', FILTER_SANITIZE_STRING);
                $hst_number = filter_input(INPUT_POST, 'hst_number', FILTER_SANITIZE_STRING);
                $website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_STRING);
                $client_status = filter_input(INPUT_POST, 'client_status', FILTER_SANITIZE_STRING);
                create_client($company_name, $business_number, $client_first_name, $client_last_name, $client_phone_number,
                    $client_cell_number, $carrier, $hst_number, $website, $client_status);
                header("Location:?page=clients");
                break;
            //update client
            case "client_update":
                $company_name = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_STRING);
                $business_number = filter_input(INPUT_POST, 'business_number', FILTER_SANITIZE_STRING);
                $client_first_name = filter_input(INPUT_POST, 'client_first_name', FILTER_SANITIZE_STRING);
                $client_last_name = filter_input(INPUT_POST, 'client_last_name', FILTER_SANITIZE_STRING);
                $client_phone_number = filter_input(INPUT_POST, 'client_phone_number', FILTER_SANITIZE_STRING);
                $client_cell_number = filter_input(INPUT_POST, 'client_cell_number', FILTER_SANITIZE_STRING);
                $carrier = filter_input(INPUT_POST, 'carrier', FILTER_SANITIZE_STRING);
                $hst_number = filter_input(INPUT_POST, 'hst_number', FILTER_SANITIZE_STRING);
                $website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_STRING);
                update_client($company_name, $business_number, $client_first_name,$client_last_name,$client_phone_number,
                    $client_cell_number,$carrier,$hst_number,$website);

                header("Location:?page=clients");
                break;
            //update client status
            case "client_status":
                $client_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                $client_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
                if (isset($client_id) && isset($client_status)) {
                    update_client_status($client_id, $client_status);
                }
                $clients = get_clients();
                $events = get_events();
                header("Location:?page=clients");
                break;
            //create event
            case "event_create":
                $client_id = filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
                $notification_id = filter_input(INPUT_POST, 'notification_id', FILTER_SANITIZE_NUMBER_INT);
                $event_time_date = filter_input(INPUT_POST, 'event_time_date', FILTER_SANITIZE_STRING);
                $event_frequency = filter_input(INPUT_POST, 'event_frequency', FILTER_SANITIZE_NUMBER_INT);
                $event_status = filter_input(INPUT_POST, 'event_status', FILTER_SANITIZE_STRING);
                create_event($client_id, $notification_id, $event_time_date, $event_frequency, $event_status);
                header("Location:?page=clients");
                break;
            //update event
            case "event_update":
                $client_id = filter_input(INPUT_POST, 'client_id', FILTER_SANITIZE_NUMBER_INT);
                $notification_id = filter_input(INPUT_POST, 'notification_id', FILTER_SANITIZE_NUMBER_INT);
                $event_time_date = filter_input(INPUT_POST, 'event_time_date', FILTER_SANITIZE_STRING);
                $event_frequency = filter_input(INPUT_POST, 'event_frequency', FILTER_SANITIZE_STRING);
                update_event($client_id, $notification_id, $event_time_date, $event_frequency);
                header("Location:?page=clients");
                break;
            //update event status
            case "event_status":
                $event_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                $event_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
                if (isset($event_id) && isset($event_status)) {
                    update_event_status($event_id, $event_status);
                }
                $clients = get_clients();
                $events = get_events();
                header("Location:?page=clients");
                break;
            //create notification
            case "notification_create":
                $notification_name = filter_input(INPUT_POST, 'notification_name', FILTER_SANITIZE_STRING);
                $notification_type = filter_input(INPUT_POST, 'notification_type', FILTER_SANITIZE_STRING);
                $notification_description = filter_input(INPUT_POST, 'notification_description', FILTER_SANITIZE_STRING);
                $notification_status = filter_input(INPUT_POST, 'notification_status', FILTER_SANITIZE_STRING);
                create_notification($notification_name, $notification_type, $notification_description, $notification_status);
                header("Location:?page=notifications");
                break;
            //create employee
            case "employee_create":
                $employee_first_name = filter_input(INPUT_POST, 'employee_first_name', FILTER_SANITIZE_STRING);
                $employee_last_name = filter_input(INPUT_POST, 'employee_last_name', FILTER_SANITIZE_STRING);
                $employee_email = filter_input(INPUT_POST, 'employee_email', FILTER_SANITIZE_STRING);
                $employee_cell_number = filter_input(INPUT_POST, 'employee_cell_number', FILTER_SANITIZE_STRING);
                $employee_position = filter_input(INPUT_POST, 'employee_position', FILTER_SANITIZE_STRING);
                $employee_password = password_hash(filter_input(INPUT_POST, 'employee_password', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
                $employee_status = filter_input(INPUT_POST, 'employee_status', FILTER_SANITIZE_STRING);
                create_employee($employee_first_name, $employee_last_name, $employee_email, $employee_cell_number, $employee_position, $employee_password, $employee_status);
                header("Location:?page=employees");
                break;
            //update employee
            case "employee_update":
                $employee_first_name = filter_input(INPUT_POST, 'employee_first_name', FILTER_SANITIZE_STRING);
                $employee_last_name = filter_input(INPUT_POST, 'employee_last_name', FILTER_SANITIZE_STRING);
                $employee_email = filter_input(INPUT_POST, 'employee_email', FILTER_SANITIZE_STRING);
                $employee_cell_number = filter_input(INPUT_POST, 'employee_cell_number', FILTER_SANITIZE_STRING);
                $employee_position = filter_input(INPUT_POST, 'employee_position', FILTER_SANITIZE_STRING);
                $employee_password = password_hash(filter_input(INPUT_POST, 'employee_password', FILTER_SANITIZE_STRING), PASSWORD_DEFAULT);
                update_employee($employee_first_name, $employee_last_name, $employee_email,$employee_cell_number,$employee_position,
                    $employee_password);
                header("Location:?page=employees");
                break;
            //update employee status
            case "employee_status":
                $employee_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                $employee_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
                if (isset($employee_id) && isset($employee_status)) {
                    update_employee_status($employee_id, $employee_status);
                }
                $employees = get_employees();
                header("Location:?page=employees");
                break;
            //update notification
            case "notification_update":
                $notification_name = filter_input(INPUT_POST, 'notification_name', FILTER_SANITIZE_STRING);
                $notification_type = filter_input(INPUT_POST, 'notification_type', FILTER_SANITIZE_STRING);
                $notification_description = filter_input(INPUT_POST, 'notification_description', FILTER_SANITIZE_STRING);
                update_notification($notification_name, $notification_type, $notification_description);
                header("Location:?page=notifications");
                break;
            //update notifications status
            case "notification_status":
                $notification_id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                $notification_status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
                if (isset($notification_id) && isset($notification_status)) {
                    update_notification_status($notification_id, $notification_status);
                }
                $notifications = get_notifications();
                header("Location:?page=notifications");
                break;
        }
    }
}

if ($page) {
    switch ($page) {
        case 'login';
            include 'view/login.phtml';
            break;
        case 'clients';
            include 'view/clients.phtml';
            break;
        case 'client_create';
            include 'view/client_create.phtml';
            break;
        case 'client_update';
            include 'view/client_update.phtml';
            break;
        case 'notifications';
            include 'view/notifications.phtml';
            break;
        case 'notification_create';
            include 'view/notification_create.phtml';
            break;
        case 'notification_update';
            include 'view/notification_update.phtml';
            break;
        case 'events';
            include 'view/events.phtml';
            break;
        case 'event_create';
            include 'view/event_create.phtml';
            break;
        case 'event_update';
            include 'view/event_update.phtml';
            break;
        case 'employees';
            include 'view/employees.phtml';
            break;
        case 'employee_create';
            include 'view/employee_create.phtml';
            break;
        case 'employee_update';
            include 'view/employee_update.phtml';
            break;
        case 'logs';
            include 'view/logs.phtml';
            break;
        case 'about_us';
            include 'view/members.phtml';
            break;
        default;
            include 'view/error.phtml';
            break;
    }
} else {
    include 'view/login.phtml';
}

echo "<hr>";
show_source(__FILE__);
