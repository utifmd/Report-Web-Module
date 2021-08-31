<?php
    session_start();

    $mysqli = new Mysqli("mysql", "root", "9809poiiop", "sik", 3306);
    // $mysqli = new Mysqli("localhost", "root", "", "fadhila", 3306); 
    $app_name = "RSIA Fadhila Batusangkar";
    $var_date_length = 31;

    $query = $mysqli->query("SELECT * FROM poliklinik WHERE status='1'");

    if(mysqli_connect_errno()) exit();
    else if(!$query) throw new Exception("Error Querying Request", 1);
    
    $list_month = []; for($i = 1; $i <= 12; $i++)
    $list_month[] = date('F', mktime(0, 0 ,0 , $i, 1, date('Y')));
    
    if(isset($_GET['year']))
        $current_year = $_GET['year'];
    else 
        $current_year =date('Y');

    if(isset($_GET['month'])){
        $current_month = $list_month[intval($_GET['month'])];
        $current_month_pos = $_GET['month'] ?: date('m'); 
    }else{
        $current_month = date('F');
        $current_month_pos = date('m'); 
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
<body>
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
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" data-mdb-toggle="modal"
                    data-mdb-target="#staticBackdrop" style="cursor:pointer">
                <?php if($_SESSION['isSignedIn']) echo "Sign Out";
                    else echo "Sign In"; ?>
                </a>
            </li>
        </ul>
        </div>
    </div>
    </nav>
    
    <div class="p-5 text-center bg-light">
        <h1 class="mb-3"><?php echo $app_name; ?></h1>
        <h4 class="mb-3">Aplikasi Laporan Registrasi Poliklinik</h4>
    </div>
<?php if(!$_SESSION['isSignedIn']) { ?>
    <div class="container p-3">
        <div class="alert alert-warning" role="alert"> <?php switch ($_GET['invalid_code']) {
            case 101: echo 'Kombinasi password dan username anda salah, pastikan anda menggunakan akun yang benar /valid.'; break;
            case 102: echo 'Panjang karakter username atau password harus 8-20'; break;
            default: echo 'Silahkan lakukan login dengan akun yang valid pada menu "Sign In" yang terdapat pada menu bar diatas.'; break; } ?>
        </div>
    </div>
<?php } ?>
    <div class="container-fluid p-3">
        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <div class="form-outline">
        <input type="number" id="yearNumber" class="form-control" min="1800"
            max="<?php echo date('Y') ?>" value="<?php echo $current_year ?>"/>
        <label class="form-label" for="yearNumber">Year</label>
        </div>
        <div class="btn-group" role="group">
            <button id="monthNumber" type="button" class="btn btn-primary dropdown-toggle"
                data-mdb-toggle="dropdown" aria-expanded="false">
                <?php echo $current_month ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <?php for($i = 0; $i < count($list_month); $i++){
                $selected_month = $list_month[$i]; echo 
                "<li onclick=\"funApply('".$selected_month."', '".$i."')\"><a class=\"dropdown-item\">".$selected_month."</a></li>"; } ?>
            </ul>
        </div>
        </div>
    </div>
    <?php if($_SESSION['isSignedIn']) { ?>
        <div class="table-responsive">
            <table id="table" class="table table-striped">
                <thead class="table-dark"><tr>
                    <th scope="col">No</th>
                    <th scope="col">Poliklinik</th>
                    <?php for($i = 0; $i < $var_date_length; $i++) echo "
                    <th scope=\"col\" style=\"padding-left:2.5px;padding-right:2.5px\">".str_pad(($i+1), 2, "0", STR_PAD_LEFT)."</th>" ?>
                    <th scope="col">Total</th>
                </tr></thead>
                <?php $num = 0; while($row = $query->fetch_assoc()){ $num++;
                    $param_date = $current_year."-".$current_month_pos; echo "
                <tbody class=\"table col-xl-12\"> <tr>
                    <th scope=\"col\">".$num."</th>
                    <td scope=\"col\" style=\"white-space: nowrap\">".$row['nm_poli']."</td>";
                    echo funIterateValues($row['kd_poli'], $current_year, $current_month_pos)."
                </tr>
                </tbody>"; } ?>
            </table>
    </div>
    <?php } ?>

    <section class="">
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
        <?php if(!$_SESSION['isSignedIn']) { ?>
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Sign In</h5>
            <button type="button" class="btn-close"
                data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="form-outline">
            <input id="username" type="text" name="input_text_username" class="form-control" aria-describedby="username-error" required minlength="6" maxlength="20"/>
            <label class="form-label" for="username">Username</label>
        </div>
            <div class="col-auto m-2"></div>
        <div class="form-outline col-auto">
            <input id="password" type="password" name="input_text_password" class="form-control" aria-describedby="password-error" required minlength="8" maxlength="20"/>
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
    $content = array("fadhila", "fadhli", "fitri");
    
    $username = $_POST['input_text_username'];
    $password = $_POST['input_text_password'];

    if((8 <= strlen($password)) && (strlen($password) <= 20)){
        if(in_array($username, $content) && $password === "staffonly"){
            
            $_SESSION['isSignedIn'] = "true";
            header("Location: ");
        }else header("Location: ?invalid_code=101");
    }else header("Location: ?invalid_code=102");
}

function funSignOut(){
    unset($_SESSION['isSignedIn']);
}

function funIterateValues($kd_poli, $year, $month) {
    global $mysqli, $var_date_length;

    $total = 0; for($i = 0; $i < $var_date_length; $i++){ $day = ($i+1);
        $query = $mysqli->query("
            SELECT
            reg_periksa.tgl_registrasi,
            COUNT(poliklinik.nm_poli) AS reg_poli_count
            FROM poliklinik 
            INNER JOIN reg_periksa ON reg_periksa.kd_poli = poliklinik.kd_poli

            WHERE EXTRACT(DAY FROM reg_periksa.tgl_registrasi) = '".$day."'
            AND EXTRACT(MONTH FROM reg_periksa.tgl_registrasi) = '".$month."'
            AND EXTRACT(YEAR FROM reg_periksa.tgl_registrasi) = '".$year."'
            AND reg_periksa.kd_poli = '".$kd_poli."'

            GROUP BY reg_periksa.tgl_registrasi
        ");
        $reg_poli_count = $query->fetch_assoc()['reg_poli_count'];
        if($reg_poli_count > 0){
            $total = $total + $reg_poli_count;
            echo "<td scope=\"col\" style=\"padding-left:2.5px;padding-right:2.5px\">".$reg_poli_count."</td>";
        }else
            echo "<td scope=\"col\" style=\"padding-left:2.5px;padding-right:2.5px\">-</td>";
    }
    echo "<td scope=\"row\">".$total."</td>";
}
?>