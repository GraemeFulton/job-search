<?php

$education = bp_get_user_meta( $this->user_id, 'resume_education', true);
$experience  = bp_get_user_meta( $this->user_id, 'resume_experience', true);
$skills  = bp_get_user_meta( $this->user_id, 'resume_skills', true);

if( !$education) $education = array();
if( !$experience) $experience = array();

usort($education, array($this, 'sort_dates'));
usort($experience, array($this, 'sort_dates'));

?>
<div class="bprp-view">
	
	<div class="education bprp-section">
		<h2><?php _e('Education','budypress')?></h2>
		<?php if( !empty($education) ):?>
			<?php foreach( (array)$education as $i => $school ):?>
				<div class="details-item">
					
					<?php if( bp_is_my_profile() || current_user_can('administrator') ):?>
						<div class="del-button">
							<a href="<?php echo $this->delete_link( $school['timestamp'], 'education')?>"><input class="bprp-button" type="button" value="<?php _e('Delete','buddypress')?>"></a>
						</div>
					<?php endif;?>
					
					<p class="top-container">
						<span class="title"><?php echo $school['name']?></span>
						<span class="location info"><?php echo $school['city'].', '.$school['state'].' '.$school['country']?></span>		
					</p>
					<span class="info">Degree: <?php echo $school['degree']?></span><br/>
					<span class="info">
						From - <?php echo $school['start_date_m'].'/'.$school['start_date_y']?> 
						<?php if( $school['current'] == 0):?>
							to <?php echo $school['end_date_m'].'/'.$school['end_date_y']?>
						<?php endif;?>
					</span><br/>
				</div>
			<?php endforeach;?>
		<?php else:?>
			<div class="details-item">
				<p>No Education places added</p>
			</div>
		<?php endif;?>
	</div>

	<div class="experience bprp-section">
		<h2><?php _e('Professional Experience','budypress')?></h2>
		<?php if( !empty($experience) ):?>
			<?php foreach( (array)$experience as $i => $exp ):?>
			<div class="details-item">
				<?php if( bp_is_my_profile() || current_user_can('administrator') ):?>
					<div class="del-button">
							<a href="<?php echo $this->delete_link($exp['timestamp'],'experience')?>"><input class="bprp-button" type="button" value="<?php _e('Delete','buddypress')?>"></a>
					</div>
				<?php endif;?>
				<p class="top-container">
					<span class="title"><?php echo $exp['employer']?></span>
					<span class="location info"><?php echo $exp['city'].', '.$exp['state'].' '.$exp['country']?></span>		
				</p>
				<span class="info">Position: <?php echo $exp['position']?></span><br/>
				<span class="info">
					From - <?php echo $exp['start_date_m'].'/'.$exp['start_date_y']?> 
					<?php if( $exp['current'] == 0):?>
						to <?php echo $exp['end_date_m'].'/'.$exp['end_date_y']?>
					<?php endif;?>
				</span><br/>
			</div>
			<?php endforeach;?>
		<?php else:?>
			<div class="details-item">
				<p>No Professional Experience added</p>
			</div>
		<?php endif;?>
		
		

	</div>

	<div class="skills_list bprp-section">
		<h2><?php _e('Skills','budypress')?></h2>
		<div class="details-item">
			<?php if( !empty($skills) ):?>
				<ul class="skills">
					<?php foreach( $skills as $i => $skill ):?>
						<li>- <?php echo $skill?>
							<?php if( bp_is_my_profile() || current_user_can('administrator') ):?>
								<a class="del-skill" href="<?php echo $this->delete_link($i,'skill')?>"><?php _e('Delete','buddypress')?></a>
							<?php endif;?>
						</li>
					<?php endforeach;?>
				</ul>
			<?php else:?>
				<p>No Skills added</p>
			<?php endif;?>

		</div>
	</div>
	
</div>

<script>
jQuery(document).ready(function(){
	jQuery('.del-button a, .del-skill').click(function(){
		return confirm('Are you sure want delete this info?')
	})
});
</script>