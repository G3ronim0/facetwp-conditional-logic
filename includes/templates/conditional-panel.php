<?php
/**
 * Panel template for Setup conditional logic.
 *
 * @package   FacetWP_Conditional_logic
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */

?>
<button type="button" class="button"

	data-title="<?php echo esc_attr( 'Add Ruleset' ); ?>"
	data-height="250"
	data-width="500"

	
	data-modal="ruleset"
	data-template="ruleset"
	data-focus="true"
	data-buttons="create"
	data-footer="conduitModalFooter"
	data-default='{"name":"untitled", "animate" : "appear" }'

	class="button" 

><?php _e('Add Ruleset', 'facetwp-conditional-logic'); ?></button>

<br><br>
<div class="uix-sortable" data-handle=".uix-sort-handle" data-items=".uix-sort-box" data-axis="y">
	{{#each ruleset}}
		
		<div class="uix-sort-box uix-control-box ruleset-row-{{_id}}">
			{{:node_point}}
			<input type="hidden" name="{{:name}}[animate]" value="{{animate}}">
			<table class="uix-control-bar" cellspacing="0" cellpadding="0">
				<tr>
					<td class="uix-sort-handle uix-control-bar-action left"><span style="cursor: s-resize;color: #a9a9a9;" class="dashicons dashicons-menu"></span></td>			
					<td class="uix-control-bar-action left"

						data-title="<?php echo esc_attr( 'Ruleset' ); ?>"
						data-height="250"
						data-width="500"

						
						data-modal="{{_node_point}}"
						data-template="ruleset"
						data-focus="true"
						data-buttons="save"
						data-footer="conduitModalFooter"

					><span class="dashicons dashicons-edit"></span></td>
					<td><label for="ruleset-{{_id}}" style="width: 100%; display: block;">{{name}}<input type="hidden" name="{{:name}}[name]" value="{{name}}"></label></td>
					<td class="uix-control-bar-action right">
						<label class="dashicons dashicons-arrow-{{#if hide}}down{{else}}up{{/if}}"><input id="ruleset-{{_id}}" data-live-sync="true" type="checkbox" name="{{:name}}[hide]" value="1" style="display:none;" {{#if hide}}checked="checked"{{/if}}></label>
					</td>
					<td class="uix-control-bar-action right" data-remove-element=".ruleset-row-{{_id}}" data-confirm="<?php echo esc_html__( 'Are you sure you want to remove this ruleset?', 'facetwp-conditional-logic' ); ?>"><span class="dashicons dashicons-trash"></span></td>

				</tr>
			</table>
			{{#if hide}}
				{{#if condition}}
					<input type="hidden" name="{{:name}}[condition]" value="{{json condition}}">
				{{/if}}
				{{#if action}}
					<input type="hidden" name="{{:name}}[action]" value="{{json action}}">
				{{/if}}
			{{else}}
			<div class="uix-control-box-content">			
				<div class="uix-grid">
					<div class="row">
						<div class="col-sm-7">
							<div class="uix-control-box">
								<table class="uix-control-bar" cellspacing="0" cellpadding="0">
									<tr>
										<td><?php _e('Conditions', 'facetwp-conditional-logic'); ?></td>							
									</tr>
								</table>
								<div class="uix-control-box-content">
									<table class="uix-control-bar" cellspacing="0" cellpadding="0">
										<tr>
											<td class="uix-control-bar-action left" style="background: #f8f8f8; text-transform: uppercase; font-weight: bold; color: rgb(151, 151, 151);text-align: center;">On</td>
											<td>
												<select name="{{:name}}[event]">
													<option value="_all_" {{#is event value="_all_"}}selected="selected"{{/is}}><?php _e('Refresh & Loaded', 'facetwp-conditional-logic'); ?></option>
													<option value="facetwp-loaded" {{#is event value="facetwp-loaded"}}selected="selected"{{/is}}><?php _e('Loaded', 'facetwp-conditional-logic'); ?></option>
													<option value="facetwp-refresh" {{#is event value="facetwp-refresh"}}selected="selected"{{/is}}><?php _e('Refresh', 'facetwp-conditional-logic'); ?></option>
													</select></td>
										</tr>
									</table>
									
									{{#each condition}}
										{{> conditional_row}}
									{{/each}}
								</div>
								<table class="uix-control-bar" cellspacing="0" cellpadding="0">
									<tr>
										<td class="uix-control-bar-action left">
											{{#unless condition}}
												<button type="button" class="button" data-add-node="{{_node_point}}.condition" data-node-default='{"type":"and"}'>
													<?php _e('Add a Condition', 'facetwp-conditional-logic'); ?>
												</button>
											{{else}}
												<button type="button" class="button" style="text-transform: uppercase;" data-add-node="{{_node_point}}.condition" data-node-default='{"type":"and"}'>
													<?php _e('And', 'facetwp-conditional-logic'); ?>
												</button>
											{{/unless}}
										</td>
										<td>&nbsp;</td>				
										
									</tr>
								</table>
							</div>
						</div>
						<div class="col-sm-5">
							<div class="uix-control-box">
								<table class="uix-control-bar" cellspacing="0" cellpadding="0">
									<tr>
										<td><?php _e('Actions', 'facetwp-conditional-logic'); ?></td>							
									</tr>
								</table>
								<div class="uix-control-box-content">
								{{#each action}}
									{{> action}}
								{{/each}}
								</div>
								<table class="uix-control-bar" cellspacing="0" cellpadding="0">
									<tr>
										<td class="uix-control-bar-action left">
											{{#unless action}}
												<button type="button" class="button" data-add-node="{{_node_point}}.action" data-node-default='{"type":"and"}'>
													<?php _e('Add an Action', 'facetwp-conditional-logic'); ?>
												</button>
											{{else}}
												<button type="button" class="button" style="text-transform: uppercase;" data-add-node="{{_node_point}}.action" data-node-default='{"type":"and"}'>
													<?php _e('And', 'facetwp-conditional-logic'); ?>
												</button>
											{{/unless}}
										</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>



			</div>
			{{/if}}

		</div>					
	{{/each}}
</div>
