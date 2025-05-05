<?php
require '../vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

error_reporting(E_ALL ^ E_NOTICE);

$bucketName = 'is215-project-bnmalinao';
$region = 'us-east-1'; // e.g., us-east-1

$s3 = new S3Client([
    'version' => 'latest',
    'region'  => $region,
    // No need for credentials if IAM role is attached
]);

	
 
    $allowedTypes = array('image/jpg', 'image/jpeg', 'image/png');
	
	$directory = "../pic/";
	$filecount = count(glob($directory . "*.{jpg,png}", GLOB_BRACE));
	$filecount=intval($filecount)+1;
		
	$ext = pathinfo($_FILES["fileInput"]["name"], PATHINFO_EXTENSION);
		

    if (in_array($_FILES["fileInput"]["type"], $allowedTypes))
    {
        if ($_FILES["fileInput"]["error"] > 0)
        {
            $alert="Error in uploading the picture";
        }
        else
        {
            if (file_exists($directory.$_FILES["fileInput"]["name"]))
            {
                $alert= $_FILES["fileInput"]["name"] . " already exists. ";
				$win_loc=$_SERVER['HTTP_REFERER'];
            }
            else
            {
				$filename= $filecount.'.'.$ext;
				$file = $_FILES["fileInput"];
		

    		try {
                    $result = $s3->putObject([
                     'Bucket'     => $bucketName,
                     'Key'        => basename($file['name']),
                     'SourceFile' => $file['tmp_name']
//                     'ACL'        => 'public-read' // Optional
                    ]);

    				
		    $basename = basename($file['name']);
		    $imageName = pathinfo($basename, PATHINFO_FILENAME);
                    move_uploaded_file($_FILES["fileInput"]["tmp_name"], $directory. $filename);
                    
		
                    $alert="Picture was successfully uploaded.";
    				$win_loc="../article.php?image=$imageName&story_id=".$filecount;

                    
                 } catch (AwsException $e) {
                echo "Upload failed: " . $e->getMessage();
                }
            }
    }
}
    else
    {
        $alert="Picture must be in JPG/JPEG/PNG format.";
		$win_loc=$_SERVER['HTTP_REFERER'];
    }
?>

<script type="text/javascript" language="javascript">
//	alert('<?php echo $alert;?>')
	window.location = "<?php echo $win_loc; ?>"
</script>

