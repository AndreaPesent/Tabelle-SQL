<?php
$servername="localhost";
$username="root";
$password="";
$nome_db="testDB";
$conn = new mysqli($servername, $username, $password, $nome_db);
$tabella = $_POST['NomeTabella'];
$nomi = $_POST['nome'];
$tipi = $_POST['tipo'];
$notnull = isset($_POST['notnull']) ? $_POST['notnull'] : [];
$pk = isset($_POST['pk']) ? $_POST['pk'] : [];
$sql = "CREATE TABLE $tabella (";
$primary_keys = [];
for ($i = 0; $i < count($nomi); $i++) 
{
    $tipo = $tipi[$i];
    if ($tipo == "VARCHAR" || $tipo == "CHAR") 
        {
            $tipo .= "(255)";
        }
    $sql .= $nomi[$i] . " " . $tipo;
    if (isset($notnull[$i+1])) 
        {
            $sql .= " NOT NULL";
        }
    if (isset($pk[$i+1])) 
        {
            $primary_keys[] = $nomi[$i];
        }
    if ($i < count($nomi) - 1) 
        {
            $sql .= ", ";
        }
}
if (!empty($primary_keys)) 
{
    $sql .= ", PRIMARY KEY (" . implode(",", $primary_keys) . ")";
}

$sql .= ")";
if ($conn->query($sql)) 
{
    echo "Tabella creata";
} 
else 
{
    echo "Errore: " . $conn->error;
}
$conn->close();
?>