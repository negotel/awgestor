<!DOCTYPE html>
<?php
$cookie_name = "SOU_UM_COOKIE";
$cookie_value = "EU SOU UM COOKIE OLÁ";
 // 5 min
?>
<html>
<body>

<?php
if(!setcookie($cookie_name, $cookie_value, (300 + time()), "/")) {
    echo "QUE PENA, NÃO CONSEGUI REGISTRAR UM COOKIE";
} else {
    echo "EURECA! EU REGISTREI UM COOKIE AQUI!";
}
?>

</body>
</html>