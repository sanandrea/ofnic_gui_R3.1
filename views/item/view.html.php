<?php
    /**
    * Copyright 2013 (C) Universita' di Roma La Sapienza
    *
    * This file is part of OFNIC Uniroma GEi
    *
    * OFNIC is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
    *
    * OFNIC is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
    *
    * You should have received a copy of the GNU General Public License
    * along with OFNIC.  If not, see <http://www.gnu.org/licenses/>.
    *
    * @author Andi Palo
    * @created 02/11/2014
    */
?>
<div>
    <table>
        <?php

        $i = 0;
        $fev = $res;
           echo '<thead><tr>';
          echo '<th>' . implode_recursive($res, "</th><th>", $type) . '</th>';
          echo '</tr></thead>';
          echo '<tbody>';
                
         

           echo '<tr>'; 
            echo '<td>' . implode_recursive($res, "</td><td>") . '</td>';
        echo '</tr>';

           echo '</tbody>';
    ?>
</table>
</div>
