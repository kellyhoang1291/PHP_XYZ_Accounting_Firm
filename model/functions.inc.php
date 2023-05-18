<?php
require('database_mysqli.php');
//RETRIEVE FUNCTIONS
//-----------functions to retrieve list of clients, events, notifications, employees and logs from the database
function get_clients(){
    global $db_con;
    $query = "SELECT * FROM clients";
    $result = mysqli_query($db_con, $query);
    $resultSet = array();
    while ($row = mysqli_fetch_array($result))
    {
        $resultSet[] = $row;
    }
    return $resultSet;
}

function get_events(){
    global $db_con;
    $query = "SELECT event_id, concat(client_first_name, ' ',client_last_name) as client_name, notification_name, event_time_date, event_frequency, event_status
    FROM client_events e JOIN clients c
    ON e.client_id = c.client_id
    JOIN notifications n
    ON e.notification_id = n.notification_id";
    $result = mysqli_query($db_con, $query);
    $resultSet = array();
    while ($row = mysqli_fetch_array($result))
    {
        $resultSet[] = $row;
    }
    return $resultSet;
}

function get_notifications(){
    global $db_con;
    $query = "SELECT * FROM notifications";
    $result = mysqli_query($db_con, $query);
    $resultSet = array();
    while ($row = mysqli_fetch_array($result))
    {
        $resultSet[] = $row;
    }
    return $resultSet;
}

function get_employees(){
    global $db_con;
    $query = "SELECT * FROM employees";
    $result = mysqli_query($db_con, $query);
    $resultSet = array();
    while ($row = mysqli_fetch_array($result))
    {
        $resultSet[] = $row;
    }
    return $resultSet;
}

function get_logs(){
    global $db_con;
    $query = "SELECT * FROM operations_log";
    $result = mysqli_query($db_con, $query);
    $resultSet = array();
    while ($row = mysqli_fetch_array($result))
    {
        $resultSet[] = $row;
    }
    return $resultSet;
}
//CREATE FUNCTIONS
//----------- functions to create client, event, notification, employee, log
//new client
function create_client($company_name, $business_number, $client_first_name,$client_last_name,$client_phone_number,
                               $client_cell_number,$carrier,$hst_number,$website,$client_status) {
    global $db_con;

    $query = "INSERT INTO clients(company_name, business_number, client_first_name, client_last_name, client_phone_number, client_cell_number, carrier, hst_number, website, client_status) 
                        VALUES ('$company_name', '$business_number', '$client_first_name','$client_last_name','$client_phone_number', '$client_cell_number','$carrier','$hst_number','$website','$client_status')";

    if (mysqli_query($db_con, $query)) {
        create_log('client','create');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
}
//add new event
function create_event($client_id, $notification_id, $event_time_date,$event_frequency,$event_status) {
    global $db_con;

    $query = "INSERT INTO client_events(client_id, notification_id, event_time_date, event_frequency, event_status) 
                        VALUES ('$client_id', '$notification_id', '$event_time_date','$event_frequency','$event_status')";

    if (mysqli_query($db_con, $query)) {
        create_log('event','create');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
}

//add new notification
function create_notification($notification_name, $notification_type, $notification_description,$notification_status) {
    global $db_con;

    $query = "INSERT INTO notifications(notification_name, notification_type, notification_description,notification_status) 
                        VALUES ('$notification_name', '$notification_type', '$notification_description','$notification_status')";

    if (mysqli_query($db_con, $query)) {
        create_log('notifcation','create');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
}

//add new employee
function create_employee($employee_first_name,$employee_last_name,$employee_email,$employee_cell_number,$employee_position,$employee_password,$employee_status){
    global $db_con;

    $query = "INSERT INTO employees(employee_first_name, employee_last_name, employee_email, employee_cell_number, employee_position, employee_password, employee_status) 
                        VALUES ('$employee_first_name', '$employee_last_name', '$employee_email','$employee_cell_number','$employee_position', '$employee_password','$employee_status')";
    if (mysqli_query($db_con, $query)) {
        create_log('employee','create');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }

}

//add new log
function create_log($module_name,$action){
    global $db_con;
    $employee = get_employee_id(); 
    $employee_id = $employee['employee_id'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $query = "INSERT INTO operations_log(employee_id, module_name, action, ip) 
                        VALUES ('$employee_id', '$module_name', '$action','$ip')";
    if (mysqli_query($db_con, $query)) {
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }

}
//get employee_id from the login username to create log for the logged in user
function get_employee_id(){
    global $db_con;
    $employee_email = $_SESSION['username'];
    $select = mysqli_query($db_con, "SELECT * FROM employees WHERE employee_email  = '$employee_email' LIMIT 1");
    $row = mysqli_fetch_array($select);
    return $row;
}

//UPDATE FUNCTIONS
//-----------functions to update client, event, notification, employee
function update_client($company_name, $business_number, $client_first_name,$client_last_name,$client_phone_number,
                               $client_cell_number,$carrier,$hst_number,$website) {

    global $db_con;
    $id = $_GET['id'];
    $query = "UPDATE clients SET company_name='$company_name', business_number='$business_number', client_first_name='$client_first_name', 
                    client_last_name='$client_last_name', client_phone_number='$client_phone_number', client_cell_number='$client_cell_number', 
                    carrier='$carrier', hst_number='$hst_number', website='$website' WHERE client_id=$id";
    if (mysqli_query($db_con, $query)) {
        create_log('client','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
    
}

//update client_status
function update_client_status($client_id, $client_status){
    global $db_con;
    $updated_status = ($client_status == "Active")? "Inactive":"Active";
    
    $query = "UPDATE clients SET client_status='$updated_status' WHERE client_id=$client_id";
    if (mysqli_query($db_con, $query)) {
        // call the event status update for this client
        update_client_event_status($client_id,$updated_status);
        create_log('client status','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
    
} 

//update event status for a specific clients
function update_client_event_status($client_id,$updated_status){
    global $db_con;
    $query = "UPDATE client_events SET event_status='$updated_status' WHERE client_id=$client_id";
    if (mysqli_query($db_con, $query)) {
        create_log('event status','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
   
}

//update event
function update_event($client_id, $notification_id, $event_time_date,$event_frequency) {

    global $db_con;
    $id = $_GET['id'];
    $query = "UPDATE client_events SET client_id=$client_id, notification_id=$notification_id, event_time_date='$event_time_date', 
                    event_frequency='$event_frequency' WHERE event_id=$id";
    if (mysqli_query($db_con, $query)) {
        create_log('event','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
}

//update event status based on event id
function update_event_status($event_id,$event_status){
    global $db_con;
    $updated_status = ($event_status == "Active")? "Inactive":"Active";
    $query = "UPDATE client_events SET event_status='$updated_status' WHERE event_id=$event_id";
    if (mysqli_query($db_con, $query)) {
        create_log('event status','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
   
}

//update employee
function update_employee($employee_first_name, $employee_last_name, $employee_email,$employee_cell_number,$employee_position,
$employee_password) {

    global $db_con;
    $id = $_GET['id'];
    $query = "UPDATE employees SET employee_first_name='$employee_first_name', employee_last_name='$employee_last_name', employee_email='$employee_email', 
                    employee_cell_number=$employee_cell_number, employee_position='$employee_position', employee_password='$employee_password'
                    WHERE employee_id=$id";
    if (mysqli_query($db_con, $query)) {
        create_log('employee','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
}
//update employee status
function update_employee_status($employee_id,$employee_status){
    global $db_con;
    $updated_status = ($employee_status == "Active")? "Inactive":"Active";
    $query = "UPDATE employees SET employee_status='$updated_status' WHERE employee_id=$employee_id";
    if (mysqli_query($db_con, $query)) {
        create_log('employee status','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
   
}
//update notifcation
function update_notification($notification_name, $notification_type, $notification_description) {

    global $db_con;
    $id = $_GET['id'];
    $query = "UPDATE notifications SET notification_name='$notification_name', notification_type='$notification_type', notification_description='$notification_description' WHERE notification_id=$id";
    if (mysqli_query($db_con, $query)) {
        create_log('notifcation','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
}
//update notification status
function update_notification_status($notification_id,$notification_status){
    global $db_con;
    $updated_status = ($notification_status == "Enabled")? "Disabled":"Enabled";
    $query = "UPDATE notifications SET notification_status='$updated_status' WHERE notification_id=$notification_id";
    if (mysqli_query($db_con, $query)) {
        create_log('notification status','update');
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db_con);
    }
   
}

// please refer to the source file uploaded in gblearn
// echo "<hr>";
// show_source(__FILE__);
