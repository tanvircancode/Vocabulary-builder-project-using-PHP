<?php
include_once 'config.php';
require_once 'functions.php';

session_start();

$_SESSION['id'] = $_SESSION['id'] ?? '';
$user_id = $_SESSION['id'];
if(!$_SESSION['id']){
    header('location:index.php');
    return;
}

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
mysqli_set_charset($connection, "utf8");
if(!$connection){
    throw new Exception("Not connected<br>");
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="assets/css/styling.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

	<title>Vocabularies Builder</title>
</head>
<body class="voc">
<div class="sidebar">
    <h4>Menu</h4>
    <ul class="menu">
        <li><a href="words.php" class="menu-item" data-target="words">All Words</a></li>
        <li><a href="#" class="menu-item" data-target="wordform">Add New Word</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
<div class="container" id="main">
<div>
    <h1 class="maintitle">
        <i class="fas fa-language"></i> <br/>My Vocabularies
    </h1>
    <div class="wordsc helement" id="words">
        <div class="row">
            <div class="column column-50">
                <div class="alphabets">
                    <select id="alphabets">
                        <option value="all">All Words</option>

                              <option value="<?php echo $char; ?>"></option>

                    </select>
                </div>
            </div>

            <div class="column column-50">
                <form action="" method="POST">
                    <button class="float-right" name="submit" value="submit">Search</button>
                    <input type="text" name="search" class="float-right" style="width: 50%; margin-right:20px;" placeholder="Search">
                </form>
            </div>
            </div>
        </div>
        <hr>

        <table class="words helement">
            <thead>
            <tr>
                <th width="20%">Word</th>
                <th>Definition</th>
            </tr>
            </thead>
            <?php
            $result = getWords($user_id);
            if(mysqli_num_rows($result)>0){

            while($data = mysqli_fetch_assoc($result)){

            ?>
            <tbody>

				<tr>
					<td><?php echo $data['word']; ?></td>
					<td><?php echo $data['meaning']; ?></td>
				</tr>

            </tbody>
            <?php } } ?>
        </table>

   </div>

    <div class="formc helement" id="wordform" style="display: none;">
        <form action="tasks.php" method="post">
            <h4>Add New Word</h4>
            <fieldset>
                <label for="word">Word <i style="font-size: 14px;color: grey;font-weight:normal;">(letters only, no special characters)</i></label>
                <input type="text" name="word" placeholder="Word" id="word" pattern="[A-Za-z]+">
                <label for="Meaning">Meaning <i style="font-size: 14px;color: grey;font-weight:normal;">(letters only, no special characters)</i></label>
                <textarea name="meaning" placeholder="Meaning" id="Meaning" style="height:100px" rows="10"></textarea>
                <input type="hidden" name="action" value="addword">
                <input class="button-primary" type="submit" value="Add Word">
            </fieldset>
        </form>
    </div>
   </div>
</body>
<script src="//code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="assets/js/script.js?1"></script>
</html>

<script>
    $(".menu-item").click(function(){
        $(".helement").hide();
        var target = "#" + $(this).data("target");
        $(target).show();
    })
</script>