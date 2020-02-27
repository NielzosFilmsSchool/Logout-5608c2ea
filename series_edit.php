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
            "UPDATE media
            SET
                title = '".$_POST['title']."',
                rating = ".$_POST['rating'].",
                has_won_awards = ".$_POST['awards'].",
                seasons = ".$_POST['seasons'].",
                land_uitkomst = '".$_POST['country']."',
                taal = '".$_POST['lan']."',
                description = '".addslashes($_POST['desc'])."'
            WHERE
                title = '".$_GET['title']."';"
        );
        $stmt->execute();
        $title = $_POST["title"];
    }
    ?>
    <a href='series.php?title=<?php echo $title; ?>'>Terug</a>
    <form id='series_form' action='series_edit.php?title=<?php echo $title; ?>' method='post'>
        <table>
    <?php
    $stmt = $pdo->query("SELECT * FROM media WHERE title LIKE '".$title."'");
    while ($row = $stmt->fetch())
    {
        ?>
        <h1><?php echo $row["title"]; ?> - <?php echo $row["rating"]; ?></h1>
        <tr>
            <td>
                <b>Title</b>
            </td>
            <td>
                <input type='text' name='title' value='<?php echo $row["title"]; ?>' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Rating</b>
            </td>
            <td>
                <input type='number' name='rating' step='0.1' min='0' max='5' value='<?php echo $row["rating"]; ?>'>
            </td>
        </tr>
        <tr>
            <td>
                <b>Awards</b>
            </td>
            <td>
                <select name='awards'>
        <?php
        if($row["has_won_awards"] == 1) {
            ?>
            <option value='1' selected>Ja</option>
            <?php
        } else {
            ?>
            <option value='1'>Ja</option>
            <?php
        }
        if($row["has_won_awards"] == 0) {
            ?>
            <option value='0'selected>Nee</option>
            <?php
        } else {
            ?>
            <option value='0'>Nee</option>
            <?php
        }
        ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <b>Seasons</b>
            </td>
            <td>
                <input type='number' name='seasons' value='<?php echo $row["seasons"]; ?>' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Country</b>
            </td>
            <td>
                <input type='text' name='country' value='<?php echo $row["land_uitkomst"]; ?>' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Language</b>
            </td>
            <td>
                <input type='text' name='lan' value='<?php echo $row["taal"]; ?>' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Description</b>
            </td>
            <td>
                <textarea name='desc' form='series_form'><?php echo $row["description"]; ?></textarea>
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
    
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>

<style>
    td {
        width: 100px;
    }
</style>