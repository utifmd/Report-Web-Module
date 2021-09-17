<?php
    require_once("./config/database.php");

    $query = $mysqli->query("SELECT * FROM poliklinik WHERE `status` = '1' 
        AND `nm_poli` != 'ORTHOPEDI' 
        AND `nm_poli` != 'Paru' 
        AND `nm_poli` NOT LIKE '%logi%' 
        AND `nm_poli` NOT LIKE '%kamar%' ORDER BY `nm_poli` DESC");
    $query_institute = $mysqli->query("SELECT * FROM penjab");

    if(mysqli_connect_errno()) exit();
    else if(!$query) throw new Exception("Error Querying Request", 1); // else if(!$query_institute) throw new Exception("Error Querying Request", 1);
    
    if(isset($_GET['year']))
        $current_year = $_GET['year'];
    else 
        $current_year = date('Y');

    if(isset($_GET['month'])){
        $current_month = $list_month[intval($_GET['month'])];
        $current_month_pos = $_GET['month'] ?: date('m'); 
    }else{
        $current_month = $list_month[0];// date('F');
        $current_month_pos = 0; // date('m'); 
    }
    
    if(isset($_GET['institute']) || isset($_GET['institute_code'])){
        $current_institute = $_GET['institute'];
        $current_institute_code = $_GET['institute_code'];
    }else{
        $current_institute = null;
        $current_institute_code = null;
    } /*$current_year = $_GET['year'] ?: date('Y'); $current_month = $_GET['month'] ? $list_month[intval($_GET['month'])] : date('F'); $current_month_pos = $_GET['month'] ?: date('m'); */
    
    if(isset($_POST['sign-in'])) funSignIn();
    else if(isset($_POST['sign_out'])) funSignOut(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $app_name; ?></title>
    <?php include_once("./components/dependency/link.php"); ?>
</head>
<body> <?php 
include_once("./components/header.php");
include_once("./components/section/tool-bar.php");

if(isset($_SESSION['isSignedIn'])) { ?>
    <div> <!--table-responsive-->
        <table id="table" class="table table-borderless table-hover">
            <thead class="table-light sticky-top">
                <tr style="vertical-align:middle;text-align:center;">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Poliklinik</th>
                    <th scope="col" colspan="<?php echo $var_date_length?>">Tanggal</th>
                    <th rowspan="2">Total</th>
                </tr>
                <tr>
                    <?php for($i = 0; $i < $var_date_length; $i++) echo "
                    <th scope=\"col\" style=\"padding-left:2.5px;padding-right:2.5px\">".str_pad(($i+1), 2, "0", STR_PAD_LEFT)."</th>" ?>
                </tr>
            </thead>
            <?php $num = 0; while($row = $query->fetch_assoc()){ $num++;
                $param_date = $current_year."-".$current_month_pos; echo "
            <tbody> 
                <tr>
                    <th scope=\"col\">".$num."</th>
                    <td scope=\"col\" style=\"white-space: nowrap\">".$row['nm_poli']."</td>";
                    echo funIterateValues($row['kd_poli'], $current_institute_code, $current_year, $current_month_pos)."
                </tr>
            </tbody>"; 
            } ?>
            <tbody class="table bg-light">
                <tr>
                    <th scope="col" colspan="2">Total keseluruhan</th>
                    <td scope="col" colspan="<?php echo $var_date_length?>"></td>
                    <th scope="col"><?php echo $total_summary?></th>
                </tr>
            </tbody>
        </table>
    </div>
<?php }
    include_once("./components/footer.php");
    include_once("./components/index/login-modal.php");
    include_once("./components/dependency/script.php"); ?>
</body>
</html>
<?php

function funSignIn(){
    $content = array("admin", "fadhila", "fadhli", "fitri");
    
    $username = $_POST['input_text_username'];
    $password = $_POST['input_text_password'];

    if((4 <= strlen($password)) && (strlen($password) <= 20)){
        if(in_array($username, $content) && $password == "admin"){
            
            $_SESSION['isSignedIn'] = "true";
            header("Location: ./");
        }else header("Location: ?invalid_code=101");
    }else header("Location: ?invalid_code=102");
}

function funSignOut(){
    unset($_SESSION['isSignedIn']);
}

function queryReqPoliCount($kd_poli, $kd_pj, $day, $month, $year){
    global $mysqli;

    if(isset($kd_pj)){
        return $mysqli->query("SELECT
            reg_periksa.tgl_registrasi,
            COUNT(poliklinik.nm_poli) AS reg_poli_count
            FROM poliklinik 
            INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli
            WHERE EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '".$year."'
            AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '".$month."'
            AND EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '".$day."'
            AND reg_periksa.kd_poli = '".$kd_poli."'
            AND reg_periksa.kd_pj = '".$kd_pj."'
            GROUP BY reg_periksa.tgl_registrasi");
    } else {
        return $mysqli->query("SELECT
            reg_periksa.tgl_registrasi,
            COUNT(poliklinik.nm_poli) AS reg_poli_count
            FROM poliklinik 
            INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli
            WHERE EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '".$year."'
            AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '".$month."'
            AND EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '".$day."'
            AND reg_periksa.kd_poli = '".$kd_poli."'
            GROUP BY reg_periksa.tgl_registrasi");   
    }
}
/* * *
    iterate horizontal queries
* */
function funIterateValues($kd_poli, $kd_pj, $year, $month) {
    global $mysqli, $var_date_length, $total_summary;

    $total = 0; for($i = 0; $i < $var_date_length; $i++){ $day = ($i+1);
        $reg_poli_count = queryReqPoliCount($kd_poli, $kd_pj, $day, $month, $year)->fetch_assoc()['reg_poli_count'];
        
        if($reg_poli_count > 0){
            $total = $total + $reg_poli_count;
            echo "<th scope=\"col\" style=\"padding-left:2.5px;padding-right:2.5px\">".str_pad($reg_poli_count, 2, "0", STR_PAD_LEFT)."</th>";
        }else
            echo "<td scope=\"col\" style=\"padding-left:2.5px;padding-right:2.5px\">00</td>";
    }
    echo "<td scope=\"row\">".$total."</td>";
    $total_summary = $total_summary + $total;
} 

function mergeQueryStr($url = null, $query = null, $recursive = false) { // $url = 'http://www.google.com.au?q=apple&type=keyword'; // $query = '?q=banana'; // if there's a URL missing or no query string, return
    if($url == null) return false;
    if($query == null) return $url; // split the url into it's components

    $url_components = parse_url($url); // if we have the query string but no query on the original url // just return the URL + query string
    if(empty($url_components['query']))
        return $url.'?'.ltrim($query, '?'); // turn the url's query string into an array

    parse_str($url_components['query'], $original_query_string); // turn the query string into an array
    parse_str(parse_url($query, PHP_URL_QUERY), $merged_query_string); // merge the query string

    if($recursive == true)
        $merged_result = array_merge_recursive($original_query_string, $merged_query_string);
    else
        $merged_result = array_merge($original_query_string, $merged_query_string); // Find the original query string in the URL and replace it with the new one

    return str_replace($url_components['query'], http_build_query($merged_result), $url); } ?>