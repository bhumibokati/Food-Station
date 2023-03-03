<?php
// including the database connection file
include_once("connectdbFood.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];

    $fname = $_POST['fname'];
    $price = $_POST['price'];
    $food_desc = $_POST['food_desc'];


    $imgFile = $_FILES['image']['name'];
    $tmp_dir = $_FILES['image']['tmp_name'];
    $imgSize = $_FILES['image']['size'];

    if ($imgFile) {
        $upload_dir = 'img/food/'; // upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'jfif'); // valid extensions

        // rename uploading image
        $food_image = $fname . "." . $imgExt;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 5000000) {
               

                move_uploaded_file($tmp_dir, $upload_dir . $food_image);
            }
        }

       
    }


    // checking empty fields
    if (empty($fname) || empty($price) || empty($food_desc)) {

        if (empty($fname)) {
            echo "<font color='red'>Name field is empty.</font><br/>";
        }

        if (empty($price)) {
            echo "<font color='red'>price field is empty.</font><br/>";
        }

        if (empty($food_desc)) {
            echo "<font color='red'>description field is empty.</font><br/>";
        }
    } elseif (!is_numeric($_POST['price'])) {

        echo ("Price must be a number.");
        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } else {
        //updating the table
        $sql = "UPDATE foods SET fname=:fname, price=:price, food_desc=:food_desc,img=:img WHERE id=:id";
        $query = $pdo->prepare($sql);

        $query->bindparam(':id', $id);
        $query->bindparam(':fname', $fname);
        $query->bindparam(':price', $price);
        $query->bindparam(':food_desc', $food_desc);
       


        $query->bindparam(':img', $food_image);
        $query->execute();

        //redirectig to the display page. In our case, it is index.php
        header("Location: index_food.php");
    }
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//food table
$sql = "SELECT * FROM foods WHERE id=:id";
$query = $pdo->prepare($sql);
$query->execute(array(':id' => $id));

while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $fname = $row['fname'];
    $price = $row['price'];
    $food_desc = $row['food_desc'];
    $img = $row['img'];
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Simple Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .login-form {
            width: 340px;
            margin: 50px auto;
        }

        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        .login-form h2 {
            margin: 0 0 15px;
        }

        .form-control,
        .btn {
            min-height: 38px;
            border-radius: 2px;
        }

        .btn {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <br /><br />

        <form name="form1" method="post" action="edit_food.php">

            <h2 class="text-center">Update Food Items</h2>
            <div class="form-group">
                <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="price" value="<?php echo $price; ?>">
            </div>
            <div class="form-group">
                <textarea class="form-control" name="food_desc" rows="3"><?php echo ($food_desc); ?></textarea>
            </div>
            <div class="form-group">
                <label>Select Image File:</label>
                <input type="file" name="image">
            </div>
            <input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
            <button type="submit" name="update" class="btn btn-success">Submit</button>
        </form>
        <p class="text-center"> <a href="index_food.php">List of Food</a></p>

    </div>
</body>

</html>