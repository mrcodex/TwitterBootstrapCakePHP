<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="actions">
	<h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <?php echo h($singularHumanName);?>
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- dropdown menu links -->
        <li><?php echo "<?php echo \$this->Html->link(
            __('List " . $pluralHumanName . "'),
            array(
                'action' => 'index'
            )
        );?>";?></li>
    	<li><?php echo "<?php echo \$this->Html->link(
            __('New " . $singularHumanName . "'),
            array(
                'action' => 'new'
            )
        );?>";?></li>
    	<li><?php echo "<?php echo \$this->Form->postLink(
    		__('Delete'),
    		array(
    			'action' => 'delete',
    			\${$singularVar}['{$modelClass}']['{$primaryKey}']
    		),
    		null,
    		__('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])
    	);?>";?></li>
    	<li><?php echo "<?php echo \$this->Html->link(
            __('Edit'),
            array(
                'action' => 'edit',
                \${$singularVar}['{$modelClass}']['{$primaryKey}'],
            )
        );?>";?></li>
      </ul>
    </div>
<?php
    $done = array();
    foreach ($associations as $type => $data) {
        foreach ($data as $alias => $details) {
            if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {?>
	<div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
            <?php echo Inflector::humanize(Inflector::underscore($alias));?>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
        <!-- dropdown menu links -->
        <li><?php echo '<?php echo $this->Html->link(
            __(\'List ', Inflector::humanize($details['controller']) , '\'),
            array(
                \'controller\' => \'', $details['controller'], '\',
                \'action\' => \'index\'
            )
        );?>';?></li>
        <li><?php echo '<?php echo $this->Html->link(
            __(\'New ', Inflector::humanize(Inflector::underscore($alias)) , '\'),
            array(
                \'controller\' => \'', $details['controller'], '\',
                \'action\' => \'add\'
            )
        );?>';?></li><?php
			if ( $type == 'hasOne' ) {?>
		<li><?php echo "<?php echo \$this->Html->link(
					__('Edit " . Inflector::humanize(Inflector::underscore($alias)) . "'),
					array(
						'controller' => '{$details['controller']}',
						'action' => 'edit',
						\${$singularVar}['{$alias}']['{$details['primaryKey']}']
					)
			);?>\n";?>
		</li>
			<?php
			}
                $done[] = $details['controller'];
                echo PHP_EOL, '        </div>';
            }
        }
    }
    echo PHP_EOL, '    </div>';
?>
<div class="<?php echo $pluralVar; ?> view">
<h2><?php echo "<?php  echo __('{$singularHumanName}'); ?>"; ?></h2>
	<dl class="dl-horizontal">
<?php
foreach ($fields as $field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t<dt><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></dt>\n";
				echo "\t\t<dd>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t<dt><?php echo __('" . Inflector::humanize($field) . "'); ?></dt>\n";
		echo "\t\t<dd>\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
	}
}
?>
	</dl>
</div>
<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details): ?>
	<div class="related">
		<h3><?php echo "<?php echo __('Related " . Inflector::humanize($details['controller']) . "'); ?>"; ?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
		<dl class="dl-horizontal">
	<?php
			foreach ($details['fields'] as $field) {
				echo "\t\t<dt><?php echo __('" . Inflector::humanize($field) . "'); ?></dt>\n";
				echo "\t\t<dd>\n\t<?php echo \${$singularVar}['{$alias}']['{$field}']; ?>\n&nbsp;</dd>\n";
			}
	?>
		</dl>
	<?php echo "<?php endif; ?>\n"; ?>
		<div class="actions">
			<?php echo "<?php echo \$this->Html->link(
			__('Edit " . Inflector::humanize(Inflector::underscore($alias)) . "'),
			array(
				'controller' => '{$details['controller']}',
				'action' => 'edit',
				\${$singularVar}['{$alias}']['{$details['primaryKey']}']
			),
		   	array(
		   		'class' => 'btn btn-primary'
		   	)
		);?>\n";?>
		</div>
	</div>
	<?php
	endforeach;
endif;
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	?>
<div class="related">
	<h3><?php echo "<?php echo __('Related " . $otherPluralHumanName . "'); ?>"; ?></h3>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
	<table class="table table-bordered table-hover table-condensed table-striped">
	<thead>
	<tr>
<?php
			foreach ($details['fields'] as $field) {
				echo "\t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
			}
?>
		<th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
	</tr>
	</thead>
	<tbody>
<?php
echo "\t<?php
		\$i = 0;
		foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
		echo "\t\t<tr>\n";
			foreach ($details['fields'] as $field) {
				echo "\t\t\t<td><?php echo \${$otherSingularVar}['{$field}']; ?></td>\n";
			}

			echo "\t\t\t<td class=\"actions\">\n";
			echo "\t\t\t\t<?php echo \$this->Html->link(
				'<i class=\"icon-zoom-in\"></i>',
				array(
					'controller' => '{$details['controller']}',
					'action' => 'view',
					\${$otherSingularVar}['{$details['primaryKey']}']
				),
                array(
                    'escape' => false
                )
			); ?>\n";
			echo "\t\t\t\t<?php echo \$this->Html->link(
				'<i class=\"icon-edit\"></i>',
				array(
					'controller' => '{$details['controller']}',
					'action' => 'edit',
					\${$otherSingularVar}['{$details['primaryKey']}']
				),
                array(
                    'escape' => false
                )
			); ?>\n";
			echo "\t\t\t\t<?php echo \$this->Form->postLink(
				'<i class=\"icon-remove\"></i>',
				array(
					'controller' => '{$details['controller']}',
					'action' => 'delete',
					\${$otherSingularVar}['{$details['primaryKey']}']
				),
                array(
                    'escape' => false
                ),
				__('Are you sure you want to delete # %s?', \${$otherSingularVar}['{$details['primaryKey']}'])
			); ?>\n";
			echo "\t\t\t</td>\n";
		echo "\t\t</tr>\n";

echo "\t<?php endforeach; ?>\n";
?>
	</tbody>
	</table>
<?php echo "<?php endif; ?>\n\n"; ?>
	<div class="actions">
	<?php echo "<?php echo \$this->Html->link(
		__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'),
		array(
			'controller' => '{$details['controller']}',
			'action' => 'add'
		),
		array(
			'class' => 'btn btn-primary'
		)
	); ?>";?>
	</div>
</div>
<?php endforeach; ?>
