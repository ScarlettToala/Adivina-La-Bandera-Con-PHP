
<?php
   $db = new SQLite3('/workspaces/m7-a14-diversi-n-con-banderas-ScarlettToala/database/ranking.db');

   if(!$db){
       die("Error en connectar a la base de dades");
   }
?>