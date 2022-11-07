<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>upload</title>
</head>

<body>
    <div>
        <a link href="view.php">galery</a>
    </div>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div> 
            <label>Name</label>
            <input type="text" name="name"> 
        </div>

        <div>
            <label>Tag</label>
            <input type="text" name="tag"> 
        </div>

        <div>
            <label>Description</label>
            <input type="textarea" name="description"> 
        </div>
        <div>
            <label>Convert to </label>
        <select id="convert" name="convert" required>
            <option selected>--choose--</option>
            <option>webp</option>
            <option>png</option>
            <option>jpg</option>
        </select> 
        </div>
        <input type="file" name="files[]">
        <div>
            <input type="submit" value="Upload"> 
        </div>

    </form>
</body>

</html>