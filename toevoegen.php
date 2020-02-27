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
<a href='index.php'>Terug</a>

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
    $type = $_GET["type"];

    ?>
    <form id='toevoegen_form' action='toevoegen.php?type=<?php echo $type;?>' method='post'>
        <table>
    <?php

    if(isset($_POST["submit"])) {
        $stmt = "";
        if($type == "film") {
            $stmt = $pdo->prepare(
                "INSERT INTO media (type, title, duur, datum_uitkomst, land_uitkomst, description)
                VALUES ('film', '".$_POST["title"]."', ".$_POST["duur"].", '".$_POST["uitkomst"]."', '".$_POST["land"]."', '".addslashes($_POST["desc"])."')"
            );
        } else if($type == "serie") {
            $stmt = $pdo->prepare(
                "INSERT INTO media (type, title, rating, has_won_awards, seasons, land_uitkomst, taal, description)
                VALUES ('serie', '".$_POST["title"]."', ".$_POST["rating"].", ".$_POST["awards"].", ".$_POST["seasons"].", '".$_POST["country"]."',
                '".$_POST["lan"]."', '".addslashes($_POST["desc"])."')"
            );
        }
        $stmt->execute();
        $title = $_POST["title"];
    }

    if($type == "film") {
        ?>
        <tr>
            <td>
                <b>Title</b>
            </td>
            <td>
                <input type='text' name='title' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Duur</b>
            </td>
            <td>
                <input type='number' name='duur' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Datum van uitkoms</b>
            </td>
            <td>
                <input type='date' name='uitkomst' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Land van uitkoms</b>
            </td>
            <td>
                <input type='text' name='land' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Omschrijving</b>
            </td>
            <td>
                <textarea name='desc' form='toevoegen_form'></textarea>
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
    } else if($type == "serie") {
        ?>
        <tr>
            <td>
                <b>Title</b>
            </td>
            <td>
                <input type='text' name='title' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Rating</b>
            </td>
            <td>
                <input type='number' name='rating' step='0.1' min='0' max='5' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Awards</b>
            </td>
            <td>
                <select name='awards'>
                    <option value='1'>Ja</option>
                    <option value='0' selected>Nee</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <b>Seasons</b>
            </td>
            <td>
                <input type='number' name='seasons' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Country</b>
            </td>
            <td>
                <input type='text' name='country' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Language</b>
            </td>
            <td>
                <input type='text' name='lan' />
            </td>
        </tr>
        <tr>
            <td>
                <b>Description</b>
            </td>
            <td>
                <textarea name='desc' form='toevoegen_form'></textarea>
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