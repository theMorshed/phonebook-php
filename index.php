<?php 
    define('DB_NAME', dirname(__FILE__) . "\data\data.txt");
    require_once "lib/crud.library.php"; 
    $task = $_GET['task'] ?? 'report';
    if('seed' == $task) {
        seed(DB_NAME);
        $info = "Seeding Completed successfully";
    }elseif('delete' == $task) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);  
        deleteFriend($id);      
    }
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_STRING);
    if($fname != "" && $lname != "" && $address != "" && $number != "") {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        if($id) {
            updateFriend($id, $fname, $lname, $address, $number);
        }else {
            addFriend($fname, $lname, $address, $number);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Miligram CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.0/milligram.css">
    <title>CRUD - PHP project</title>
    <style>
        .mt-30 {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column column-60 column-offset-20 mt-30">                
                <h2>CRUD - A simple PHP project</h2>
                <h4>Create Read Update AND Delete</h4>
                <nav>
                    <a class="button" href="index.php?task=report">Report</a>
                    <a class="button" href="index.php?task=add">Add New</a>
                    <?php if(filesize(DB_NAME) <= 10): ?>
                        <a class="button" href="index.php?task=seed">Seed</a>
                    <?php endif; ?>
                </nav>
                <?php echo $info; ?>
                <?php
                    if('report' == $task || 'seed' == $task):
                        ?>
                        <div class="report">
                            <?php 
                            if(!filesize(DB_NAME) <= 10){
                                generateReport();
                            }
                            ?>
                        </div>
                    <?php
                    endif;
                ?>
                <?php if('add' == $task): ?>
                    <form method="post" action="index.php">
                        <fieldset>
                            <label for="fname">First Name</label>
                            <input type="text" placeholder="Enter Your First name" id="fname" name="fname" required>
                            <label for="lname">Last Name</label>
                            <input type="text" placeholder="Enter Your Last name" id="lname" name="lname" required>
                            <label for="address">Address</label>
                            <input type="text" placeholder="Enter Your Address" id="address" name="address" required>
                            <label for="number">Number</label>
                            <input type="number" placeholder="Enter Your Number" id="number" name="number" required>
                            <input name="submit" class="button-primary" type="submit" value="Add">
                        </fieldset>
                    </form>
                <?php endif; ?>
                <?php 
                if('edit' == $task):
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING) ;
                $friend = getFriend($id);
                ?>
                    <form method="post" action="index.php">
                        <fieldset>
                            <input type="hidden" value="<?php echo $id; ?>" name="id">
                            <label for="fname">First Name</label>
                            <input type="text" placeholder="Enter Your First name" id="fname" name="fname" value="<?php echo $friend['fname']; ?>">
                            <label for="lname">Last Name</label>
                            <input type="text" placeholder="Enter Your Last name" id="lname" name="lname" value="<?php echo $friend['lname']; ?>">
                            <label for="address">Address</label>
                            <input type="text" placeholder="Enter Your Address" id="address" name="address" value="<?php echo $friend['address']; ?>">
                            <label for="number">Number</label>
                            <input type="number" placeholder="Enter Your Number" id="number" name="number" value="<?php echo $friend['number']; ?>">
                            <input name="submit" class="button-primary" type="submit" value="Update">
                        </fieldset>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="lib/script.library.js" type="text/javascript"></script>
</body>
</html>