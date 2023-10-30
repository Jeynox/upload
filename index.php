<?php
if(!empty($_POST)){
    $data = array_map('trim', $_POST);
    $data = array_map('htmlentities', $data);

    $error = [];

    if (empty($data['name']) || !isset($data['name'])){
        $error['name'] = 'Vous devez remplir le prénom';
    }
    if (empty($data['lastname']) || !isset($data['lastname'])){
        $error[] = 'Vous devez remplir le nom';
    }
    if (empty($data['age']) || !isset($data['age'])){
        $error[] = 'Vous devez remplir l\'age';
    }
    if (empty($data['email']) || !isset($data['email'])){
        $error[] = 'Vous devez remplir le mail';
    }
    //if (empty($data['file']) || !isset($data['file'])){
       // $error[] = 'Vous devez inserrer une image';
    //}
   

    $uploadDir = 'uploads/';
    
    $tmpName = $_FILES['avatar']['tmp_name'];

    

    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

    $authorizedExtensions = ['jpg','jpeg','png'];

    $maxFileSize = 100000;

    if ((!in_array($extension, $authorizedExtensions))) {
        $error[] = 'Votre fichier doit avoir une extention en : .jpg, .jpeg, .png'; 
    } 

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize){
        $error[] = 'Votre fichier dois faire moins de 1M';
    }

    if (in_array($extension, $authorizedExtensions) && filesize($_FILES['avatar']['tmp_name']) < $maxFileSize){
        
        $unicName = uniqid("", true);
        $fileName = $unicName . "." . $extension;
        move_uploaded_file($tmpName, 'uploads/' . $fileName);
        var_dump($fileName);
    }
    $uploadFile = $uploadDir . $fileName;
    if (!empty($error)){
        foreach ($error as $errors){
            echo $errors . "<br>";
        }    
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>


    <form method="post" enctype="multipart/form-data">
    <div class="mb-3 container-lg">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control border-success">
    </div>

    <div class="mb-3 ml-3 container-lg">
        <label for="lastname" class="form-label">Lastname</label>
        <input type="text" name="lastname" id="lastname" class="form-control border-success">
    </div>

    <div class="mb-3 ml-3 container-lg">
        <label for="age" class="form-label">Age</label>
        <input type="number" name="age" class="form-control border-success">
    </div>

    <div class="mb-3 ml-3 container-lg">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control border-success">
    </div>

    <div class="container-lg">
        <label for="formFileLg" class="form-label">Large file input example</label>
        <input class="form-control form-control-lg border-success" id="formFileLg" type="file" name="avatar">
    </div>

    <div class="container-lg">
        <button name="send" class="btn btn-outline-primary">Send</button>
    </div>

</form>

    <main>
        Name : <?=$data['name']?> <br>
        Lastname : <?=$data['lastname']?> <br>
        Age : <?=$data['age']?> <br>
        Email : <?=$data['email']?> <br>
        Photo : <img src="<?=$uploadFile?>" alt="">
    </main>
</body>
</html>