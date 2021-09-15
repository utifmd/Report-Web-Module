<?php 
$mysqli = new mysqli("localhosst", "root", "", "rsia", 3306);
// $mysqli = mysqli_connect("mysql", "root", "9809poiiop", "sik", 3306);

$query_main = $mysqli->query("SELECT * FROM poliklinik");

// $query_main = mysqli_query($mysqli, "SELECT * FROM poliklinik");

// $stmt_poli = mysqli_prepare($mysqli, "SELECT * FROM poliklinik WHERE kd_poli=?");

// $param_tgl = "2020-10-05";
// $param_poli = "OBG";
// $param_tb = "poliklinik";

// mysqli_stmt_bind_param($stmt_poli, "s", $param_poli);
// mysqli_stmt_execute($stmt_poli);

if(mysqli_connect_errno()){
    echo "error connection"; //$this->onComplete(null, mysqli_connect_error());
    exit();
} else if(!$query_main) // || !$query_poli)
    echo "error in query"; // $this->on  Complete(null, $mysqli->error);

// $result = mysqli_stmt_get_result($stmt_poli); // $stmt_poli->get_result();

// while($row = mysqli_fetch_array($result)){
//     foreach($row as $r){
//         print "$r ";
//     }
// }

$var_date_length = 31;

function funIterateValues($length, $kd_poli, $year_month) {
    $mysqli = new mysqli("mysql", "root", "9809poiiop", "sik", 3306);
    /* $year = explode("-", $date)[0]; $month = explode("-", $date)[1]; $day = explode("-", $date)[2];
    EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '".$year."' AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '".$month."' AND EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '".$day."' */
    $total = 0;

    for($i = 0; $i < $length; $i++){
        $query_poli = $mysqli->query("
            SELECT
            reg_periksa.tgl_registrasi,
            COUNT(poliklinik.nm_poli) AS reg_poli_count
            FROM poliklinik 
            INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli

            WHERE reg_periksa.tgl_registrasi = '".$year_month."-".($i+1)."'
            AND reg_periksa.kd_poli = '".$kd_poli."'

            GROUP BY reg_periksa.tgl_registrasi
        ");
        $reg_poli_count = $query_poli->fetch_assoc()['reg_poli_count'];
        if($reg_poli_count > 0){
            $total = $total + $reg_poli_count;
            echo "<td class=\"mdc-data-table__cell mdc-data-table__cell--numeric border\" style=\"padding:5px\"><center>".$reg_poli_count."</center></td>";
        }else
            echo "<td class=\"mdc-data-table__cell mdc-data-table__cell--numeric\" style=\"padding:5px\"><center>-</center></td>";
    }
    echo "<td class=\"mdc-data-table__cell mdc-data-table__cell--numeric\"><b>".$total."</b></td>";
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSIA Fadhila</title>
    
    <!-- Dependencies -->
    <link rel="stylesheet" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="./theme/material-style.css">
    <link rel="stylesheet" href="./theme/custom-style.css">
</head>
<body>
    <input class="month" type="month" value="2021-08">
    <div class="mdc-data-table mdc-data-table--sticky-header">
        <div class="mdc-data-table__table-container">
            <table class="mdc-data-table__table" aria-label="Dessert calories">
                <thead>
                <tr class="mdc-data-table__header-row">
                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col"><b>No</b></th>
                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col"><b>Poliklinik</b></th>
                    <?php for ($i=0; $i < $var_date_length; $i++) echo
                        "<th class=\"mdc-data-table__header-cell mdc-data-table__header-cell--numeric\" role=\"columnheader\" scope=\"col\" style=\"padding:5px\">
                            <b>".str_pad(($i+1), 2, "0", STR_PAD_LEFT)."</b>
                        </th>"; ?>
                    <th class="mdc-data-table__header-cell" role="columnheader" scope="col"><b>Total</b></th>
                </tr>
            </thead>

            <?php $num = 0;
            while($row = $query_main->fetch_assoc()){ $num++;
                echo "
                <tbody class=\"mdc-data-table__content\">
                    <tr class=\"mdc-data-table__row ".($num % 2 == 0 ? 'zebra' : null )."\">
                        <th class=\"mdc-data-table__cell\" scope=\"row\">".$num."</th>
                        <td class=\"mdc-data-table__cell\">".$row['nm_poli']."</td>";
                echo funIterateValues($var_date_length, $row['kd_poli'], "2020-10")."
                    </tr>
                </tbody>";
            }
            ?>
            </table>
        </div>
    </div>

    <!-- dependency -->
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
</body>
</html>