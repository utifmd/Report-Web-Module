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