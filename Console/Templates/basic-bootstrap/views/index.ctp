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
    <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
        <?php echo h($singularHumanName);?>
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <!-- dropdown menu links -->
        <li><?php echo "<?php echo \$this->Html->link(
            __('New " . $singularHumanName . "'),
            array(
                'action' => 'add'
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
                $done[] = $details['controller'];
                echo PHP_EOL, '        </div>';
            }
        }
    }
    echo PHP_EOL, '</div>';
?>
<div class="<?php echo $pluralVar; ?> index">
    <h2><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h2>
    <table class="table table-bordered table-hover table-condensed table-striped">
        <thead>
            <tr>
    <?php foreach ($fields as $field): ?>
                <th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
    <?php endforeach; ?>
                <th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
            </tr>
        </thead>
        <tbody>
    <?php
    echo "<?php foreach (\${$pluralVar} as \${$singularVar}) { ?>\n";?>
        <tr>
            <?php
        foreach ($fields as $field) {
            $isKey = false;
            if (!empty($associations['belongsTo'])) {
                foreach ($associations['belongsTo'] as $alias => $details) {
                    if ($field === $details['foreignKey']) {
                        $isKey = true;
                        echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
                        break;
                    }
                }
            }
            if ($isKey !== true) {
                echo '<td><?php echo h($', $singularVar, '[\'', $modelClass, '\'][\'', $field, '\']);?>&nbsp;</td>', PHP_EOL;
                ?>
            <?php
            }
        }

        echo '<td class="actions">
                <?php echo $this->Html->link(
                    \'<i class="icon-zoom-in"></i>\',
                    array(
                        \'action\' => \'view\',
                        $', $singularVar, '[\'', $modelClass, '\'][\''. $primaryKey, '\'],
                    ),
                    array(
                        \'escape\' => false
                    )
                ); ?>
                <?php echo $this->Html->link(
                    \'<i class="icon-edit"></i>\',
                    array(
                        \'action\' => \'edit\',
                        $', $singularVar, '[\'', $modelClass, '\'][\''. $primaryKey, '\'],
                    ),
                    array(
                        \'escape\' => false
                    )
                ); ?>
                <?php echo $this->Form->postLink(
                    \'<i class="icon-remove"></i>\',
                    array(
                        \'action\' => \'delete\',
                        $', $singularVar, '[\'', $modelClass, '\'][\''. $primaryKey, '\'],
                    ),
                    array(
                        \'escape\' => false
                    ),
                     __(
                        \'Are you sure you want to delete # %s?\',
                        $', $singularVar, '[\'', $modelClass, '\'][\''. $primaryKey, '\']',
                    ')
                );?>
            </td>', PHP_EOL, '        ';
    echo "</tr>\n";

    echo "    <?php } ?>\n";
    ?>
        </tbody>
    </table>
    <p>
    <?php echo '<?php if ($this->Paginator->numbers()) {
    echo $this->Paginator->counter(array(
    \'format\' => __(\'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}\')
    ));
    ?>  </p>
    <div class="pagination">
        <ul>
        <?php
        echo $this->Paginator->first(
            \'« \' . __(\'First\'),
            array(
                \'tag\' => \'li\',
            ),
            null,
            array(
                \'class\' => \'prev disabled\',
                \'tag\' => \'li\',
                \'disabledTag\' => \'span\'
            )
        );
        echo $this->Paginator->prev(
            \'« \' . __(\'Previous\'),
            array(
                \'tag\' => \'li\',
            ),
            null,
            array(
                \'class\' => \'prev disabled\',
                \'tag\' => \'li\',
                \'disabledTag\' => \'span\'
            )
        );
        echo $this->Paginator->numbers(
            array(
                \'separator\' => \'\',
                \'tag\' => \'li\',
                \'currentTag\' => \'span\'
            )
        );
        echo $this->Paginator->next(
            __(\'Next\') . \' »\',
            array(
                \'tag\' => \'li\'
            ),
            null,
            array(
                \'class\' => \'next disabled\',
                \'tag\' => \'li\',
                \'disabledTag\' => \'span\'
            )
        );
        echo $this->Paginator->last(
            __(\'Last\') . \' »\',
            array(
                \'tag\' => \'li\'
            ),
            null,
            array(
                \'class\' => \'next disabled\',
                \'tag\' => \'li\',
                \'disabledTag\' => \'span\'
            )
        );
        ?>
        </ul>
    </div>
    <?php
    }
    ?>';
?>
</div>