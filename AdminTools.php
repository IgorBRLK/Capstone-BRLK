<?php
require_once 'core/init.php';
$user = new User();
if(!$user->hasPermission('admin')) {

    Redirect::to("javascript://history.go(-1)");
}

?>
<?php include 'includes/html/header.html'; ?>

<h1>Administrative Tools</h1>

    <div class="row">

        <div class="col-md-6">

            <p>Run your file here first to check if a users already exists.</p>
            <form action="checkUser.php" method="post" enctype="multipart/form-data">
                <input style="padding-bottom: 10px;" type="file" name="file" />
                <input type="submit" value="Check" />
            </form>
        </div>

        <div class="col-md-6">

            <p>First one is uploading a text file with users line by line with selecting a group</p>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label">Select Group</label>
                <select name="formGroup" required title="Please select a group carefully">
                    <option value="">Group</option>
                    <option value="2">Admin</option>
                    <option value="1">Student</option>
                </select>

                <input style="padding-bottom: 10px; padding-top: 10px;" type="file" name="file" />

                <input type="submit" value="upload" />
            </form>

        </div>

    </div>




<?php

if(Session::exists('adminTools')){
    echo '<h3 style="color: #940116">' . Session::flash('adminTools') . '</h3>' ; } ?>

<?php include 'includes/html/footer.html'; ?>