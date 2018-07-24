<?php
include "inc/header.php";
?>
<?php
include "lib/config.php";
include "lib/database.php";
$db = new Database();
?>
<div class="myform">

	<?php
		if($_SERVER['REQUEST_METHOD'] == "POST"){

			$permitted = array('jpg', 'jpeg', 'png', 'gif');
			$file_name = $_FILES['image']['name'];
			$file_size = $_FILES['image']['size'];
			$file_temp = $_FILES['image']['tmp_name'];

			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(time()), 0, 10).'.'. $file_ext ;
			$uploaded_image = "uploads/".$unique_image;

			if(empty($file_name)){

				echo "<span class='error'>please insert any image</span>";

			}elseif($file_size >1048567){

				echo "<span class='error'>image should be 1mb or less </span>";

			}elseif(in_array($file_ext, $permitted) === false){

				echo "<span class='error'>you can upload only->".implode('.', $permitted)."</span>";

			}else{
		
			move_uploaded_file($file_temp,$uploaded_image);
			$query = "INSERT INTO tbl_image(image) VALUES ('$uploaded_image')";

			$inserted = $db -> insert($query);

			if($inserted){

				echo "<span class='success'>Image inserted successfully</span>";
			}else{

				echo "<span class='error'>Image is not inserted</span>";
			}
		  }
		}
	?>
	<form action="" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Select Image</td>
				<td><input type="file" name="image" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="UPLOAD" /></td>
			</tr>
		</table>
	</form>

	<table width="50%">
		<tr>
			<th width="10%">SERIAL</th>
			<th width="20%">IMAGE</th>
			<th width="20%">ACTION</th>

		</tr>
		<?php

			if(isset($_GET['del'])){

				$id = $_GET['del'];

				$getquery = "SELECT * FROM tbl_image WHERE id = '$id' ";

				$getImg = $db ->select($getquery);
				if($getImg){

					while ($imgdata = $getImg ->fetch_assoc()) {

						$del = $imgdata['image'];
						unlink($del);
					}
				}

				$query = "DELETE FROM tbl_image WHERE id = '$id' ";

				$deleteImage = $db ->delete($query);
				if($deleteImage){

				echo "<span class='success'>Image deleted successfully</span>";
				}else{

					echo "<span class='error'>Image is not deleted</span>";
				}
			}
		?>
		<?php
			$query = "SELECT * FROM tbl_image ORDER BY id asc";

			$getImage = $db ->select($query);

			if($getImage){
				$i = 0 ;
				while ($result = $getImage ->fetch_assoc()) {
					$i++;
		?>

		<tr>
			<td><?php echo $i; ?></td>
			<td><img src="<?php echo $result['image'] ; ?>" height="50px" weight="60px" /></td>
			<td><a href="?del=<?php echo $result['id'] ; ?>">DELETE</td>

		</tr>
		<?php } } ?>
	</table>

</div>

<?php
include "inc/footer.php";
?>