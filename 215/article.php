<?php
	$story_id=$_GET['story_id'];
	
	if (file_exists("pic/".$story_id.".jpg"))
	{
		$img="pic/".$story_id.".jpg";
	}
	elseif (file_exists("pic/".$story_id.".jpeg"))
	{
		$img="pic/".$story_id.".jpeg";
	}
	elseif (file_exists("pic/".$story_id.".png"))
	{
		$img="pic/".$story_id.".png";
	}
	else{?>
		<script type="text/javascript" language="javascript">
			alert('Invalid Story ID')
			window.location = "index.php"
		</script>
	<?php
		exit();
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PicTell - Every photo has a story</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8fafc;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar-brand i {
      margin-right: 0.5rem;
    }
    .dropzone-hover {
      background-color: #eef5ff !important;
      border-color: #0d6efd !important;
    }
    .card:hover {
      box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.1);
      transform: scale(1.01);
      transition: 0.2s;
    }
    footer {
      background: #1a1a2e;
      color: white;
      padding: 3rem 1rem;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #0d6efd;
    }
    .img-preview {
      width: 100%;
      max-height: 200px;
      object-fit: cover;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="fas fa-camera"></i> PicTell</a>
  </div>
</nav>
 
<div class="container py-5">	  
    <div id="articlePreview" class="card p-4 shadow-sm">
    <h6 class="mb-3">Generated Article</h6>
    <div class="row">
      <div class="col-md-4">
        <img id="previewImage" src='<?php echo $img; ?>' class="img-fluid rounded">
      </div>
      <div class="col-md-8">
		<h6 style="color: blue; text-size: 11px"><b><?php echo strtoupper("Traditional Recipes with Modern Twists");?></b></h6>
        <p class="text-muted small" style="font-style: italic; text-size: 8px"><?php echo date("F d, Y", filemtime($img)); ?></p>
        <p class="small">Chefs around the world are reimagining classic dishes with innovative ingredients...</p>
      </div>
    </div>
  </div>
  
</div>

<footer class="mt-5">
  <div class="container">
    <div class="row text-center text-md-start">
      <div class="col-md-4 mb-3">
        <h5><i class="fas fa-camera"></i> PicTell</h5>
        <p class="small">Every photo has a story</p>
      </div>
    </div>
    <div class="text-center small mt-4">© 2025 PicTell. All rights reserved.</div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
