<?php
include "pia.php";

$sql = "SELECT * FROM iniciosesion";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table border='1'>
          <tr><th>ID</th><th>Usuario</th><th>Contraseña</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>".$row["id"]."</td>
            <td>".$row["usuario"]."</td>
            <td>".$row["contraseña"]."</td>
          </tr>";
  }
  echo "</table>";
} else {
  echo "No hay clientes";
}

$conn->close();
?>
