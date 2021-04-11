<?php
require_once "top.inc.php";
$categories = "";
$msg = "";
if (isset($_GET["id"]) && $_GET["id"] != "") {
    $id = get_safe_value($_GET["id"]);
    $res = mysqli_query($con, "SELECT * FROM categories WHERE id = '$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $categories = $row["categories"];
    } else {
        header("location:categories.php");
        exit;
    }
}
if (isset($_POST["submit"])) {

    $categories = get_safe_value($_POST["categories"]);

    $res = mysqli_query($con, "SELECT * FROM categories WHERE categories = '$categories'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET["id"]) && $_GET["id"] != "") {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData["id"]) {

            } else {

                $msg = "Category Already Exist";
            }
        } else {
            $msg = "Category Already Exist";
        }
    }

    if ($msg == "") {
      if (isset($_GET["id"]) && $_GET["id"] <> ""){
         $sql = "UPDATE categories SET categories = '$categories' Where id = '$id'";
         mysqli_query($con,$sql);
      }else{
      $sql = "INSERT INTO categories (categories,status) VALUES ('$categories',1)";
      mysqli_query($con,$sql);
      }
      header("location:categories.php");
      exit;
    }
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <form method="POST">
                           <div class="card-header"><strong>Categories</strong><small> Form</small></div>
                           <div class="card-body card-block">
                              <div class="form-group">
                                 <label for="categories" class=" form-control-label">Category</label>
                                 <input type="text" id="categories" name="categories" placeholder="Enter category name" class="form-control" required value="<?php echo $categories ?>">
                              </div>
                              <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                              <span id="payment-button-amount">Submit</span>
                              </button>
                           </div>
                           <?php echo "<div class='field_error' style='margin : 10px;'>" . $msg . "</div>" ?>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<?php require_once "footer.inc.php"?>