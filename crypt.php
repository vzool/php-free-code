<?

$password = "85465454465";
echo crypt($password,'ib_salt');
echo "<br/>";
echo crypt($password, $password);


