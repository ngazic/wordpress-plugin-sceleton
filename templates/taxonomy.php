<div class="wrap">

<h1>Taxonomy manager</h1>
<?php settings_errors(); ?>

  <ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST['edit_post']) ? 'active' : ''; ?>"><a href="#tab-1">Your Taxonomies</a></li>
		<li class="<?php echo isset($_POST['edit_post']) ? 'active' : ''; ?>"><a href="#tab-2">Add Custom Taxonomy</a></li>
		<li><a href="#tab-3">Export</a></li>
  </ul>
  
  <div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo !isset($_POST['edit_post']) ? 'active' : ''; ?>">
      <h3>Manage Your Custom Post Types</h3>
      <table class="cpt-table">
      <?php
         $options = get_option('pm_plugin_taxonomy')?:array();
         echo '<tr><th>ID</th><th>Singular Name</th><th class="text-center">Hierarchical</th><th class="text-center">ACTIONS</th></tr>';
         foreach ($options as $option) {
           $hierarchical = isset($option['hierarchical'])? 'YES' : 'NO';
          echo "<tr><td>$option[taxonomy]</td><td>$option[singular_name]</td><td class=\"text-center\">$hierarchical</td><td class=\"text-center\">";
          echo '<form action="" method="post" class="inline-block">';
          echo '<input type="hidden" name="edit_post" value="'.$option['taxonomy'].'"/>';
          settings_fields('pm_plugin_taxonomies_settings');
          submit_button('EDIT','delete small','submit',false);
          echo "</form>";
          echo '<form action="options.php" method="post" class="inline-block">';
          echo '<input type="hidden" name="remove" value="'.$option['taxonomy'].'"/>';
          settings_fields('pm_plugin_taxonomies_settings');
          submit_button('DELETE','delete small','submit',false,array('onclick' => 'return confirm("you have pressed the button");'));
          echo "</form></td></tr>";
         }
      ?>
      </table>
      
    </div>
      
    <div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_post']) ? 'active' : ''; ?>">
      <h3>Add new Taxonomy</h3>
      <form method="post" action="options.php">
        <?php
          settings_fields('pm_plugin_taxonomies_settings');
          do_settings_sections('pm_taxonomies');
          submit_button();
        ?>
      </form>
		</div>

		<div id="tab-3" class="tab-pane">
    <h3>Export Your Taxonomies</h3>


	  </div>
  
</div>