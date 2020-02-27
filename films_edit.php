<a class="logout-btn" href='logout.php'>Logout</a>
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
    $title = $_GET["title"];

    if(isset($_POST["submit"])) {
        $stmt = $pdo->prepare(
            'UPDATE media
            SET
                title = "'.$_POST['title'].'",
                duur = '.$_POST['duur'].',
                datum_uitkomst = "'.$_POST['uitkomst'].'",
                land_uitkomst = "'.$_POST['land'].'",
                description = "'.addslashes($_POST['desc']).'"
            WHERE
                title = "'.$_GET['title'].'";'
        );
        $stmt->execute();
        $title = $_POST["title"];
    }
    ?>
    <a href='films.php?title=<?php echo $title;?>'>Terug</a>
    <form id='films_form' action='films_edit.php?title=<?php echo $title;?>' method='post'><table>
    <?php
    $stmt = $pdo->query('SELECT * FROM media WHERE title LIKE "'.$title.'"');
    while($row = $stmt->fetch()) {
        ?>
        <h1><?php echo $row["title"];?> - <?php echo $row["duur"];?></h1>
        <tr>
            <td>
                <b>Title</b>
            </td>
            <td>
                <input type='text' name='title' value='<?php echo $row["title"];?>' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Duur</b>
            </td>
            <td>
                <input type='number' name='duur' value='<?php echo $row["duur"];?>' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Datum van uitkoms</b>
            </td>
            <td>
                <input type='date' name='uitkomst' value='<?php echo $row["datum_uitkomst"];?>' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Land van uitkoms</b>
            </td>
            <td>
                <input type='text' name='land' value='<?php echo $row["land_uitkomst"];?>'>
            </td>
        </tr>
        <tr>
            <td>
                <b>Omschrijving</b>
            </td>
            <td>
                <textarea name='desc' form='films_form'><?php echo $row["description"];?></textarea>
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
                <input type='submit' name='submit'></input>
            </td>
        </tr>
        <?php
    }
    ?>
        </table>
    </form>
    <?php
     
} catch(\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>