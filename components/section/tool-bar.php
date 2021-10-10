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
        <!-- <div class="btn-group" role="group">
            <button id="instituteKey" type="button" class="btn btn-primary dropdown-toggle <?php// echo !isset($_SESSION['isSignedIn']) ? "disabled" : ""?>"
                data-mdb-toggle="dropdown" aria-expanded="false">
                <?php // echo isset($current_institute) ? $current_institute : $list_institute[0]; ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="z-index:1070;">
            <?php// while($resource = $query_institute->fetch_assoc()){ echo 
                //"<li><a href=\"".mergeQueryStr($url, "?institute=".$resource['png_jawab']."&institute_code=".$resource['kd_pj']."")."\" class=\"dropdown-item\" style=\"cursor:pointer;\">".ucwords(strtolower($resource['png_jawab']))."</a></li>"; } ?>
            </ul>
        </div> -->
    </div>
    <!-- <div class="btn-group mb-5"><a href="./" class="btn btn-warning">reset</a></div>  -->
</div>