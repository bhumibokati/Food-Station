<html>

<head>
  <title>Create Food Data</title>
</head>

<body>

  <?php
  //including the database connection file
  include_once("connectdbFood.php");
  session_start();
  if (isset($_POST['Submit'])) {
    $fname = $_POST['fname'];
    $price = $_POST['price'];
    $food_desc = $_POST['food_desc'];

    $imgFile=$_FILES['image']['name'];
    $tmp_dir=$_FILES['image']['tmp_name'];
    $imgSize=$_FILES['image']['size'];

    $upload_dir = 'img/food/'; // upload directory
         
       $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
               // valid image extensions
       $valid_extensions = array('jpeg', 'jpg', 'png', 'gif','jfif'); // valid extensions
          
           // rename uploading image
        $food_image = $fname.".".$imgExt;

    // checking empty fields
    if (empty($fname) || empty($price) || empty($food_desc)) {

      if (empty($fname)) {
        echo "<font color='red'>Name field is empty.</font><br/>";
      }

      if (empty($price)) {
        echo "<font color='red'>Age field is empty.</font><br/>";
      }





      if (empty($food_desc)) {
        echo "<font color='red'>Email field is empty.</font><br/>";
      }


      echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } elseif  (!is_numeric($_POST['price'])) { 
      
      echo ("Price must be a number.");
      echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } else {

      $sql = "INSERT INTO foods(fname, price, food_desc,img) VALUES(:fname, :price, :food_desc,:img)";
      $query = $pdo->prepare($sql);

      $query->bindparam(':fname', $fname);
      $query->bindparam(':price', $price);
      $query->bindparam(':food_desc', $food_desc);

        // allow valid image file formats
         if(in_array($imgExt, $valid_extensions)){   
      // Check file size '5MB'
      if($imgSize < 5000000)    {
       move_uploaded_file($tmp_dir,$upload_dir.$food_image);

           }
         }
     
      $query->bindparam(':img',$food_image);

      $query->execute();
      $_SESSION['success']="Data Has Been Successfully Saved.";
      header("Location:index_food.php");
    }
  }
  ?>
  
</body>

</html>

