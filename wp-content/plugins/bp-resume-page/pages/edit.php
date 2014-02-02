
<div class="bprp-edit">
	<div class="education bprp-section">
		<h2><?php _e('Education','budypress')?></h2>
		<div class="section-descr-wrap">
			<div class="line"></div>
			<h4 class="section-descr"><?php _e('Enter School','budypress')?></h4>
		</div>
		<form class="bprp-form standard-form" action="" method="post" >
			<table>
				<tr>
					<th><?php _e('Name','buddypress')?></th>
					<td><input type="text" name="education[name]" class="std" value="" /></td>
				</tr>
				<tr>
					<th><?php _e('City','buddypress')?></th>
					<td><input type="text" name="education[city]" class="std" value="" /></td>
				</tr>
				<tr>
					<th><?php _e('State','buddypress')?></th>
					<td><input type="text" name="education[state]" class="std" value="" /></td>
				</tr>
				<tr>
					<th><?php _e('Country','buddypress')?></th>
					<td>
						<select name="education[country]" class="std">
							<?php $this->country_list()?>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php _e('Degree/Program','buddypress')?></th>
					<td><input type="text" name="education[degree]" class="std" value="" /></td>
				</tr>
				<tr>
					<th colspan="2">&nbsp;</th>
				</tr>
				<tr>
					<th><?php _e('Start Date','buddypress')?></th>
					<td>
						<select name="education[start_date_m]" class="date-m">
							<?php $this->months_list();?>
						</select>
		
						<select name="education[start_date_y]" class="date-y">
							<?php $this->years_list();?>
						</select>
					</td>
				</tr>
				
				<tr>
					<th><?php _e('End Date','buddypress')?></th>
					<td>
						<select name="education[end_date_m]" class="date-m">
							<?php $this->months_list();?>
						</select>
						
						<select name="education[end_date_y]" class="date-y">
							<?php $this->years_list();?>
						</select>
						
						<input type="checkbox" value="1" name="education[current]" /><strong> <?php _e('I currently attend this school','buddypress')?></strong>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="bprp-button" name="add_education" value="+ Add"/>
			</p>
		</form>
		
	</div>
	
	<div class="experience bprp-section">
		<h2><?php _e('Professional Experience','budypress')?></h2>
		<div class="section-descr-wrap">
			<div class="line"></div>
			<h4 class="section-descr"><?php _e('Employer Information','buddypress')?></h4>
		</div>
		<form class="bprp-form standard-form"  action="" method="post">
			<table>
				<tr>
					<th><?php _e('Employer','buddypress')?></th>
					<td><input type="text" name="experience[employer]" class="long" value="" placeholder="Enter employer name"/></td>
				</tr>
				<tr>
					<th><?php _e('City','buddypress')?></th>
					<td><input type="text" name="experience[city]" class="long" value="" placeholder="Enter City" /></td>
				</tr>
				<tr>
					<th><?php _e('State','buddypress')?></th>
					<td><input type="text" name="experience[stare]" class="long" value="" placeholder="Enter State"/></td>
				</tr>
				<tr>
					<th><?php _e('Country','buddypress')?></th>
					<td>
						<select name="experience[country]" class="std">
							<?php $this->country_list()?>
						</select>
					</td>
				</tr>
			</table>
			
			<div style="margin-top:20px;" class="section-descr-wrap">
				<div class="line"></div>
				<h4 class="section-descr"><?php _e('Position Information','buddypress')?></h4>
			</div>
				
			<table>
				<tr>
					<th><?php _e('Position','buddypress')?></th>
					<td><input type="text" name="experience[position]" class="long" value="" placeholder="Enter position title"/></td>
				</tr>
				<tr>
					<th><?php _e('Start Date','buddypress')?></th>
					<td>
						<select name="experience[start_date_m]" class="date-m">
							<?php $this->months_list();?>
						</select>
		
						<select name="experience[start_date_y]" class="date-y">
							<?php $this->years_list();?>
						</select>
					</td>
				</tr>
				
				<tr>
					<th><?php _e('End Date','buddypress')?></th>
					<td>
						<select name="experience[end_date_m]" class="date-m">
							<?php $this->months_list();?>
						</select>
						
						<select name="experience[end_date_y]" class="date-y">
							<?php $this->years_list();?>
						</select>
						
						<input type="checkbox" value="1" name="experience[current]" /><strong> <?php _e('I currently work here','buddypress')?></strong>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="bprp-button" name="add_experience"  value="+ Add"/>
			</p>
		</form>
		
	</div>
	
	<div class="experience bprp-section">
		<h2><?php _e('Skills','budypress')?></h2>
		<div class="section-descr-wrap">
			<div class="line"></div>
			<h4 class="section-descr"><?php _e('Add Skills','buddypress')?></h4>
		</div>
		
		<form class="bprp-form standard-form"  action="" method="post">
			<table>
				<tr>
					<th></th>
					<td><input type="text" name="skill" class="long" value="" placeholder="Add skills, individually"/></td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="bprp-button" name="add_skill" value="+ Add"/>
			</p>
		</form>
		
	</div>
</div>
