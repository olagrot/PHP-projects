<?php
error_reporting(-1);
ini_set("display_errors", "On");
session_start();

$_SESSION["width"]= $_SESSION["width"] ?? 10;
$_SESSION["height"]=$_SESSION["height"] ?? 10;
$_GET["x"]=$_GET["x"] ?? null;
$_GET["z"]=$_GET["z"] ?? null;
$_SESSION["xz"]=$_SESSION["xz"] ?? array();
$_SESSION["wynik"]=$_SESSION["wynik"] ?? [];

if (isset($_POST["color"])) {
    setcookie("color",$_POST["color"]);
    $_COOKIE['color'] = $_POST["color"];
}
if (isset($_POST["sx"])) {
    $_SESSION["width"]=$_POST['sx'];
}
if (isset($_POST["sz"])) {
    $_SESSION["height"]=$_POST['sz'];
}

if (isset($_SESSION["xz"]) && $_GET["x"] != null) {
    array_push($_SESSION["xz"], $_GET["x"], $_GET["z"]);
}

if (sizeof($_SESSION["xz"])>=4){
    $a1=$_SESSION["xz"][0];
    $a2=$_SESSION["xz"][1];
    $a3=$_SESSION["xz"][2];
    $a4=$_SESSION["xz"][3];
    $_SESSION["wynik"] = array_merge($_SESSION["wynik"],BresenhamLine($a1,$a2,$a3,$a4));
    unset($_SESSION["xz"]);
}



function BresenhamLine($x1, $y1, $x2, $y2)
 {
     //$d, $dx, $dy, $ai, $bi, $xi, $yi;
     $rys=array();
     $x = $x1;
     $y = $y1;
     // ustalenie kierunku rysowania
     if ($x1 < $x2)
     {
         $xi = 1;
         $dx = $x2 - $x1;
     }
     else
     {
         $xi = -1;
         $dx = $x1 - $x2;
     }
     // ustalenie kierunku rysowania
     if ($y1 < $y2)
     {
         $yi = 1;
         $dy = $y2 - $y1;
     }
     else
     {
         $yi = -1;
         $dy = $y1 - $y2;
     }
     // pierwszy piksel
     //glVertex2i($x, $y);
     $rys[0]=[$x,$y];
     // oś wiodąca OX
     if ($dx > $dy)
     {
         $ai = ($dy - $dx) * 2;
         $bi = $dy * 2;
         $d = $bi - $dx;
         // pętla po kolejnych x
         while ($x != $x2)
         {
             // test współczynnika
             if ($d >= 0)
             {
                 $x += $xi;
                 $y += $yi;
                 $d += $ai;
             }
             else
             {
                 $d += $bi;
                 $x += $xi;
             }
             //glVertex2i($x, $y);
             array_push($rys,[$x,$y]);
         }
     }
     // oś wiodąca OY
     else
     {
         $ai = ( $dx - $dy ) * 2;
         $bi = $dx * 2;
         $d = $bi - $dy;
         // pętla po kolejnych y
         while ($y != $y2)
         {
             // test współczynnika
             if ($d >= 0)
             {
                 $x += $xi;
                 $y += $yi;
                 $d += $ai;
             }
             else
             {
                 $d += $bi;
                 $y += $yi;
             }
             //glVertex2i($x, $y);
             array_push($rys,[$x,$y]);
         }
     }
     return $rys;
 }


?>
<html lang="en">
<head>
    <title>Superglobals</title>

    <style type="text/css">
        .block {
            display: inline-block;
            width: 30px;
            height: 30px;
            padding: 0;
            margin: 0;
        }

        .block:hover {
            background-color: lightgray;
        }
        .red {
            background-color: red;
        }

        .blue {
            background-color: blue;
        }

        .green {
            background-color: green;
        }

        .gray {
            background-color: gray;
        }

        .white {
            background-color: white;
        }
    </style>
</head>
<body>

<?php
for($i=0;$i<$_SESSION["height"];$i++){
    echo "<div>";
    for($j=0;$j<$_SESSION["width"];$j++){
        echo "<a class=\"block ";
        if (in_array([$j, $i],$_SESSION["wynik"])) {
            echo "white";
        }
        else if(isset($_COOKIE["color"])){
            echo $_COOKIE["color"];
        }
        else {
            echo "gray";
        }
        echo "\" href=\"?x=$j&z=$i\"></a>";
    }
    echo "</div>";
}
?>

<br/>

<form method="post">
    <label>
        Columns:
        <input type="number" name="sx">
    </label>
    <label>
        Rows:
        <input type="number" name="sz">
    </label>
    <input type="submit" value="Change">
</form>

<form method="post">
    <label>
        Color:
        <select name="color">
            <option value="gray">Gray</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
        </select>
    </label>
    <input type="submit" value="Change">
</form>

</body>
</html>
