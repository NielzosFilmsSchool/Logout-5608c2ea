<a class="logout-btn" href='logout.php'>Logout</a>
<a href='index.php'>Terug</a>
<a style='margin-left:20px;' href='films_edit.php?title=<?php echo $_GET['title']; ?>'>Bewerk</a>
<style>
    .logout-btn {
        position: absolute;
        right: 10px;
        top: 10px;
        padding: 10px;
        background-color: #5ca7e0;
    }
</style>

<?php

if(!isset($_COOKIE["loggedInUser"])) {
    header("Location: login.php");
}

$host = '127.0.0.1';
$db   = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $stmt = $pdo->query('SELECT * FROM media WHERE title LIKE "'.$_GET["title"].'"');
    while($row = $stmt->fetch()) {
        ?>  
        <h1><?php echo $row["title"]; ?> - <?php echo $row["duur"]; ?> minuten</h1>
        <b>Datum van uitkomst</b> <?php echo $row["datum_uitkomst"]; ?><br>
        <b>Land van uitkomst</b> <?php echo $row["land_uitkomst"]; ?><br>
        <p><?php echo $row["description"]; ?></p>
        <?php
    }
     
} catch(\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>