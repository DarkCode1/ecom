<?php
require_once "top.inc.php";
$categories_id = "";
$name = "";
$mrp = "";
$price = "";
$qty = "";
$image = "";
$short_desc = "";
$description = "";
$meta_title = "";
$meta_description = "";
$meta_keyword = "";
$msg = "";
$image_required = "required";
if (isset($_GET["id"]) && $_GET["id"] != "") {
    $image_required = "";
    $id = get_safe_value($_GET["id"]);
    $res = mysqli_query($con, "SELECT * FROM product WHERE id = '$id'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $categories_id = $row["categories_id"];
        $name = $row["name"];
        $mrp = $row["mrp"];
        $price = $row["price"];
        $qty = $row["qty"];
        $image = $row["image"];
        $short_desc = $row["short_desc"];
        $description = $row["description"];
        $meta_title = $row["meta_title"];
        $meta_description = $row["meta_desc"];
        $meta_keyword = $row["meta_keyword"];
    } else {
        header("location:product.php");
        exit;
    }
}
if (isset($_POST["submit"])) {

    $categories_id = get_safe_value($_POST["categories_id"]);
    $name = get_safe_value($_POST["name"]);
    $mrp = get_safe_value($_POST["mrp"]);
    $price = get_safe_value($_POST["price"]);
    $qty = get_safe_value($_POST["qty"]);
    $short_desc = get_safe_value($_POST["short_desc"]);
    $description = get_safe_value($_POST["description"]);
    $meta_title = get_safe_value($_POST["meta_title"]);
    $meta_description = get_safe_value($_POST["meta_description"]);
    $meta_keyword = get_safe_value($_POST["meta_keyword"]);

    $res = mysqli_query($con, "SELECT * FROM product WHERE name = '$name'");
    $check = mysqli_num_rows($res);
    if ($check > 0) {
        if (isset($_GET["id"]) && $_GET["id"] != "") {
            $getData = mysqli_fetch_assoc($res);
            if ($id == $getData["id"]) {

            } else {

                $msg = "Product Already Exist";
            }
        } else {
            $msg = "Product Already Exist";
        }
    }

    if ($_FILES["image"]["type"] != "image/png" && $_FILES["image"]["type"] != "image/jpg" && $_FILES["image"]["type"] <> "image/jpeg"){
       $msg = "Format not supported";
    }

    if ($msg == "") {
        if (isset($_GET["id"]) && $_GET["id"] != "") {
            if ($_FILES["image"]["name"] != "") {

                $image = rand(0, 999999) . "__" . $_FILES["image"]["name"];
                move_uploaded_file($_FILES["image"]["tmp_name"], PRODUCT_IMAGE_SERVER_PATH . $image);
                $update_sql = "UPDATE product SET `categories_id`='$categories_id',`name`='$name',`mrp`='$mrp',`price`='$price',`qty`='$qty',`image`='$image',`short_desc`='$short_desc',`description`='$description',`meta_title`='$meta_title',`meta_desc`='$meta_description',`meta_keyword`='$meta_keyword' Where id = '$id'";
            }else{
               $update_sql = "UPDATE product SET `categories_id`='$categories_id',`name`='$name',`mrp`='$mrp',`price`='$price',`qty`='$qty', `short_desc`='$short_desc',`description`='$description',`meta_title`='$meta_title',`meta_desc`='$meta_description',`meta_keyword`='$meta_keyword' Where id = '$id'";
            }
            mysqli_query($con, $update_sql);
        } else {
            $image = rand(0, 999999) . "__" . $_FILES["image"]["name"];
            move_uploaded_file($_FILES["image"]["tmp_name"], PRODUCT_IMAGE_SERVER_PATH . $image);
            $sql = "INSERT INTO product (`categories_id`, `name`, `mrp`, `price`, `qty`, `short_desc`, `description`, `meta_title`, `meta_desc`, `meta_keyword`, `status`, `image`) VALUES ('$categories_id', '$name', '$mrp', '$price', '$qty', '$short_desc', '$description', '$meta_title', '$meta_description', '$meta_keyword',1,'$image')";
            mysqli_query($con, $sql);
        }
        header("location:product.php");
        exit;
    }
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <form method="POST" enctype="multipart/form-data">
                           <div class="card-header"><strong>Product</strong><small> Form</small></div>
                           <div class="card-body card-block">

                              <div class="form-group">
                                 <select name="categories_id" class="form-control">
                                    <option>Select Category</option>
                                    <?php
$res = mysqli_query($con, "SELECT id, categories from categories ORDER BY categories asc");
while ($row = mysqli_fetch_assoc($res)) {
    if ($row["id"] == $categories_id):
        echo "<option selected value='{$row['id']}'>{$row['categories']}</option>";
    else:
        echo "<option value='{$row['id']}'>{$row['categories']}</option>";
    endif;

}
?>
                                 </select>
                              </div>

                              <div class="form-group">
                                 <label for="product" class=" form-control-label">Product Name</label>
                                 <input type="text" id="product" name="name" placeholder="Enter product name" class="form-control" required value="<?php echo $name ?>">
                              </div>

                              <div class="form-group">
                                 <label for="mrp" class=" form-control-label">MRP</label>
                                 <input type="text" id="mrp" name="mrp" placeholder="Enter mrp name" class="form-control" required value="<?php echo $mrp ?>">
                              </div>

                              <div class="form-group">
                                 <label for="price" class=" form-control-label">Price</label>
                                 <input type="text" id="price" name="price" placeholder="Enter price name" class="form-control" required value="<?php echo $price ?>">
                              </div>

                              <div class="form-group">
                                 <label for="qty" class=" form-control-label">Qty</label>
                                 <input type="text" id="qty" name="qty" placeholder="Enter qty name" class="form-control" required value="<?php echo $qty ?>">
                              </div>

                              <div class="form-group">
                                 <label for="image" class=" form-control-label">Image</label>
                                 <input type="file" accept="image/*" name="image" placeholder="Enter image name" class="form-control" <?php echo $image_required ?>>
                              </div>

                              <div class="form-group">
                                 <label for="short_desc" class=" form-control-label">Short Description</label>
                                 <input type="text" id="short_desc" name="short_desc" placeholder="Enter short description name" class="form-control" required value="<?php echo $short_desc ?>">
                              </div>

                              <div class="form-group">
                                 <label for="description" class=" form-control-label">Description</label>
                                 <input type="text" id="description" name="description" placeholder="Enter short description name" class="form-control" required value="<?php echo $description ?>">
                              </div>

                              <div class="form-group">
                                 <label for="meta_title" class=" form-control-label">Meta Title</label>
                                 <input type="text" id="meta_title" name="meta_title" placeholder="Enter meta title name" class="form-control" value="<?php echo $meta_title ?>">
                              </div>

                              <div class="form-group">
                                 <label for="meta_description" class=" form-control-label">Meta Description</label>
                                 <input type="text" id="meta_description" name="meta_description" placeholder="Enter meta description name" class="form-control" value="<?php echo $meta_description ?>">
                              </div>

                              <div class="form-group">
                                 <label for="meta_keyword" class=" form-control-label">Meta Keyword</label>
                                 <input type="text" id="meta_keyword" name="meta_keyword" placeholder="Enter meta keyword name" class="form-control" value="<?php echo $meta_keyword ?>">
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