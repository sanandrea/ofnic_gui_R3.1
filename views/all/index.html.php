<?php
    /**
    * Copyright 2013 (C) Universita' di Roma La Sapienza
    *
    * This file is part of OFNIC Uniroma GE.
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
    <?php if (count($res) > 0) { ?>
    <table class="table">
        <?php
        echo '<h1></h1>';
        
        $i = 0;
		
  		  echo '<thead><tr>';
		  echo '<th>' . implode(array_keys($res[0]->data()), "</th><th>") . '</th>';
		  echo '</tr></thead>';
		
	    echo '<tbody>';
        
		foreach ($res as $item) {

		 echo '<tr>'; 
			echo '<td>' . implode($item->data(), "</td><td>") . '</td>';
		echo '</tr>'; 
				
		}
		
		echo '</tbody>';
       
       /* foreach ($res as $id => $item) {
            if ($i == 0) {
                echo '<thead><tr>';
                foreach ($item as $key => $value) {
                    echo '<th>' . $key . '</th>';
                }
                echo '</tr></thead>';
				
                echo '<tbody>';
            }

            echo '<tr>'; 
            foreach ($item as $key => $value) {
                echo '<td>' . $value . '</td>';
            }

            echo '</tr>';
            $i++;

        }
        if ($i != 0) { 
            echo '</tbody>';
        }*/
    ?>
</table>
<?php }
    else 
     echo '<span>No entry found!</span>';
          ?>
</div>