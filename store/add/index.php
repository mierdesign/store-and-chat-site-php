<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./inputs.css">
</head>
<body>
<form class="addform" action="./success/" method="post" enctype="multipart/form-data">
                  <input name="name" value="" class="name" type="text" placeholder="name of the item">                  
                  <input name="desc" value="" class="searchbar" type="text" placeholder="desc of the item">
  <input id="uploadFile" disabled="disabled" />
  <label for="fileToUpload" class="custom-file-upload">upload file</label>
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Submit Your item" name="submit">
</form>
<script>
const image_input = document.querySelector("#fileToUpload");
image_input.addEventListener("change", function() {
   const reader = new FileReader();
   reader.addEventListener("load", () => {
   const uploaded_image = reader.result;
   document.querySelector("#uploadFile").style.backgroundImage = `url(${uploaded_image})`;
   document.querySelector("#uploadFile").style.display = "block";
});
   reader.readAsDataURL(this.files[0]);
});
</script>
</body>
</html>