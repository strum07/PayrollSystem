        <div class="header">
            <h2>Edit Employee Data</h2>
        </div>

        <div class="content">
            <h2 class="content-subhead">Select Employee to Edit</h2>
            <p>
				<?php
					$empList = $_SESSION['controller']->findEmployee($_POST['search']);
					print "<table><tr><th>select</th><th>Name</th><th>Address</th></tr>";
					foreach ($empList as $emp) {
						print "<tr><td><form method=POST action=index.php?page=editEmployee>";
						print "<button name='id' value='" . $emp->id . "'>Edit</button></form></td>";
						print "<td>&nbsp;" . $emp->name . "</td>";
						print "<td>&nbsp;" . $emp->address . "</td></tr>";
					}
					print "</table>";
				?>
			</p>
			<?php include 'php/footer.php'; ?>
       </div>       
