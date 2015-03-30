<?php

function temp_pricing() {
	?>
	<table class="pricing">
		<thead>
			<tr>
				<th>Tickets</th>
				<th>Lower Tier</th>
				<th>Upper Tier</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Standard</td>
				<td>$50</td>
				<td>$48</td>
			</tr>
			<tr>
				<td>Seniors</td>
				<td>$45</td>
				<td>$42</td>
			</tr>
			<tr>
				<td>Students</td>
				<td>$35</td>
				<td>$30</td>
			</tr>
		</tbody>
	</table>
	<?php
}



function sbe_render_ticket_pricing() {

	$standard_lower		= get_metabox( 'event-ticket-standard-lower' );
	$standard_upper		= get_metabox( 'event-ticket-standard-upper' );
	
	$senior_lower		= get_metabox( 'event-ticket-senior-lower' );
	$senior_upper		= get_metabox( 'event-ticket-senior-upper' );
	
	$student_lower		= get_metabox( 'event-ticket-student-lower' );
	$student_upper		= get_metabox( 'event-ticket-student-upper' );
	
	$caption 			= get_metabox( 'event-ticket-caption' );
	
	function price( $lower, $upper ) {
		if ( $lower && $upper ) :
		
			echo '<td>$' . $lower . '</td>';
			echo '<td>$' . $upper . '</td>';
			
		elseif ( $lower && ! $upper ) :
		
			echo '<td colspan="2">$' . $lower . '</td>';
			
		endif;
	}
	
	
	if ( $standard_lower ) :
		
		?>
		<div class="meta pricing">
			<table>
				
				<?php if ( $caption ) : ?>
				<caption><?php echo $caption; ?></caption>
				<?php endif; ?>
				
				<thead>
					<tr>
						<th>Tickets</th>
						<th>Lower Tier</th>
						
						<?php if ( $standard_upper || $senior_upper || $student_upper ) : ?>
						<th>Upper Tier</th>
						<?php endif; ?>
	
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>Standard</th>
						<?php price( $standard_lower, $standard_upper ); ?>
					</tr>
					
					<?php if ( $senior_lower ) : ?>
					<tr>
						<th>Seniors</th>
						<?php price( $senior_lower, $senior_upper ); ?>
					</tr>
					<?php endif; ?>
					
					<?php if ( $student_lower ) : ?>
					<tr>
						<th>Students</th>
						<?php price( $student_lower, $student_upper ); ?>
					</tr>
					<?php endif; ?>
					
				</tbody>
			</table>
		</div><!-- meta pricing -->
		<?php
			
	endif;
	
}