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
    <a class="navbar-brand" href="#"><i class="fas fa-camera"></i> PicTell</a>
  </div>
</nav>

<form action="actions/upload_picture.actions.php"  method="post" enctype="multipart/form-data">  
	<div class="container py-5">
	  <div class="card p-4 shadow-sm mb-4">
		<h5><strong>Upload an Image and We'll Tell You a Story</strong></h5>
		<p class="text-muted">Our AI will analyze your image and automatically create a story based on what it sees.</p>
		<div id="dropZone" class="border border-2 border-primary rounded p-5 text-center bg-light-subtle" style="cursor: pointer;">
		  <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
		  <p class="text-primary">Drag & drop an image here or click to browse</p>
		  <p class="text-muted small">Supports: JPEG, JPG, PNG (Max 5MB)</p>
		  <input type="button" id="browseBtn" class="btn btn-primary" value="Browse Files"/>
		  <input type="file" name="fileInput" id="fileInput" accept="image" class="d-none">
		</div>
	  </div>

	  <div id="progressContainer" class="card text-center p-4 shadow-sm d-none">
		<p><strong>Analyzing Image...</strong></p>
		<div class="progress">
		  <div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar"></div>
		</div>
		<p class="small mt-2" id="progressText">0%</p>
	  </div>

	  <div id="picturePreview" class="card p-4 shadow-sm d-none">
		<h6 class="mb-3">Picture Preview</h6>
		<div class="row">		
			<div class="col-md-12">
				<center><img id="previewImage" src="" class="img-fluid rounded" style="height: 100%"></center>
			</div>
		</div>
		<div class="row">	
			<div class="col-md-12">
				<div class="d-flex justify-content-center" style="padding-top: 10px">
					<center><input type="submit" class="btn btn-success" value="Regenerate a Story"/></center>
				</div>
			</div>
		</div>
	  </div>
</form>
  
  <!--<div id="articlePreview" class="card p-4 shadow-sm d-none">
    <h6 class="mb-3">Generated Article Preview</h6>
    <div class="row">
      <div class="col-md-4">
        <img id="previewImage" src="" class="img-fluid rounded img-preview">
      </div>
      <div class="col-md-8">
        <input type="text" class="form-control mb-2" value="Title Here">
        <textarea class="form-control mb-2" rows="6">Article Here</textarea>
        <div class="d-flex justify-content-end">
          <button class="btn btn-secondary me-2">Regenerate</button>
          <button class="btn btn-success">Publish Article</button>
        </div>
      </div>
    </div>
  </div>-->
  
  <div id="errorWindow" class="card p-4 shadow-sm d-none">
    <h6 class="mb-3" style="color:red">Wrong File Format</h6>
  </div>

  <h5 class="mt-5 mb-3"><strong>Recent Articles</strong></h5>
  <div class="row g-3">
    <div class="col-md-4">
      <div class="card p-3 shadow-sm">
        <img src="https://plus.unsplash.com/premium_photo-1682629632657-4ac307921295?q=80&w=1926&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top mb-2" style="height: 300px;">
        <h6>Exploring Hidden Gems in Coastal Towns</h6>
        <p class="text-muted small">April 15, 2025</p>
        <p class="small">Discover charming villages, local cuisine, and breathtaking views...</p>
        <a href="#" class="text-primary small">Read more <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 shadow-sm">
        <img src="https://plus.unsplash.com/premium_photo-1661963212517-830bbb7d76fc?q=80&w=1986&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top mb-2" style="height: 300px;">
        <h6>The Future of AI in Everyday Applications</h6>
        <p class="text-muted small">April 10, 2025</p>
        <p class="small">From smart homes to personalized recommendations, AI is transforming our lives...</p>
        <a href="#" class="text-primary small">Read more <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 shadow-sm">
        <img src="https://plus.unsplash.com/premium_photo-1673108852141-e8c3c22a4a22?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top mb-2" style="height: 300px;">
        <h6>Traditional Recipes with Modern Twists</h6>
        <p class="text-muted small">April 5, 2025</p>
        <p class="small">Chefs around the world are reimagining classic dishes with innovative ingredients...</p>
        <a href="#" class="text-primary small">Read more <i class="fas fa-arrow-right"></i></a>
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
    <div class="text-center small mt-4">Â© 2025 PicTell. All rights reserved.</div>
  </div>
</footer>

<script>
  const dropZone = document.getElementById('dropZone');
  const fileInput = document.getElementById('fileInput');
  const browseBtn = document.getElementById('browseBtn');
  const progressContainer = document.getElementById('progressContainer');
  const errorWindow = document.getElementById('errorWindow');
  const progressBar = document.getElementById('progressBar');
  const progressText = document.getElementById('progressText');
  const picturePreview = document.getElementById('picturePreview');
  const previewImage = document.getElementById('previewImage');

  browseBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    fileInput.click();
  });

  fileInput.addEventListener('change', (e) => {
    if (e.target.files.length) {
		simulateUpload(e.target.files[0]);
    }
  });

  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, e => {
      e.preventDefault();
      e.stopPropagation();
    });
  });

  dropZone.addEventListener('dragover', () => dropZone.classList.add('dropzone-hover'));
  dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dropzone-hover'));
  dropZone.addEventListener('drop', (e) => {
    dropZone.classList.remove('dropzone-hover');
    const files = e.dataTransfer.files;
    if (files.length) {
      fileInput.files = files;
      simulateUpload(files[0]);
    }
  });
  
	

  function simulateUpload(file) {
    progressContainer.classList.remove('d-none');
	errorWindow.classList.add('d-none');
    picturePreview.classList.add('d-none');

	const reader = new FileReader();
	reader.onload = function(e) {
	  previewImage.src = e.target.result;
	};
	reader.readAsDataURL(file);
	
	
	if (file.type.match("image"))
	{
		let progress = 0;
		const interval = setInterval(() => {
		  progress += 5;
		  progressBar.style.width = progress + '%';
		  progressText.textContent = progress + '%';
		  if (progress >= 100) {
			clearInterval(interval);
			showArticle();
		  }
		}, 100);
	}
	else{
		let progress = 0;
		const interval = setInterval(() => {
		  progress += 5;
		  progressBar.style.width = progress + '%';
		  progressText.textContent = progress + '%';
		  if (progress >= 100) {
			clearInterval(interval);
			showError();
		  }
		}, 100);
	}	
  }

  function showArticle() {
    progressContainer.classList.add('d-none');
	errorWindow.classList.add('d-none');
    picturePreview.classList.remove('d-none');
  }
  
  function showError() {
	progressContainer.classList.add('d-none');
    errorWindow.classList.remove('d-none');
    picturePreview.classList.add('d-none');
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
