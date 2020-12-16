
<!DOCTYPE html>
<html>
<body>

<form action="doupload-update.php" method="post" enctype="multipart/form-data">
  Login 
  <input id="idLogin" name="idLogin" type="text"  ><br>
  Password
  <input id="idPasswd" name="idPasswd" type="password" >
  
  <br>
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload" name="submit">
</form>

</body>
</html>
