<?php
/*
 * DataTables example server-side processing script.
 * require ('Model/Autoloader.php');require 'Model/Estatevalue.php';
 * Model\Autoloader::register();use Model\Estatevalue;
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See https://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - https://datatables.net/license_mit
 */
$table = "(SELECT task_id, title, todo, due_date, created_at, isChecked, isArchived, userid, isCheckedByAdmin, file, u.fullname, d.color, d.libelle, d.department_id FROM task INNER JOIN user u on u.user_id = task.userid INNER JOIN department d on d.department_id = u.department FROM task) tbl";
$primaryKey = 'task_id';

$columns = array(
    array( 'db' => 'task_id', 'dt' => null ),
    array( 'db' => 'task_id', 'dt' => 1 ),
    array( 'db' => 'valueID', 'dt' => 2 ),
);

// SQL server connection information
$sql_details = array(
    'user' => 'root',
    'pass' => '0000000000',//0000000000
    'db'   => 'task_db',
    'host' => '127.0.0.1:3306',
    'charset' => 'utf8'
);

require_once '../../public/assets/datatables/examples/server_side/scripts/ssp.class.php';
//$data = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns);
//echo json_encode( $data);
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);