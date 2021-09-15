<?php
    session_start();

    $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $mysqli = new Mysqli("localhost", "root", "", "rsia", 3306); //$mysqli = new Mysqli("192.168.1.54", "online", 123456, "fadhila", 3306); 
    $list_month = array("Pilih Bulan", "Januari", "Februari", "Maret", "April", "Mai", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"); // date('F', mktime(0, 0 ,0 , $i, 1, date('Y')));
    $list_institute = array("Pilih Institusi", "BPJS", "UMUM");
    $app_name = "RSIA Fadhila Batusangkar";
    $var_date_length = 31;
    $total_summary = 0;
    
    echo $url;

    $query = $mysqli->query("SELECT * FROM poliklinik WHERE `status` = '1' 
        AND `nm_poli` != 'ORTHOPEDI' 
        AND `nm_poli` != 'Paru' 
        AND `nm_poli` NOT LIKE '%logi%' 
        AND `nm_poli` NOT LIKE '%kamar%' ORDER BY `nm_poli` DESC");
    $query_institute = $mysqli->query("SELECT * FROM penjab");

    if(mysqli_connect_errno()) exit();
    else if(!$query) throw new Exception("Error Querying Request", 1);
    // else if(!$query_institute) throw new Exception("Error Querying Request", 1);
    
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
    }
    
    /*$current_year = $_GET['year'] ?: date('Y');
    $current_month = $_GET['month'] ? $list_month[intval($_GET['month'])] : date('F');
    $current_month_pos = $_GET['month'] ?: date('m'); */
    
    if(isset($_POST['sign-in'])) funSignIn();
    else if(isset($_POST['sign_out'])) funSignOut(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $app_name; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css"/>
    <link rel="stylesheet" href="./theme/custom-style.css">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button
            class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarRightAlignExample"
            aria-controls="navbarRightAlignExample" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarRightAlignExample">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"> 
                <a class="nav-link" href="./" tabindex="-1">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" aria-current="page" data-mdb-toggle="modal"
                    data-mdb-target="#staticBackdrop" style="cursor:pointer">
                <?php if(isset($_SESSION['isSignedIn'])) echo "Sign Out";
                    else echo "Sign In"; ?>
                </a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
    
    <div class="p-5 text-center">
        <h1 class="mb-3"><?php echo $app_name; ?></h1>
        <h4 class="mb-3">Aplikasi Laporan Registrasi Poliklinik</h4>
    </div>
<?php if(!isset($_SESSION['isSignedIn'])) { ?>
    <div class="container">
        <div class="alert alert-warning mb-5" role="alert"> <?php switch (isset($_GET['invalid_code'])) {
            case 101: echo 'Kombinasi password dan username anda salah, pastikan anda menggunakan akun yang benar /valid.'; break;
            case 102: echo 'Panjang karakter username atau password harus 8-20'; break;
            default: echo 'Silahkan lakukan login dengan akun yang valid pada menu "Sign In" yang terdapat pada menu bar diatas.'; break; } ?>
        </div>
    </div>
<?php } ?>
    <div class="container">
        <div class="btn-group mb-5" role="group" aria-label="Button group with nested dropdown">
            <div class="form-outline">
                <input type="number" id="yearNumber" class="form-control" min="1800"
                    max="<?php echo date('Y') ?>" value="<?php echo $current_year ?>"/>
                <label class="form-label" for="yearNumber">Year</label>
            </div>
            <div class="btn-group" role="group">
                <button id="monthNumber" type="button" class="btn btn-primary dropdown-toggle <?php echo !isset($_SESSION['isSignedIn']) ? "disabled" : ""?>"
                    data-mdb-toggle="dropdown" aria-expanded="false">
                    <?php echo $current_month ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="z-index:1070;">
                <?php for($i = 1; $i < count($list_month); $i++){
                    $selected_month = $list_month[$i]; echo 
                    "<li onclick=\"funApply('".$selected_month."', '".$i."')\"><a class=\"dropdown-item\" style=\"cursor:pointer;\">".$selected_month."</a></li>"; } ?>
                </ul>
            </div>
            <div class="btn-group" role="group">
                <button id="instituteKey" type="button" class="btn btn-primary dropdown-toggle <?php echo !isset($_SESSION['isSignedIn']) ? "disabled" : ""?>"
                    data-mdb-toggle="dropdown" aria-expanded="false">
                    <?php echo isset($current_institute) ? $current_institute : $list_institute[0]; ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="z-index:1070;">
                <?php while($resource = $query_institute->fetch_assoc()){
                    /*$selected_institute = $list_institute[$i];*/ echo 
                    "<li><a href=\"".mergeQueryStr($url, "?institute=".$resource['png_jawab']."&institute_code=".$resource['kd_pj']."")."\" class=\"dropdown-item\" style=\"cursor:pointer;\">".$resource['png_jawab']."</a></li>"; } ?>
                </ul>
            </div>
        </div>
    </div>
    <?php if(isset($_SESSION['isSignedIn'])) { ?>
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
    <?php } ?>

    <section class="footer">
    <footer class="text-center text-white" style="background-color: #0a4275;">
        <div class="container p-4 pb-0">
        <section class="">
            <form action="mailto:utifmd@gmail.com">
                <p class="d-flex justify-content-center align-items-center">
                    <span class="me-3">Contact Us</span>
                    <input class="btn btn-outline-light btn-rounded" type="submit" value="Email" />
                </p>
            </form>
        </section>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            &copy; <?php echo Date("Y"); ?> Copyright
            <a class="text-white" href="http://rsiafadhila.id/">RSIA Fadhila IT/Programmer</a> <!--https://utifmd.github.io/portfolio/-->
        </div>
    </footer>
    <div id="staticBackdrop" class="modal fade" data-mdb-backdrop="static"
        data-mdb-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="login-form" method="post">
        <?php if(!isset($_SESSION['isSignedIn'])) { ?>
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Sign In</h5>
            <button type="button" class="btn-close"
                data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="form-outline">
            <input id="username" type="text" name="input_text_username" class="form-control" aria-describedby="username-error" required minlength="4" maxlength="20"/>
            <label class="form-label" for="username">Username</label>
        </div>
            <div class="col-auto m-2"></div>
        <div class="form-outline col-auto">
            <input id="password" type="password" name="input_text_password" class="form-control" aria-describedby="password-error" required minlength="4" maxlength="20"/>
            <label class="form-label" for="password">Password</label>
        </div>
            <div class="col-auto m-2">
                <span id="message-error" class="form-text">Must be 8-20 characters long.</span>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-mdb-dismiss="modal">
                Close
            </button>
            <button id="sign-in" type="submit" class="btn btn-primary" name="sign-in">Login</button>
        </div>
        <?php } else {  ?>
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Sign Out</h5>
            <button type="button" class="btn-close"
                data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-mdb-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger" name="sign_out">Logout</button>
        </div>
        <?php }; ?>
        </form>
    </div>
    </div>
    </div>
    </section>
    
    <!-- JavaScript -->
    <script type="text/javascript">
        funApply = (month, pos) => {
            let year = document.getElementById('yearNumber').value 
            document.getElementById('monthNumber').innerHTML = `${month}` // alert(`${year} ${month}`);
            
            window.location.href = `?month=${pos}&year=${year}`
        }
        
        const table = document.getElementById('table')

    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
</body>
</html>
<?php

function funSignIn(){
    $content = array("admin", "fadhila", "fadhli", "fitri");
    
    $username = $_POST['input_text_username'];
    $password = $_POST['input_text_password'];

    if((4 <= strlen($password)) && (strlen($password) <= 20)){
        if(in_array($username, $content) && $password === "admin"){
            
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

    return isset($kd_pj) 
    ? $mysqli->query("SELECT
        reg_periksa.tgl_registrasi,
        COUNT(poliklinik.nm_poli) AS reg_poli_count
        FROM poliklinik 
        INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli
        WHERE EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '".$year."'
        AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '".$month."'
        AND EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '".$day."'
        AND reg_periksa.kd_poli = '".$kd_poli."'
        AND reg_periksa.kd_pj = '".$kd_pj."'
        GROUP BY reg_periksa.tgl_registrasi")
    : $mysqli->query("SELECT
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

function mergeQueryStr($url = null,$query = null,$recursive = false) {
  // $url = 'http://www.google.com.au?q=apple&type=keyword';
  // $query = '?q=banana';
  // if there's a URL missing or no query string, return
  if($url == null)
    return false;
  if($query == null)
    return $url;
  // split the url into it's components
  $url_components = parse_url($url);
  // if we have the query string but no query on the original url
  // just return the URL + query string
  if(empty($url_components['query']))
    return $url.'?'.ltrim($query,'?');
  // turn the url's query string into an array
  parse_str($url_components['query'],$original_query_string);
  // turn the query string into an array
  parse_str(parse_url($query,PHP_URL_QUERY),$merged_query_string);
  // merge the query string
  if($recursive == true)
    $merged_result = array_merge_recursive($original_query_string,$merged_query_string);
  else
    $merged_result = array_merge($original_query_string,$merged_query_string);
  // Find the original query string in the URL and replace it with the new one
  return str_replace($url_components['query'],http_build_query($merged_result),$url);
}
?>